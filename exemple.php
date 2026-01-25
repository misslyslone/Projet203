<?php
session_start();
include 'connexion.php'; // Fichier de connexion de la base de données

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupération et sécurisation des données du formulaire
    $email = htmlspecialchars(trim($_POST['email']));
    $filiere = htmlspecialchars(trim($_POST['filiere']));
    $classe = htmlspecialchars(trim($_POST['classe']));
    
    // Validation des champs obligatoires
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide.";
    }
    
    if (empty($filiere)) {
        $errors[] = "La filière est obligatoire.";
    }
    
    if (empty($classe)) {
        $errors[] = "La classe est obligatoire.";
    }
    
    // Si des erreurs, afficher les messages
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: login-etudiant.php");
        exit();
    }
    
    try {
        // 1. Vérifier que l'étudiant existe dans la base de données
        $query_check = "SELECT e.id_etudiant, e.nom, u.id_utilisateur 
                       FROM etudiant e 
                       JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur 
                       WHERE u.email = :email";
        
        $stmt_check = $pdo->prepare($query_check);
        $stmt_check->execute([':email' => $email]);
        $etudiant = $stmt_check->fetch(PDO::FETCH_ASSOC);
        
        if (!$etudiant) {
            $_SESSION['error'] = "Aucun étudiant trouvé avec cet email.";
            header("Location: login-etudiant.php");
            exit();
        }
        
        // 2. Récupérer l'emploi du temps de la classe
        $query_emploi = "
        SELECT s.jour,s.heure_debut,s.heure_fin, s.date_seance,s.type_seance, e.nom_ens,c.nom_classe,f.code_filiere,u.intitule 
        FROM  seance s,enseignant e,classe c, filiere f, ues u
        WHERE s.id_enseignant = e.id_enseignant
        AND c.id_filiere = f.id_filiere
        AND s.id_classe = c.id_classe
        AND s.id_ue = u.id_ue

"
;

    // Ajouter les conditions seulement si les paramètres sont fournis
    $params = [];

    if (!empty($filiere)) {
        $query_emploi .= " AND f.code_filiere LIKE :filiere";
        $params[':filiere'] = '%' . $filiere . '%';
    }

    if (!empty($classe)) {
        $query_emploi .= " AND c.nom_classe LIKE :classe";
        $params[':classe'] = '%' . $classe . '%';
    }

    $query_emploi .= " ORDER BY 
        FIELD(s.jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'),
        s.date_seance,
        s.heure_debut";

    $stmt_emploi = $pdo->prepare($query_emploi);
    $stmt_emploi->execute($params);
    $emploi_temps = $stmt_emploi->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de base de données : " . $e->getMessage();
        header("Location: login-etudiant.php");
        exit();
    }
    
} else {
    // Redirection si accès direct sans formulaire
    header("Location: login-etudiant.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du temps - <?php echo htmlspecialchars($classe); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #4a90e2;
        }
        
        .header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .info-etudiant {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #4a90e2;
        }
        
        .info-etudiant p {
            margin-bottom: 5px;
        }
        
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .info-filiere {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        th {
            background-color: #4a90e2;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f1f8ff;
        }
        
        .type-seance {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .type-cm { background-color: #3498db; color: white; }
        .type-td { background-color: #2ecc71; color: white; }
        .type-tp { background-color: #e74c3c; color: white; }
        .type-examen { background-color: #9b59b6; color: white; }
        .type-rattrapage { background-color: #f39c12; color: white; }
        
        .jour-separator {
            background-color: #2c3e50;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            margin: 20px 0 10px 0;
            border-radius: 5px;
        }
        
        .actions {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn:hover {
            background-color: #357ae8;
        }
        
        .btn-print {
            background-color: #27ae60;
            margin-left: 10px;
        }
        
        .btn-print:hover {
            background-color: #219653;
        }
        
        @media print {
            .actions, .btn {
                display: none;
            }
            
            body {
                background-color: white;
            }
            
            .container {
                box-shadow: none;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            th, td {
                padding: 8px 10px;
                font-size: 14px;
            }
            
            .header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📅 Emploi du temps</h1>
            <p>Année universitaire 2025-2026</p>
        </div>
        
        <div class="info-etudiant">
            <p><strong>Étudiant :</strong> <?php echo htmlspecialchars($etudiant['nom'] ?? 'Non spécifié'); ?></p>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Date de consultation :</strong> <?php echo date('d/m/Y H:i'); ?></p>
        </div>
        
        <div class="info-filiere">
            📚 Filière : <?php echo htmlspecialchars($filiere); ?> 
            | 🏫 Classe : <?php echo htmlspecialchars($classe); ?>
            <?php if (!empty($emploi_temps[0]['nom_departement'])): ?>
                | 🏢 Département : <?php echo htmlspecialchars($emploi_temps[0]['nom_departement']); ?>
            <?php endif; ?>
        </div>
        
        <?php if (isset($message)): ?>
            <div class="message error">
                <?php echo $message; ?>
            </div>
        <?php elseif (!empty($emploi_temps)): ?>
            <div class="table-container">
                <?php
                $current_day = null;
                foreach ($emploi_temps as $index => $seance):
                    // Afficher un séparateur pour chaque nouveau jour
                    if ($seance['jour'] != $current_day):
                        $current_day = $seance['jour']; 
                ?>
                        <div class="jour-separator">
                            <?php echo htmlspecialchars($seance['jour']); ?>
                            <?php if (!empty($seance['date_seance'])): ?>
                                (<?php echo date('d/m/Y', strtotime($seance['date_seance'])); ?>)
                            <?php endif; ?>
                        </div>
                        
                        <table>
                            <thead>
                                <tr>
                                    <th>Heure</th>
                                    <th>UE</th>
                                    <th>Intitulé</th>
                                    <th>Type</th>
                                    <th>Professeur</th>
                                    <th>Salle</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php endif; ?>
                    
                    <tr>
                        <td>
                            ⏰ <?php echo date('H:i', strtotime($seance['heure_debut'])); ?> 
                            - <?php echo date('H:i', strtotime($seance['heure_fin'])); ?>
                        </td>
                        <td><strong><?php echo htmlspecialchars($seance['code_ue']); ?></strong></td>
                        <td><?php echo htmlspecialchars($seance['nom_ue']); ?></td>
                        <td>
                            <span class="type-seance type-<?php echo strtolower($seance['type_seance']); ?>">
                                <?php echo htmlspecialchars($seance['type_seance']); ?>
                            </span>
                        </td>
                        <td>👨‍🏫 <?php echo htmlspecialchars($seance['nom_professeur']); ?></td>
                        <td>
                            <?php if (!empty($seance['nom_salle'])): ?>
                                🏠 <?php echo htmlspecialchars($seance['nom_salle']); ?>
                            <?php else: ?>
                                <em>Non attribuée</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                    
                    <?php
                    // Fermer le tableau si c'est le dernier élément ou si le jour suivant est différent
                    $next_seance = $emploi_temps[$index + 1] ?? null;
                    if (!$next_seance || $next_seance['jour'] != $current_day):
                    ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    
                <?php endforeach; ?>
            </div>
            
            <div class="actions">
                <button onclick="window.print()" class="btn btn-print">🖨️ Imprimer l'emploi du temps</button>
                <a href="login-etudiant.php" class="btn">↩️ Nouvelle recherche</a>
            </div>
            
        <?php else: ?>
            <div class="actions"> 
                 <a href="login-etudiant.php" class="btn">↩️ Retour au formulaire</a> 
            </div> 
        <?php endif; ?>
    </div>
    
    <script>
        // Script pour améliorer l'expérience utilisateur
        document.addEventListener('DOMContentLoaded', function() {
            // Ajouter un effet de surbrillance sur les lignes du tableau
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
                    this.style.transition = 'all 0.3s ease';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });
            
            // Confirmation avant impression
            const printBtn = document.querySelector('.btn-print');
            if (printBtn) {
                printBtn.addEventListener('click', function(e) {
                    if (!confirm("Voulez-vous imprimer cet emploi du temps ?")) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</body>
</html>