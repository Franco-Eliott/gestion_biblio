<?php 
class Database {
    // Déclaration des variables d'instance pour la connexion à la base de données
    private $dsn;
    private $username;
    private $password;
    private $pdo;

    public function __construct() {
        // Initialisation des paramètres de connexion
        $this->dsn = "mysql:host=localhost; dbname=biblio_gestion; port=3306; charset=utf8";
        $this->username = "root";
        $this->password = "";
        $this->pdo = $this->chaineConnexion(); // Initialise la connexion PDO
    }

    // Méthode pour créer une connexion PDO
    public function chaineConnexion() {
        $pdo = new PDO($this->dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active les exceptions pour les erreurs SQL
        return $pdo; // Retourne l'objet PDO représentant la connexion
    }

    // Méthode pour exécuter une requête SQL avec ou sans paramètres
    public function request($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            set_error('danger', "Erreur SQL : $query", $e);
            throw $e;
        }
    }

    // Méthode pour récupérer les résultats d'une requête
    public function recover($req, $one = true) {
        $datas = null;
        $req->setFetchMode(PDO::FETCH_OBJ); // Définit le mode de récupération des résultats en objets
        if ($one == true) {
            $datas = $req->fetch(); // Récupère un seul résultat
        } else {
            $datas = $req->fetchAll(); // Récupère tous les résultats
        }
        return $datas; // Retourne les données récupérées
    }

    // Méthode pour récupérer l'ID de la dernière insertion
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
?>