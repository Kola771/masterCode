<?php

class ViewArticle extends Database
{
    /**
     * $conn, variable pour instancier la classe Connexion et pour faire la connexion à la bd avec la fonction connect()
     * 
     * $conn = $this->connect();
     */
    private $hote, $id;

    public function addViewsArticles($hote, $id)
    {
        $conn = $this->connect();
        $this->hote = $hote;
        $this->id = $id;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "INSERT INTO `blog`.viewsarticles VALUES(NULL, :hote, :id);";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            ":hote" => $this->hote,
            ":id" => $this->id
        ]);
        return $result;
    }

    public function getAllViewsById($id)
    {
        $conn = $this->connect();
        $this->id = $id;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT viewarticle_id, nom_hote, article_id FROM `blog`.viewsarticles WHERE `viewsarticles`.article_id = ?;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getViewsById($id)
    {
        $conn = $this->connect();
        $this->id = $id;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT viewsarticles.article_id, count(viewsarticles.article_id) AS nombre FROM `blog`.viewsarticles WHERE `viewsarticles`.article_id = ? GROUP BY viewsarticles.article_id;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getAllviewsArt()
    {
        $conn = $this->connect();
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT viewsarticles.article_id, count(viewsarticles.article_id) AS nombre FROM viewsarticles GROUP BY viewsarticles.article_id;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll();
        return $result;
    }
}