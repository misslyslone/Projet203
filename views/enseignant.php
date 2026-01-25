<?php

/**
 * Vue Principale des Enseignants
 */

session_start();

// Vérifier l'authentification
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login-etudiant.php");
    exit;
}

// Inclure les fichiers nécessaires
require_once '../controllers/EnseignantController.php';
require_once '../models/connexion.php';

// Initialiser le contrôleur
$enseignantController = new EnseignantController($db);

// Récupérer l'action
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Gérer les actions
switch ($action) {
    case 'view':
        if (isset($_GET['id'])) {
            $enseignant = $enseignantController->getById($_GET['id']);
            if ($enseignant) {
                include 'enseignant_detail.php';
            } else {
                $_SESSION['error'] = "Enseignant non trouvé";
                header("Location: enseignant.php");
                exit;
            }
        }
        break;
    case 'add':
        include 'enseignant_form.php';
        break;
    case 'edit':
        if (isset($_GET['id'])) {
            $enseignant = $enseignantController->getById($_GET['id']);
            if ($enseignant) {
                include 'enseignant_form.php';
            } else {
                $_SESSION['error'] = "Enseignant non trouvé";
                header("Location: enseignant.php");
                exit;
            }
        }
        break;
    case 'list':
    default:
        $enseignants = $enseignantController->getAll();
        include 'enseignant_list.php';
        break;
}
