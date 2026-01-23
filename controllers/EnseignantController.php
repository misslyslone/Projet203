<?php

require_once '../models/EnseignantModel.php';

class EnseignantController {
    
    private $model;
    
    public function __construct($connexion) {
        $this->model = new EnseignantModel($connexion);
    }
    
    /**
     * Afficher tous les enseignants
     */
    public function listAll() {
        try {
            $enseignants = $this->model->getAll();
            return [
                'success' => true,
                'data' => $enseignants,
                'count' => count($enseignants)
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Afficher un enseignant spécifique
     */
    public function getDetail($id) {
        try {
            if (empty($id) || !is_numeric($id)) {
                return [
                    'success' => false,
                    'message' => 'ID enseignant invalide'
                ];
            }
            
            $enseignant = $this->model->getById($id);
            
            if (!$enseignant) {
                return [
                    'success' => false,
                    'message' => 'Enseignant non trouvé'
                ];
            }
            
            return [
                'success' => true,
                'data' => $enseignant
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Afficher les enseignants d'un département
     */
    public function listByDepartement($id_departement) {
        try {
            if (empty($id_departement) || !is_numeric($id_departement)) {
                return [
                    'success' => false,
                    'message' => 'ID département invalide'
                ];
            }
            
            $enseignants = $this->model->getByDepartement($id_departement);
            
            return [
                'success' => true,
                'data' => $enseignants,
                'count' => count($enseignants)
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Créer un nouvel enseignant
     */
    public function create($data) {
        try {
            // Validation des données obligatoires
            $required_fields = ['id_utilisateur', 'grade', 'heures_service', 'id_departement', 'nom_ens', 'email_ens', 'matricule_ens'];
            
            foreach ($required_fields as $field) {
                if (empty($data[$field])) {
                    return [
                        'success' => false,
                        'message' => "Le champ '$field' est obligatoire"
                    ];
                }
            }
            
            // Validation du grade
            $grades_valides = ['PROFESSEUR', 'MCF', 'ATER', 'VACATAIRE'];
            if (!in_array($data['grade'], $grades_valides)) {
                return [
                    'success' => false,
                    'message' => 'Grade invalide. Valeurs acceptées: ' . implode(', ', $grades_valides)
                ];
            }
            
            // Validation de l'email
            if (!filter_var($data['email_ens'], FILTER_VALIDATE_EMAIL)) {
                return [
                    'success' => false,
                    'message' => 'Format d\'email invalide'
                ];
            }
            
            // Validation des heures de service
            if (!is_numeric($data['heures_service']) || $data['heures_service'] < 0) {
                return [
                    'success' => false,
                    'message' => 'Les heures de service doivent être un nombre positif'
                ];
            }
            
            // Vérifier si l'email existe déjà
            if ($this->model->getByEmail($data['email_ens'])) {
                return [
                    'success' => false,
                    'message' => 'Cet email est déjà utilisé'
                ];
            }
            
            // Vérifier si le matricule existe déjà
            if ($this->model->getByMatricule($data['matricule_ens'])) {
                return [
                    'success' => false,
                    'message' => 'Ce matricule est déjà utilisé'
                ];
            }
            
            // Ajouter l'enseignant
            $result = $this->model->add($data);
            
            return $result;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Mettre à jour un enseignant
     */
    public function update($id, $data) {
        try {
            if (empty($id) || !is_numeric($id)) {
                return [
                    'success' => false,
                    'message' => 'ID enseignant invalide'
                ];
            }
            
            // Vérifier que l'enseignant existe
            $enseignant = $this->model->getById($id);
            if (!$enseignant) {
                return [
                    'success' => false,
                    'message' => 'Enseignant non trouvé'
                ];
            }
            
            // Validation du grade si fourni
            if (!empty($data['grade'])) {
                $grades_valides = ['PROFESSEUR', 'MCF', 'ATER', 'VACATAIRE'];
                if (!in_array($data['grade'], $grades_valides)) {
                    return [
                        'success' => false,
                        'message' => 'Grade invalide'
                    ];
                }
            }
            
            // Validation de l'email si fourni
            if (!empty($data['email_ens'])) {
                if (!filter_var($data['email_ens'], FILTER_VALIDATE_EMAIL)) {
                    return [
                        'success' => false,
                        'message' => 'Format d\'email invalide'
                    ];
                }
                
                // Vérifier que le nouvel email n'existe pas (sauf pour l'enseignant lui-même)
                $autre_enseignant = $this->model->getByEmail($data['email_ens']);
                if ($autre_enseignant && $autre_enseignant['id_enseignant'] != $id) {
                    return [
                        'success' => false,
                        'message' => 'Cet email est déjà utilisé par un autre enseignant'
                    ];
                }
            }
            
            // Validation des heures de service si fourni
            if (isset($data['heures_service']) && !empty($data['heures_service'])) {
                if (!is_numeric($data['heures_service']) || $data['heures_service'] < 0) {
                    return [
                        'success' => false,
                        'message' => 'Les heures de service doivent être un nombre positif'
                    ];
                }
            }
            
            // Mettre à jour l'enseignant
            $result = $this->model->update($id, $data);
            
            return $result;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Supprimer un enseignant
     */
    public function delete($id) {
        try {
            if (empty($id) || !is_numeric($id)) {
                return [
                    'success' => false,
                    'message' => 'ID enseignant invalide'
                ];
            }
            
            // Vérifier que l'enseignant existe
            $enseignant = $this->model->getById($id);
            if (!$enseignant) {
                return [
                    'success' => false,
                    'message' => 'Enseignant non trouvé'
                ];
            }
            
            // Supprimer l'enseignant
            $result = $this->model->delete($id);
            
            return $result;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Rechercher un enseignant par email
     */
    public function searchByEmail($email) {
        try {
            if (empty($email)) {
                return [
                    'success' => false,
                    'message' => 'Email requis'
                ];
            }
            
            $enseignant = $this->model->getByEmail($email);
            
            if (!$enseignant) {
                return [
                    'success' => false,
                    'message' => 'Enseignant non trouvé'
                ];
            }
            
            return [
                'success' => true,
                'data' => $enseignant
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Récupérer les statistiques des enseignants
     */
    public function getStatistics() {
        try {
            $total = $this->model->count();
            
            return [
                'success' => true,
                'total_enseignants' => $total
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Afficher l'emploi de temps d'un enseignant
     */
    public function getEmploiDeTemps($id_enseignant) {
        try {
            if (empty($id_enseignant) || !is_numeric($id_enseignant)) {
                return [
                    'success' => false,
                    'message' => 'ID enseignant invalide'
                ];
            }
            
            // Vérifier que l'enseignant existe
            $enseignant = $this->model->getById($id_enseignant);
            if (!$enseignant) {
                return [
                    'success' => false,
                    'message' => 'Enseignant non trouvé'
                ];
            }
            
            // Récupérer l'emploi de temps
            $emploi_temps = $this->model->getEmploiDeTemps($id_enseignant);
            
            return [
                'success' => true,
                'data' => $emploi_temps,
                'count' => count($emploi_temps),
                'enseignant' => $enseignant['nom_ens']
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }
}

?>
