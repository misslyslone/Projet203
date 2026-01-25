<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'gestion_ecole';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $matricule = isset($_POST['matricule']) ? trim($_POST['matricule']) : '';
    
    // Validation des données
    if (empty($email) && empty($matricule)) {
        $error = "Veuillez saisir au moins l'email ou le matricule.";
    } else {
        // Recherche de l'enseignant
        $sql = "SELECT id, matricule, nom, prenom, email 
                FROM enseignants 
                WHERE (email = :email AND :email != '') 
                   OR (matricule = :matricule AND :matricule != '')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':matricule' => $matricule
        ]);
        
        $enseignant = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($enseignant) {
            // Récupérer l'emploi du temps de l'enseignant
            $sql_emploi = "SELECT jour, heure_debut, heure_fin, id_ue, classe, salle, nom_ens, matricule_ens
                          FROM seance s, enseignant ens, ue u, classe c, salle sal
                          WHERE s.enseignant_id = ens.id
                            AND s.ue_id = u.id
                            AND 
                            AND s.classe_id = c.id
                            AND s.salle_id = sal.id
                            AND ens.id = :enseignant_id
                          ORDER BY 
                              FIELD(jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'),
                              heure_debut";
            
            $stmt_emploi = $pdo->prepare($sql_emploi);
            $stmt_emploi->execute([':enseignant_id' => $enseignant['id']]);
            $seances = $stmt_emploi->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $error = "Aucun enseignant trouvé avec ces identifiants.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du Temps Enseignant</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: #007bff; color: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .emploi-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .emploi-table th { background: #f2f2f2; padding: 12px; text-align: left; border-bottom: 2px solid #ddd; }
        .emploi-table td { padding: 10px; border-bottom: 1px solid #ddd; }
        .emploi-table tr:hover { background: #f5f5f5; }
        .jour-section { margin-bottom: 30px; }
        .jour-titre { background: #6c757d; color: white; padding: 10px; border-radius: 3px; }
        .no-seance { color: #6c757d; font-style: italic; }
        .action-links { margin-top: 20px; }
        .action-links a { display: inline-block; margin-right: 10px; padding: 8px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 3px; }
        .action-links a:hover { background: #545b62; }
        .creneau { font-weight: bold; color: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($error)): ?>
            <div class="error">
                <h3>Erreur</h3>
                <p><?php echo htmlspecialchars($error); ?></p>
                <a href="form_search.php">← Retour au formulaire</a>
            </div>
        <?php elseif (isset($enseignant)): ?>
            <!-- En-tête avec informations de l'enseignant -->
            <div class="header">
                <h1>Emploi du Temps - <?php echo htmlspecialchars($enseignant['prenom'] . ' ' . $enseignant['nom']); ?></h1>
                <p>Matricule : <?php echo htmlspecialchars($enseignant['matricule']); ?> | 
                   Email : <?php echo htmlspecialchars($enseignant['email']); ?></p>
            </div>
            
            <!-- Affichage de l'emploi du temps -->
            <?php if (empty($seances)): ?>
                <p class="no-seance">Aucune séance programmée pour cet enseignant.</p>
            <?php else: ?>
                <!-- Version 1 : Tableau complet -->
                <h2>Tableau des séances</h2>
                <table class="emploi-table">
                    <thead>
                        <tr>
                            <th>Jour</th>
                            <th>Créneau horaire</th>
                            <th>Matière</th>
                            <th>Classe</th>
                            <th>Salle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($seances as $seance): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($seance['jour']); ?></strong></td>
                                <td class="creneau">
                                    <?php echo date('H:i', strtotime($seance['heure_debut'])) . ' - ' . 
                                           date('H:i', strtotime($seance['heure_fin'])); ?>
                                </td>
                                <td><?php echo htmlspecialchars($seance['matiere']); ?></td>
                                <td><?php echo htmlspecialchars($seance['classe']); ?></td>
                                <td><?php echo htmlspecialchars($seance['salle']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <!-- Version 2 : Groupé par jour (alternative) -->
                <h2 style="margin-top: 40px;">Organisation par jour</h2>
                <?php
                // Grouper les séances par jour
                $seances_par_jour = [];
                $jours_ordre = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                
                foreach ($seances as $seance) {
                    $seances_par_jour[$seance['jour']][] = $seance;
                }
                
                foreach ($jours_ordre as $jour) {
                    if (isset($seances_par_jour[$jour])): ?>
                        <div class="jour-section">
                            <h3 class="jour-titre"><?php echo htmlspecialchars($jour); ?></h3>
                            <table class="emploi-table">
                                <thead>
                                    <tr>
                                        <th>Horaire</th>
                                        <th>Matière</th>
                                        <th>Classe</th>
                                        <th>Salle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($seances_par_jour[$jour] as $seance): ?>
                                        <tr>
                                            <td class="creneau">
                                                <?php echo date('H:i', strtotime($seance['heure_debut'])) . ' - ' . 
                                                       date('H:i', strtotime($seance['heure_fin'])); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($seance['matiere']); ?></td>
                                            <td><?php echo htmlspecialchars($seance['classe']); ?></td>
                                            <td><?php echo htmlspecialchars($seance['salle']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif;
                }
                ?>
            <?php endif; ?>
            
            <div class="action-links">
                <a href="form_search.php">Nouvelle recherche</a>
                <a href="#" onclick="window.print()">Imprimer l'emploi du temps</a>
            </div>
            
        <?php else: ?>
            <p>Veuillez utiliser le formulaire pour rechercher un enseignant.</p>
            <a href="form_search.php">Accéder au formulaire</a>
        <?php endif; ?>
    </div>
</body>
</html>