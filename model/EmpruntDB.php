<?php
require_once 'Database.php';

class EmpruntDB {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($id_adh, $date_emp, $date_retour_prevue) {
        try {
            $query = "INSERT INTO emprunt (id_adh, date_emp, date_retour_prevue) VALUES (:id_adh, :date_emp, :date_retour_prevue)";
            $this->db->request($query, [
                ':id_adh' => $id_adh,
                ':date_emp' => $date_emp,
                ':date_retour_prevue' => $date_retour_prevue
            ]);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            set_error('danger', "Erreur lors de la création de l'emprunt.", $e);
            return false;
        }
    }

    public function addLivreToEmprunt($id_emp, $ref_livre) {
        try {
            $query = "INSERT INTO concerner (id_emp, ref_livre) VALUES (:id_emp, :ref_livre)";
            $this->db->request($query, [
                ':id_emp' => $id_emp,
                ':ref_livre' => $ref_livre
            ]);
        } catch (Exception $e) {
            set_error('danger', "Erreur lors de l'association du livre à l'emprunt.", $e);
        }
    }

    public function read($id_emp) {
        $sql = "SELECT * FROM emprunt WHERE id_emp = ?";
        $params = array($id_emp);
        $req = $this->db->request($sql, $params);
        return $this->db->recover($req, true);
    }

    public function returnLivre($id_emp, $ref_livre, $date_retour) {
        $sql = "INSERT INTO retourner (id_emp, date_retour) VALUES (?, ?)";
        $params = array($id_emp, $date_retour);
        $this->db->request($sql, $params);

        // Utilise LivreDB pour gérer la disponibilité
        require_once 'LivreDB.php';
        $livredb = new LivreDB();
        $livredb->incrementExemplaire($ref_livre);
    }

    public function returnEmprunt($id_emp, $date_retour) {
        try {
            $queryUpdateEmprunt = "UPDATE emprunt SET is_returned = true WHERE id_emp = :id_emp";
            $this->db->request($queryUpdateEmprunt, [':id_emp' => $id_emp]);
            $queryInsertRetour = "INSERT INTO retourner (id_emp, date_retour) VALUES (:id_emp, :date_retour)";
            $this->db->request($queryInsertRetour, [
                ':id_emp' => $id_emp,
                ':date_retour' => $date_retour
            ]);

            // Récupère tous les livres concernés par cet emprunt et les remet disponibles
            $queryLivres = "SELECT ref_livre FROM concerner WHERE id_emp = :id_emp";
            $stmt = $this->db->request($queryLivres, [':id_emp' => $id_emp]);
            $livres = $stmt->fetchAll(PDO::FETCH_OBJ);
            require_once 'LivreDB.php';
            $livredb = new LivreDB();
            foreach ($livres as $livre) {
                $livredb->incrementExemplaire($livre->ref_livre);
            }
        } catch (Exception $e) {
            set_error('danger', "Erreur lors de l'enregistrement du retour.", $e);
        }
    }

    public function readAll() {
        try {
            $query = "SELECT e.*, a.nom AS nom_adherent 
                      FROM emprunt e 
                      JOIN adherent a ON e.id_adh = a.id_adh 
                      WHERE e.is_returned = false";
            $emprunts = $this->db->request($query)->fetchAll(PDO::FETCH_OBJ);

            foreach ($emprunts as $emprunt) {
                $queryLivres = "SELECT l.titre 
                                FROM concerner c 
                                JOIN livre l ON c.ref_livre = l.ref_livre 
                                WHERE c.id_emp = :id_emp";
                $stmt = $this->db->request($queryLivres, [':id_emp' => $emprunt->id_emp]);
                $emprunt->livres = $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            return $emprunts;
        } catch (Exception $e) {
            set_error('danger', "Erreur lors de la récupération des emprunts.", $e);
            return [];
        }
    }

    public function readHistory($id_adh) {
        $sql = "SELECT e.id_emp, e.date_emp, r.date_retour, 
                       GROUP_CONCAT(l.titre SEPARATOR ', ') AS livres
                FROM emprunt e
                LEFT JOIN retourner r ON e.id_emp = r.id_emp
                LEFT JOIN concerner c ON e.id_emp = c.id_emp
                LEFT JOIN livre l ON c.ref_livre = l.ref_livre
                WHERE e.id_adh = ?
                GROUP BY e.id_emp";
        $params = array($id_adh);
        $req = $this->db->request($sql, $params);
        return $this->db->recover($req, false);
    }
}
?>


