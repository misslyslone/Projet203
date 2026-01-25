<?php
include 'connexion.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche Emploi du Temps Enseignant</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 500px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Rechercher l'emploi du temps d'un enseignant</h2>
        <form action="emploi_temps.php" method="POST">
            <div class="form-group">
                <label for="email">Email professionnel :</label>
                <input type="email" id="email" name="email" placeholder="ex: nom.prenom@ecole.edu">
            </div>
            <div class="form-group">
                <label for="matricule">Matricule :</label>
                <input type="text" id="matricule" name="matricule" placeholder="ex: ENS2024001">
            </div>
            <div class="form-group">
                <p><em>Remplissez au moins un des deux champs</em></p>
            </div>
            <button type="submit">Rechercher l'emploi du temps</button>
        </form>
    </div>
</body>
</html>