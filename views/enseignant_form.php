<?php

/**
 * Vue Formulaire Enseignant (Ajout/Édition)
 */
$isEdit = isset($enseignant) && $enseignant != null;
$pageTitle = $isEdit ? "Éditer Enseignant" : "Ajouter Enseignant";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-header h1 {
            color: #333;
            margin: 0 0 10px 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group small {
            display: block;
            margin-top: 5px;
            color: #666;
        }

        .required {
            color: #dc3545;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            flex: 1;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-submit {
            background-color: #007bff;
            color: white;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-header">
            <h1><?php echo $pageTitle; ?></h1>
            <p>Complétez le formulaire ci-dessous</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="../controllers/EnseignantController.php" id="enseignantForm">
            <input type="hidden" name="action" value="<?php echo $isEdit ? 'update' : 'add'; ?>">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?php echo $enseignant['id_enseignant']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="nom_ens">Nom <span class="required">*</span></label>
                <input type="text" id="nom_ens" name="nom_ens" required
                    value="<?php echo $isEdit ? htmlspecialchars($enseignant['nom_ens']) : ''; ?>">
                <small>Entrez le nom complet de l'enseignant</small>
            </div>

            <div class="form-group">
                <label for="matricule_ens">Matricule <span class="required">*</span></label>
                <input type="text" id="matricule_ens" name="matricule_ens" required
                    value="<?php echo $isEdit ? htmlspecialchars($enseignant['matricule_ens']) : ''; ?>">
                <small>Numéro de matricule unique</small>
            </div>

            <div class="form-group">
                <label for="email_ens">Email <span class="required">*</span></label>
                <input type="email" id="email_ens" name="email_ens" required
                    value="<?php echo $isEdit ? htmlspecialchars($enseignant['email_ens']) : ''; ?>">
                <small>Adresse email de l'enseignant</small>
            </div>

            <div class="form-group">
                <label for="grade">Grade <span class="required">*</span></label>
                <select id="grade" name="grade" required>
                    <option value="">-- Sélectionner un grade --</option>
                    <option value="Professeur" <?php echo ($isEdit && $enseignant['grade'] === 'Professeur') ? 'selected' : ''; ?>>Professeur</option>
                    <option value="Maître de Conférences" <?php echo ($isEdit && $enseignant['grade'] === 'Maître de Conférences') ? 'selected' : ''; ?>>Maître de Conférences</option>
                    <option value="Assistant" <?php echo ($isEdit && $enseignant['grade'] === 'Assistant') ? 'selected' : ''; ?>>Assistant</option>
                    <option value="Chargé de Cours" <?php echo ($isEdit && $enseignant['grade'] === 'Chargé de Cours') ? 'selected' : ''; ?>>Chargé de Cours</option>
                </select>
                <small>Sélectionnez le grade académique</small>
            </div>

            <div class="form-group">
                <label for="heures_service">Heures de Service <span class="required">*</span></label>
                <input type="number" id="heures_service" name="heures_service" min="0" step="0.5" required
                    value="<?php echo $isEdit ? htmlspecialchars($enseignant['heures_service']) : ''; ?>">
                <small>Nombre d'heures de service par semaine</small>
            </div>

            <div class="form-group">
                <label for="id_departement">Département</label>
                <input type="number" id="id_departement" name="id_departement"
                    value="<?php echo $isEdit ? htmlspecialchars($enseignant['id_departement']) : ''; ?>">
                <small>ID du département (optionnel)</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-submit">
                    <?php echo $isEdit ? 'Mettre à jour' : 'Ajouter'; ?>
                </button>
                <a href="enseignant.php" class="btn btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>