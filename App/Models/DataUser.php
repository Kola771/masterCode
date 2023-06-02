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

    // Affiche les données qu'un utilisateur a sauvegardé
    public function selectSession($user_id)
    {
        $conn = $this->connect();
        $this->user_id = $user_id;

        // Requête préparée
        $sql = "SELECT articles.article_id, articles.article_image, articles.article_title, categories.category_name, users.user_pseudo, users.user_bgc, users.user_role, datasusers.created_at FROM datasusers
        INNER JOIN articles ON articles.article_id = datasusers.article_id
        INNER JOIN categories ON categories.category_id = articles.category_id
        INNER JOIN users ON users.user_id = articles.user_id
        WHERE datasusers.user_id = ?";

        // Retourne un null/true si c'est bon;
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->user_id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function deleteData($article_id, $user_id)
    {
        $connexion = $this->connect();
        $this->article_id = $article_id;
        $this->user_id = $user_id;

        // Requête SQL
        $sql = "DELETE FROM `blog`.datasusers WHERE article_id = ? AND user_id = ?";

        // Requête préparée
        $stmt = $connexion->prepare($sql);
        $result = $stmt->execute([$this->article_id, $this->user_id]);

        // Retourne un null/true si c'est bon;
        return $result;
    }

}