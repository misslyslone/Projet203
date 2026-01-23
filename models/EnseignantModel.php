<?php
include 'connexion.php'; // Fichier de connexion de la base de données
class EnseignantModel {
    
    private $connexion;
    
    public function __construct($connexion) {
        $this->connexion = $connexion;
    }
    
    /**
     * Récupérer tous les enseignants
     */
    public function getAll() {
        try {
            $query = "SELECT * FROM enseignant";
            $result = $this->connexion->query($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Erreur lors de la récupération des enseignants: " . $e->getMessage();
            return [];
        }
    }
    
    /**
     * Récupérer un enseignant par son ID
     */
    public function getById($id) {
        try {
            $query = "SELECT * FROM enseignant WHERE id_enseignant = ?";
            $stmt = $this->connexion->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            echo "Erreur lors de la récupération de l'enseignant: " . $e->getMessage();
            return null;
        }
    }
    
    /**
     * Récupérer un enseignant par son email
     */
    public function getByEmail($email) {
        try {
            $query = "SELECT * FROM enseignant WHERE email_ens = ?";
            $stmt = $this->connexion->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            echo "Erreur lors de la récupération de l'enseignant: " . $e->getMessage();
            return null;
        }
    }
    
    /**
     * Récupérer un enseignant par son matricule
     */
    public function getByMatricule($matricule) {
        try {
            $query = "SELECT * FROM enseignant WHERE matricule_ens = ?";
            $stmt = $this->connexion->prepare($query);
            $stmt->bind_param("s", $matricule);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            echo "Erreur lors de la récupération de l'enseignant: " . $e->getMessage();
            return null;
        }
    }
    
    /**
     * Récupérer les enseignants d'un département
     */
    public function getByDepartement($id_departement) {
        try {
            $query = "SELECT * FROM enseignant WHERE id_departement = ?";
            $stmt = $this->connexion->prepare($query);
            $stmt->bind_param("i", $id_departement);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Erreur lors de la récupération des enseignants du département: " . $e->getMessage();
            return [];
        }
    }
    
    /**
     * Ajouter un nouvel enseignant
     */
    public function add($data) {
        try {
            $query = "INSERT INTO enseignant (id_utilisateur, grade, heures_service, id_departement, nom_ens, email_ens, matricule_ens) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connexion->prepare($query);
            $stmt->bind_param(
                "isiiiss",
                $data['id_utilisateur'],
                $data['grade'],
                $data['heures_service'],
                $data['id_departement'],
                $data['nom_ens'],
                $data['email_ens'],
                $data['matricule_ens']
            );
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Enseignant ajouté avec succès', 'id' => $this->connexion->insert_id];
            } else {
                return ['success' => false, 'message' => 'Erreur lors de l\'ajout: ' . $stmt->error];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Exception: ' . $e->getMessage()];
        }
    }
    
    /**
     * Mettre à jour un enseignant
     */
    public function update($id, $data) {
        try {
            $query = "UPDATE enseignant SET grade = ?, heures_service = ?, nom_ens = ?, email_ens = ? 
                     WHERE id_enseignant = ?";
            $stmt = $this->connexion->prepare($query);
            $stmt->bind_param(
                "siisi",
                $data['grade'],
                $data['heures_service'],
                $data['nom_ens'],
                $data['email_ens'],
                $id
            );
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Enseignant mis à jour avec succès'];
            } else {
                return ['success' => false, 'message' => 'Erreur lors de la mise à jour: ' . $stmt->error];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Exception: ' . $e->getMessage()];
        }
    }
    
    /**
     * Supprimer un enseignant
     */
    public function delete($id) {
        try {
            $query = "DELETE FROM enseignant WHERE id_enseignant = ?";
            $stmt = $this->connexion->prepare($query);
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Enseignant supprimé avec succès'];
            } else {
                return ['success' => false, 'message' => 'Erreur lors de la suppression: ' . $stmt->error];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Exception: ' . $e->getMessage()];
        }
    }
    
    /**
     * Compter le nombre total d'enseignants
     */
    public function count() {
        try {
            $query = "SELECT COUNT(*) as total FROM enseignant";
            $result = $this->connexion->query($query);
            $row = $result->fetch_assoc();
            return $row['total'];
        } catch (Exception $e) {
            echo "Erreur lors du comptage des enseignants: " . $e->getMessage();
            return 0;
        }
    }
}

?>
