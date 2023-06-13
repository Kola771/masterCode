<?php

class Category extends Database
{
    /**
     * $conn, variable pour instancier la classe Connexion et pour faire la connexion à la bd avec la fonction connect()
     * 
     * $conn = $this->connect();
     */
    private $id, $file, $name, $description;

    // Recherche une catégorie à partir de son nom
    public function searchCategory($name)
    {
        $conn = $this->connect();

        $this->name = $name;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT * FROM `blog`.categories WHERE category_name = ?;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->name]);
        $result = $stmt->fetchAll();
        return $result;
    }

    // Recherche une catégorie à partir de son identifiant
    public function searchCategoryById($id)
    {
        $conn = $this->connect();

        $this->id = $id;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT * FROM `blog`.categories WHERE category_id = ?;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    // Affichage de toutes les catégories
    public function allCategories()
    {
        $conn = $this->connect();
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT * FROM `blog`.categories ORDER BY category_name ASC;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function addCategory($file, $name, $description)
    {

        $conn = $this->connect();

        $this->file = $file;
        $this->name = $name;
        $this->description = $description;

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "INSERT INTO `blog`.categories VALUES(NULL, :img, :name, :description)";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            ":img" => $this->file,
            ":name" => $this->name,
            ":description" => $this->description
        ]);

        return $result;
    }
    
    // Pour la modification des catégories
    public function updateCategory($file, $name, $description, $id)
    {

        $conn = $this->connect();

        $this->file = $file;
        $this->name = $name;
        $this->description = $description;
        $this->id = $id;

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "UPDATE `blog`.categories SET category_img = :file, category_name = :name, category_description = :description WHERE category_id = :id";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            ":file" => $this->file,
            ":name" => $this->name,
            ":description" => $this->description,
            ":id" => $this->id
        ]);

        return $result;
    }

    // Suppression d'une catégorie
    public function deleteOneCategory($id)
    {
        $conn = $this->connect();
        $this->id = $id;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "DELETE FROM `blog`.categories WHERE `categories`.category_id=?;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);
        $result = $stmt;
        return $result;
    }

    // Pour connaître le nombre de catégories créés
    public function countCategories()
    {
        $conn = $this->connect();
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT COUNT(`categories`.category_name) AS Nombre FROM categories;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetch();
        return $result;
    }
    
    public function searchLike($name)
    {
        $this->name = $name;

        $conn = $this->connect();

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT * FROM `blog`.categories WHERE category_name like ?;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->name]);
        $result = $stmt->fetchAll();
        return $result;
    }
    
    public function allCountArtCat($id)
    {
        $conn = $this->connect();
        $this->id = $id;

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT categories.category_id, categories.category_name, articles.article_title, COUNT(viewsarticles.article_id) AS nombre
        FROM categories INNER JOIN articles ON articles.category_id = categories.category_id INNER JOIN viewsarticles ON viewsarticles.article_id = articles.article_id WHERE categories.category_id = ? AND articles.state = 'publier' GROUP BY viewsarticles.article_id;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);
        $result = $stmt->fetchAll();
        return $result;
    }

}