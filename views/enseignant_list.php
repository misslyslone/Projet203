<?php

/**
 * Vue Liste des Enseignants
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Enseignants</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-section h1 {
            color: #333;
            margin: 0;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .table-responsive {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-small {
            padding: 5px 10px;
            font-size: 12px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-view {
            background-color: #28a745;
            color: white;
        }

        .btn-view:hover {
            background-color: #218838;
        }

        .btn-edit {
            background-color: #ffc107;
            color: black;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-section">
            <h1>Gestion des Enseignants</h1>
            <a href="enseignant.php?action=add" class="btn-primary">+ Ajouter Enseignant</a>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'success'; ?>">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']);
            unset($_SESSION['message_type']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($enseignants) && count($enseignants) > 0): ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Grade</th>
                            <th>Heures Service</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enseignants as $enseignant): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($enseignant['id_enseignant']); ?></td>
                                <td><?php echo htmlspecialchars($enseignant['matricule_ens']); ?></td>
                                <td><?php echo htmlspecialchars($enseignant['nom_ens']); ?></td>
                                <td><?php echo htmlspecialchars($enseignant['email_ens']); ?></td>
                                <td><?php echo htmlspecialchars($enseignant['grade']); ?></td>
                                <td><?php echo htmlspecialchars($enseignant['heures_service']); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="enseignant.php?action=view&id=<?php echo $enseignant['id_enseignant']; ?>"
                                            class="btn-small btn-view">Voir</a>
                                        <a href="enseignant.php?action=edit&id=<?php echo $enseignant['id_enseignant']; ?>"
                                            class="btn-small btn-edit">Éditer</a>
                                        <a href="../controllers/EnseignantController.php?action=delete&id=<?php echo $enseignant['id_enseignant']; ?>"
                                            class="btn-small btn-delete"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant?')">
                                            Supprimer
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Aucun enseignant trouvé.</p>
                <a href="enseignant.php?action=add" class="btn-primary">Ajouter le premier enseignant</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>