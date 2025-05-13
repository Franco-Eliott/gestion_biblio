<?php
require_once 'Database.php';

class AdherentDB {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function create($nom, $adresse) {
        $sql = "INSERT INTO adherent (nom, adresse) VALUES (?, ?)";
        $params = array($nom, $adresse);
        $this->database->request($sql, $params);
    }

    public function read($id_adh) {
        $sql = "SELECT * FROM adherent WHERE id_adh = ? AND is_delete = false";
        $params = array($id_adh);
        $req = $this->database->request($sql, $params);
        return $this->database->recover($req, true);
    }

    public function readAll() {
        $sql = "SELECT * FROM adherent WHERE is_delete = false";
        $req = $this->database->request($sql);
        return $this->database->recover($req, false);
    }

    public function update($id_adh, $nom, $adresse) {
        $sql = "UPDATE adherent SET nom = ?, adresse = ? WHERE id_adh = ?";
        $params = array($nom, $adresse, $id_adh);
        $this->database->request($sql, $params);
    }

    public function delete($id_adh) {
        $sql = "UPDATE adherent SET is_delete = true WHERE id_adh = ?";
        $params = array($id_adh);
        $this->database->request($sql, $params);
    }

    public function suspend($id_adh, $suspend = true) {
        $query = "UPDATE adherent SET is_suspendu = :suspend WHERE id_adh = :id_adh";
        $this->database->request($query, [
            ':suspend' => $suspend ? 1 : 0,
            ':id_adh' => $id_adh
        ]);
    }
}

// Conserver ce fichier.
?>
