<?php

/**
 * Vue Détail d'un Enseignant
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Enseignant - <?php echo htmlspecialchars($enseignant['nom_ens']); ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
        }

        .detail-header h1 {
            color: #333;
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-edit {
            background-color: #ffc107;
            color: black;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        .detail-section {
            background-color: white;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            margin-bottom: 15px;
            align-items: center;
        }

        .detail-label {
            font-weight: 600;
            color: #666;
        }

        .detail-value {
            color: #333;
            padding-left: 20px;
        }

        .detail-value a {
            color: #007bff;
            text-decoration: none;
        }

        .detail-value a:hover {
            text-decoration: underline;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-primary {
            background-color: #cfe2ff;
            color: #084298;
        }

        .badge-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-top: 20px;
            border-radius: 3px;
        }

        .info-box h4 {
            margin-top: 0;
            color: #007bff;
        }

        @media (max-width: 768px) {
            .detail-row {
                grid-template-columns: 1fr;
            }

            .detail-value {
                padding-left: 0;
                margin-top: 5px;
            }

            .header-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if (!empty($enseignant)): ?>
            <div class="detail-header">
                <h1><?php echo htmlspecialchars($enseignant['nom_ens']); ?></h1>
                <div class="header-actions">
                    <a href="enseignant.php?action=edit&id=<?php echo $enseignant['id_enseignant']; ?>" class="btn btn-edit">Éditer</a>
                    <a href="enseignant.php" class="btn btn-back">Retour</a>
                </div>
            </div>

            <div class="detail-section">
                <div class="section-title">Informations Générales</div>

                <div class="detail-row">
                    <div class="detail-label">ID Enseignant:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($enseignant['id_enseignant']); ?></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Matricule:</div>
                    <div class="detail-value">
                        <span class="badge badge-primary"><?php echo htmlspecialchars($enseignant['matricule_ens']); ?></span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Nom Complet:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($enseignant['nom_ens']); ?></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">
                        <a href="mailto:<?php echo htmlspecialchars($enseignant['email_ens']); ?>">
                            <?php echo htmlspecialchars($enseignant['email_ens']); ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <div class="section-title">Informations Professionnelles</div>

                <div class="detail-row">
                    <div class="detail-label">Grade:</div>
                    <div class="detail-value">
                        <span class="badge badge-success"><?php echo htmlspecialchars($enseignant['grade']); ?></span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Heures de Service:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($enseignant['heures_service']); ?> heures/semaine</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Département:</div>
                    <div class="detail-value">
                        <?php
                        if (!empty($enseignant['id_departement'])) {
                            echo "Département #" . htmlspecialchars($enseignant['id_departement']);
                        } else {
                            echo "Non assigné";
                        }
                        ?>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">ID Utilisateur:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($enseignant['id_utilisateur']); ?></div>
                </div>
            </div>

            <div class="info-box">
                <h4>Note</h4>
                <p>Pour modifier les informations de cet enseignant, utilisez le bouton "Éditer" en haut à droite.</p>
            </div>

        <?php else: ?>
            <div class="detail-section">
                <p>Enseignant non trouvé.</p>
                <a href="enseignant.php" class="btn btn-back">Retour à la liste</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>