<?php

class Adresse extends Database
{
    /**
     * $conn, variable pour instancier la classe Connexion et pour faire la connexion à la bd avec la fonction connect()
     * 
     * $conn = $this->connect();
     */
    private $adresse, $time;

    public function addAdress($adresse, $time)
    {
        $conn = $this->connect();
        $this->adresse = $adresse;
        $this->time = $time;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "INSERT INTO `blog`.adresses VALUES(NULL, :adresse);";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            ":adresse" => $this->adresse,
            ":created_at" => $this->time
        ]);
        return $result;
    }

    public function getAllAdresse()
    {
        $conn = $this->connect();
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT adresse_id, nom_hote, created_at FROM `blog`.adresses;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll();
        return $result;
    }

    // public function getAdresse($adresse)
    // {
    //     $conn = $this->connect();
    //     $this->adresse = $adresse;
    //     /**
    //      * $sql, pour les requêtes vers la base de données
    //      */
    //     $sql = "SELECT adresse_id, nom_hote FROM `blog`.adresses WHERE nom_hote=:adresse;";
    //     /**
    //      * $stmt, pour recupérer la requête préparée
    //      */
    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute([
    //         ":adresse" => $this->adresse
    //     ]);
    //     $result = $stmt->fetchAll();
    //     return $result;
    // }

    // Pour avoir le nombre d'adresses venant sur le site
    public function countAdresse()
    {
        $conn = $this->connect();
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT COUNT(`adresses`.nom_hote) AS Nombre FROM adresses;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetch();
        return $result;
    }
}