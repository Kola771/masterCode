<?php

class Comment extends Database
{
    // Déclaration des variables
    private $id, $body, $user_id, $pseudo, $article_id, $created_at;

    // Ajoute les commentaires dans la bdd précisement dans la table comments
    public function addComment($body, $user_id, $article_id, $created_at)
    {
        $conn = $this->connect();
        $this->body = $body;
        $this->user_id = $user_id;
        $this->article_id = $article_id;
        $this->created_at = $created_at;

        // Requête SQL
        $sql = "INSERT INTO `blog`.comments VALUES(NULL,?,?,?,?);";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $result = $statement->execute([$this->body, $this->user_id, $this->article_id, $this->created_at]);

        // Retourne un null/true si c'est bon;
        return $result;
    }

    // Affiche tous les commentaires basés un article spécifique
    public function getAllComment($article_id)
    {
        $conn = $this->connect();
        $this->article_id = $article_id;

        // Requête SQL
        $sql = "SELECT `comments`.comment_id, `comments`.comment_body, `comments`.user_id,  `users`.user_pseudo, `users`.user_bgc, `comments`.article_id, `comments`.created_at FROM `blog`.comments INNER JOIN `blog`.users ON `users`.user_id = `comments`.user_id INNER JOIN `blog`.articles ON `articles`.article_id = `comments`.article_id WHERE `articles`.article_id = ? ORDER BY created_at DESC;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $statement->execute([$this->article_id]);
        $result = $statement->fetchAll();
        return $result;
    }

    // Affiche tous les commentaires d'un utilisateur spécifique
    public function getAllCommentByIdUser($user_id, $pseudo)
    {
        $conn = $this->connect();
        $this->user_id = $user_id;
        $this->pseudo = $pseudo;

        // Requête SQL
        $sql = "SELECT `comments`.comment_id, `comments`.comment_body, `comments`.user_id, `users`.user_pseudo, `comments`.article_id, `articles`.article_title, `articles`.article_image, `comments`.created_at FROM `blog`.comments INNER JOIN `blog`.users ON `users`.user_id = `comments`.user_id INNER JOIN `blog`.articles ON `articles`.article_id = `comments`.article_id WHERE `users`.user_id = ? OR comment_body LIKE ? ORDER BY created_at DESC;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $statement->execute([$this->user_id, $this->pseudo]);
        $result = $statement->fetchAll();
        return $result;
    }

    // Suppression d'un commentaire
    public function deleteOneComment($id)
    {
        $conn = $this->connect();
        $this->id = $id;

        // Requête SQL
        $sql = "DELETE FROM `blog`.comments WHERE `comments`.comment_id=?";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $result = $statement->execute([$this->id]);
        return $result;
    }

    public function getCountByArt()
    {
        $conn = $this->connect();

        // Requête SQL
        $sql = "SELECT comments.article_id, count(comments.article_id) AS nombre FROM `blog`.comments GROUP BY comments.article_id;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $statement->execute([]);
        $result = $statement->fetchAll();
        return $result;
    }

    public function upComment($id, $body)
    {
        $conn = $this->connect();
        $this->id = $id;
        $this->body = $body;

        // Requête SQL
        $sql = "UPDATE `blog`.comments set `comments`.comment_body = ? WHERE `comments`.comment_id = ?";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $result = $statement->execute([$this->body, $this->id]);
        return $result;
    }
}