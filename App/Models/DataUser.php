<?php
class DataUser extends Database {

    private $article_id, $user_id, $created_at;

    // Ajoute les datasusers dans la table datasusers
    public function addData($article_id, $user_id, $created_at)
    {
        $connexion = $this->connect();
        $this->article_id = $article_id;
        $this->user_id = $user_id;
        $this->created_at = $created_at;

        // Requête SQL
        $sql = "INSERT INTO `blog`.datasusers VALUES(NULL,?,?,?);";

        // Requête préparée
        $statement = $connexion->prepare($sql);
        $result = $statement->execute([$this->article_id, $this->user_id, $this->created_at]);

        // Retourne un null/true si c'est bon;
        return $result;
    }

    // select(), pour vérifier si un utilisateur a déjà sauvegardé cet article
    public function select($article_id, $user_id)
    {
        $conn = $this->connect();
        $this->article_id = $article_id;
        $this->user_id = $user_id;

        // Requête préparée
        $sql = "SELECT article_id, user_id FROM `blog`.datasusers WHERE article_id = ? AND user_id = ?";

        // Retourne un null/true si c'est bon;
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->article_id, $this->user_id]);
        $result = $stmt->fetch();
        return $result;
    }

}