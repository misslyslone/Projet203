<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Emploi du Temps</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 500px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #4a90e2 0%, #357ae8 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 16px;
        }
        
        .form-container {
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        input, select {
            width: 100%;
            padding: 14px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }
        
        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #4a90e2 0%, #357ae8 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(74, 144, 226, 0.2);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .error {
            background-color: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c62828;
            font-size: 14px;
        }
        
        .success {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #2e7d32;
            font-size: 14px;
        }
        
        .info {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
        
        .info a {
            color: #4a90e2;
            text-decoration: none;
        }
        
        .info a:hover {
            text-decoration: underline;
        }
        
        .icon {
            display: inline-block;
            margin-right: 10px;
            vertical-align: middle;
        }
        
        @media (max-width: 600px) {
            .container {
                max-width: 100%;
            }
            
            .header, .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📅 Emploi du Temps</h1>
            <p>Consultez votre emploi du temps universitaire</p>
        </div>
        
        <div class="form-container">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error">
                    ❌ <?php echo htmlspecialchars($_SESSION['error']); ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['errors'])): ?>
                <div class="error">
                    ❌ Erreurs :
                    <ul style="margin-left: 20px; margin-top: 5px;">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php unset($_SESSION['errors']); ?>
                </div>
            <?php endif; ?> 
            
            <form action="emploiE.php" method="POST">
                <div class="form-group">
                    <label for="email">📧 Email Universitaire</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           placeholder="votre.email@universite.com" 
                           required
                           value="<?php echo isset($_SESSION['old_email']) ? htmlspecialchars($_SESSION['old_email']) : ''; 
                                  unset($_SESSION['old_email']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="filiere">🎓 Filière</label>
                    <select id="filiere" name="filiere" required>
                        <option value="">Sélectionnez votre filière</option>
                        <option value="Informatique">ICT4D</option>
                        <option value="Mathématiques">Mathématiques</option>
                        <option value="Physique">Physique</option>
                        <option value="Chimie">Chimie</option>
                        <option value="Biologie">Biologie</option>
                        <option value="Génie Civil">Génie Civil</option>
                        <option value="Électronique">Électronique</option>
                        <option value="Gestion">Gestion</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="classe">🏫 Classe</label>
                    <select id="classe" name="classe" required>
                        <option value="">Sélectionnez votre classe</option>
                        <option value="1">ICT-L1</option>
                        <option value="2">ICT-L2</option>
                        <option value="3">ICT-L3</option>
                    </select>
                    
                </div>
                
                <button type="submit" class="btn">
                    🔍 Consulter l'emploi du temps
                </button>
            </form>
            
            <div class="info">
                <p>⚠️ Vous devez utiliser votre email universitaire pour accéder à votre emploi du temps.</p>
                <p>En cas de problème, contactez le service scolarité.</p>
            </div>
        </div>
    </div>
    
    <script>
        // Script pour améliorer l'expérience utilisateur
        document.addEventListener('DOMContentLoaded', function() {
            // Sauvegarder les valeurs des champs en sessionStorage
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, select');
            
            inputs.forEach(input => {
                // Restaurer les valeurs depuis sessionStorage
                const savedValue = sessionStorage.getItem(input.name);
                if (savedValue && !input.value) {
                    input.value = savedValue;
                }
                
                // Sauvegarder les valeurs lors de la saisie
                input.addEventListener('input', function() {
                    sessionStorage.setItem(this.name, this.value);
                });
            });
            
            // Effacer les données sauvegardées lors de la soumission réussie
            form.addEventListener('submit', function() {
                inputs.forEach(input => {
                    sessionStorage.removeItem(input.name);
                });
            });
            
            // Animation de focus
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>