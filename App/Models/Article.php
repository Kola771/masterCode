<?php

class Article extends Database
{
    // Déclaration des variables
    private $id, $title, $image, $code_html, $state, $category_id, $user_id, $created_at;

    // Affiche tous les titres des articles
    public function getAllTitlesArticle()
    {
        // Connexion avec la base de données
        $conn = $this->connect();

        // Requête SQL
        $sql = "SELECT `articles`.article_id, `articles`.article_title FROM `blog`.articles ORDER BY `articles`.created_at DESC;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $statement->execute([]);

        // Retourne un tableau grâce à fetchAll();
        $result = $statement->fetchAll();
        return $result;
    }

    // Affiche le titre d'un article
    public function getTitlesArticle($title)
    {
        // Connexion avec la base de données
        $conn = $this->connect();
        $this->title = "%$title%";

        // Requête SQL
        $sql = "SELECT `articles`.article_id, `articles`.article_title FROM `blog`.articles WHERE `articles`.article_title LIKE ?;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $statement->execute([$this->title]);

        // Retourne un tableau grâce à fetchAll();
        $result = $statement->fetchAll();
        return $result;
    }

    // Affiche un article spécifique
    public function getOneArticleById($id)
    {
        // Connexion avec la base de données
        $conn = $this->connect();
        $this->id = $id;

        // Requête SQL
        $sql = "SELECT `articles`.article_id, `articles`.article_image, `articles`.article_title, `articles`.state, `articles`.code_html, `categories`.category_name, `users`.user_pseudo, `articles`.created_at, `articles`.updated_at FROM `blog`.articles INNER JOIN `blog`.categories ON `categories`.category_id = `articles`.category_id INNER JOIN `blog`.users ON `users`.user_id = `articles`.user_id WHERE `articles`.article_id =?;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $statement->execute([$this->id]);

        // Retourne un tableau grâce à fetchAll();
        $result = $statement->fetchAll();
        return $result;
    }

    // Affiche tous les articles
    public function getAllArticles()
    {
        // Connexion avec la base de données
        $conn = $this->connect();

        // Requête SQL
        $sql = "SELECT `articles`.article_id, `articles`.article_image, `articles`.article_title, `articles`.code_html, `categories`.category_name, `users`.user_pseudo, `articles`.created_at, `articles`.updated_at FROM `blog`.articles INNER JOIN `blog`.categories ON `categories`.category_id = `articles`.category_id INNER JOIN `blog`.users ON `users`.user_id = `articles`.user_id ORDER BY `articles`.created_at DESC;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $statement->execute([]);

        // Retourne un tableau grâce à fetchAll();
        $result = $statement->fetchAll();
        return $result;
    }

    // Affiche tous les articles en attente
    public function getAllArticlesAttente()
    {
        // Connexion avec la base de données
        $conn = $this->connect();

        // Requête SQL
        $sql = "SELECT `articles`.article_id, `articles`.article_image, `articles`.article_title, `articles`.code_html, `categories`.category_name, `users`.user_pseudo, `articles`.created_at, `articles`.updated_at FROM `blog`.articles INNER JOIN `blog`.categories ON `categories`.category_id = `articles`.category_id INNER JOIN `blog`.users ON `users`.user_id = `articles`.user_id WHERE `articles`.state = 'attente' ORDER BY `articles`.created_at DESC;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $statement->execute([]);

        // Retourne un tableau grâce à fetchAll();
        $result = $statement->fetchAll();
        return $result;
    }

    // Affiche tous les articles publiés
    public function getAllArticlesPublier()
    {
        // Connexion avec la base de données
        $conn = $this->connect();

        // Requête SQL
        $sql = "SELECT `articles`.article_id, `articles`.article_image, `articles`.article_title, `articles`.code_html, `categories`.category_name, `users`.user_pseudo, `articles`.created_at, `articles`.updated_at FROM `blog`.articles INNER JOIN `blog`.categories ON `categories`.category_id = `articles`.category_id INNER JOIN `blog`.users ON `users`.user_id = `articles`.user_id WHERE `articles`.state = 'publier' ORDER BY `articles`.created_at DESC;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $statement->execute([]);

        // Retourne un tableau grâce à fetchAll();
        $result = $statement->fetchAll();
        return $result;
    }

    // Ajoute les articles dans la table articles 
    public function addArticle($image, $title, $code_html, $state, $category_id, $user_id, $created_at)
    {
        // Connexion avec la base de données
        $conn = $this->connect();
        $this->image = $image;
        $this->title = $title;
        $this->code_html = $code_html;
        $this->state = $state;
        $this->category_id = $category_id;
        $this->user_id = $user_id;
        $this->created_at = $created_at;

        // Requête SQL
        $sql = "INSERT INTO `blog`.articles VALUES (NULL,?,?,?,?,?,?,?,NULL);";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $result = $statement->execute([$this->image, $this->title, $this->code_html, $this->state, $this->category_id, $this->user_id, $this->created_at]);
        return $result;
    }

    // Suppression d'un article
    public function deleteOneArticle($id)
    {
        // Connexion avec la base de données
        $conn = $this->connect();
        $this->id = $id;

        // Requête SQL
        $sql = "DELETE FROM `blog`.articles WHERE `articles`.article_id=?;";

        // Requête préparée
        $statement = $conn->prepare($sql);
        $result = $statement->execute([$this->id]);

        return $result;
    }

    // Pour connaître le nombre d'articles créés
    public function countArticle()
    {
        $conn = $this->connect();
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT COUNT(`articles`.article_title) AS Nombre FROM articles;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetch();
        return $result;
    }

    public function searchLike($title)
    {
        $this->title = $title;

        $conn = $this->connect();

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT `articles`.article_id, `articles`.article_image, `articles`.article_title, `articles`.code_html, `categories`.category_name, `users`.user_pseudo, `articles`.created_at, `articles`.updated_at FROM `blog`.articles INNER JOIN `blog`.categories ON `categories`.category_id = `articles`.category_id INNER JOIN `blog`.users ON `users`.user_id = `articles`.user_id WHERE article_title like ? ORDER BY `articles`.created_at DESC;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->title]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function updateState($id, $state)
    {
        $conn = $this->connect();
        $this->id = $id;
        $this->state = $state;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "UPDATE `blog`.articles set `articles`.state = :state WHERE `articles`.article_id = :id";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":id" => $this->id,
            ":state" => $this->state
        ]);
    }

}