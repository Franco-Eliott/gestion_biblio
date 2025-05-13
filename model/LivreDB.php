<?php
require_once 'Database.php';

class LivreDB {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function create($titre, $editeur, $prix, $nbr_exemplaire) {
        $sql = "INSERT INTO livre (titre, editeur, prix, nbr_exemplaire) VALUES (?, ?, ?, ?)";
        $params = array($titre, $editeur, $prix, $nbr_exemplaire);
        $this->database->request($sql, $params);
    }

    public function read($ref_livre) {
        $sql = "SELECT * FROM livre WHERE ref_livre = ? AND is_delete = false";
        $params = array($ref_livre);
        $req = $this->database->request($sql, $params);
        return $this->database->recover($req, true);
    }

    public function readAll() {
        $sql = "SELECT * FROM livre WHERE is_delete = false";
        $req = $this->database->request($sql);
        return $this->database->recover($req, false);
    }

    public function update($ref_livre, $titre, $editeur, $prix, $nbr_exemplaire) {
        $sql = "UPDATE livre SET titre = ?, editeur = ?, prix = ?, nbr_exemplaire = ? WHERE ref_livre = ?";
        $params = array($titre, $editeur, $prix, $nbr_exemplaire, $ref_livre);
        $this->database->request($sql, $params);
    }

    public function delete($ref_livre) {
        $sql = "UPDATE livre SET is_delete = true WHERE ref_livre = ?";
        $params = array($ref_livre);
        $this->database->request($sql, $params);
    }

    public function decrementExemplaire($ref_livre) {
        try {
            // Récupère le nombre d'exemplaires disponibles
            $query = "SELECT nbr_exemplaire FROM livre WHERE ref_livre = :ref_livre";
            $result = $this->database->request($query, [':ref_livre' => $ref_livre])->fetch(PDO::FETCH_OBJ);

            if ($result && $result->nbr_exemplaire > 0) {
                $new_nbr = $result->nbr_exemplaire - 1;
                $is_dispo = $new_nbr > 0 ? 1 : 0;
                $queryUpdate = "UPDATE livre 
                                SET nbr_exemplaire = :nbr_exemplaire, 
                                    is_dispo = :is_dispo 
                                WHERE ref_livre = :ref_livre";
                $this->database->request($queryUpdate, [
                    ':nbr_exemplaire' => $new_nbr,
                    ':is_dispo' => $is_dispo,
                    ':ref_livre' => $ref_livre
                ]);
            }
        } catch (Exception $e) {
            set_error('danger', "Erreur lors de la mise à jour du nombre d'exemplaires.", $e);
        }
    }

    public function incrementExemplaire($ref_livre) {
        try {
            // Récupère le nombre d'exemplaires disponibles
            $query = "SELECT nbr_exemplaire FROM livre WHERE ref_livre = :ref_livre";
            $result = $this->database->request($query, [':ref_livre' => $ref_livre])->fetch(PDO::FETCH_OBJ);

            if ($result) {
                $new_nbr = $result->nbr_exemplaire + 1;
                $is_dispo = $new_nbr > 0 ? 1 : 0;
                $queryUpdate = "UPDATE livre 
                                SET nbr_exemplaire = :nbr_exemplaire, 
                                    is_dispo = :is_dispo 
                                WHERE ref_livre = :ref_livre";
                $this->database->request($queryUpdate, [
                    ':nbr_exemplaire' => $new_nbr,
                    ':is_dispo' => $is_dispo,
                    ':ref_livre' => $ref_livre
                ]);
            }
        } catch (Exception $e) {
            set_error('danger', "Erreur lors de la mise à jour du nombre d'exemplaires.", $e);
        }
    }
}
?>
