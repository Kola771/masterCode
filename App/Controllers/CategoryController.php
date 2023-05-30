<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/Category.php');

class CategoryController
{
    use Crypt;
    private $category;
    // déclaration des variables
    private $id, $category_name, $category_description;

    // Vérifie si les champs sont remplis
    public function verifyInputs()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->category_name = $this->sanitaze($data->category_name);
        $this->category_description = $data->category_description;
        $this->emptyInputs();
    }

    // sanitaze(); pour les espacements et les injections de codes
    public function sanitaze($data)
    {
        $reg = preg_replace("/\s+/", " ", $data);
        $reg = preg_replace("/^\s*/", "", $reg);
        $reg = htmlspecialchars($reg);
        $reg = stripslashes($reg);
        $data = $reg;
        return $data;
    }

    // emptyInputs(), pour vérifiez si un des champs est vide
    public function emptyInputs()
    {
        if (empty($this->category_name) || empty($this->category_description)) {
            echo json_encode("empty_input");
        } else {
            echo json_encode("valid_input");
        }
    }

    // Vérifie s'il n'y a pas de doublons dans la base
    public function verifyCategory()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);

        // instanciation de la classe model category
        $this->category = new Category();

        $this->category_name = $this->sanitaze($data->category_name);

        $array = $this->category->searchCategory($this->category_name);
        // On vérifie si il y a une catégorie qui a ce nom
        if (count($array) > 0) {
            echo json_encode("exist");
        } else {
            echo json_encode("good");
        }
    }

    public function addCategory()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);

        // instanciation de la classe model category
        $this->category = new Category();

        $this->category_name = $this->sanitaze($data->category_name);
        $this->category_description = $this->sanitaze($data->category_description);

        // Enrégistrement de la catégorie dans la table catégories
        $this->category->addCategory($data->file, $this->category_name, $this->category_description);

        // Redirection sur la page des catégories
        $controller = "?goto=" . $this->datacrypt('dashboard');
        $action = "action=" . $this->datacrypt('category');
        $url = $controller . "&" . $action;
        echo json_encode($url);
    }

    // Vérifie si l'image respecte certaines caractéristiques
    public function verifyImgCategory()
    {
        // Réccupération du nom, du chemin, de la taille et de l'erreur de l'image
        $filename = $_FILES['file']['name'];
        $filetmp_name = $_FILES['file']['tmp_name'];
        $filesize = $_FILES['file']['size'];
        $fileerror = $_FILES['file']['error'];

        // Extension de l'image
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // Tableau d'extensions que nous acceptons
        $tab_ext = ["png", "jpg", "jpeg"];

        if (in_array($ext, $tab_ext)) {
            if ($filesize <= 10000000 && $fileerror === 0) {
                $file = uniqid("category_image-", true);
                $filename = $file . "." . $ext;
                $location = '../public/ressources/images/categories_images/' . $filename;
                move_uploaded_file($filetmp_name, $location);
                echo json_encode($filename);
            } else {
                echo json_encode("Image non correcte");
            }
        }
    }
    public function verifyImgArticles()
    {
        // Réccupération du nom, du chemin, de la taille et de l'erreur de l'image
        $filename = $_FILES['file']['name'];
        $filetmp_name = $_FILES['file']['tmp_name'];
        $filesize = $_FILES['file']['size'];
        $fileerror = $_FILES['file']['error'];

        // Extension de l'image
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // Tableau d'extensions que nous acceptons
        $tab_ext = ["png", "jpg", "jpeg"];

        if (in_array($ext, $tab_ext)) {
            if ($filesize <= 10000000 && $fileerror === 0) {
                $file = uniqid("image", true);
                $filename = $file . "." . $ext;
                $location = '../public/ressources/images/articles_images/' . $filename;
                move_uploaded_file($filetmp_name, $location);
                echo json_encode(array('location' =>"/ressources/images/articles_images/".$filename));
                // echo json_encode($filename);
            } else {
                echo json_encode("Image non correcte");
            }
        }
    }

    // Affiche toutes les catégories
    public function allCategories()
    {
        // instanciation de la classe model category
        $this->category = new Category();
        $array = $this->category->allCategories();
        return $array;
    }

    // Suppression d'une catégorie
    public function deleteOneCategory()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->id = $this->datadecrypt($data->id);
        // instanciation de la classe model category
        $this->category = new Category();
        $search = $this->category->searchCategoryById($this->id);
        if (count($search) > 0) {
            $delete_cat = $this->category->deleteOneCategory($this->id);
            unlink('../public/ressources/images/categories_images/' . $search[0]["category_img"]);
        }
    }

    public function searchOneCategory()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->id = $this->datadecrypt($data->id);
        // instanciation de la classe model category
        $this->category = new Category();
        $search = $this->category->searchCategoryById($this->id);
        if (count($search) > 0) {
            echo json_encode($search);
        }
    }

    // Compte le nombre de catégories qu'il y a dans la bdd
    public function countCategories()
    {
        // instanciation de la classe model category
        $this->category = new Category();
        $array = $this->category->countcategories();
        return $array;
    }

    // Vérifie s'il y'a pas de doublons lors de la modification d'une catégorie
    public function verifyUpCat()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->category = new Category();
        $this->id = $this->sanitaze($data->id);
        $this->category_name = $this->sanitaze($data->category_name);
        $array = $this->category->searchCategory($this->category_name);
        if (count($array) > 0) {
            if (intval($this->id) === intval($array[0]["category_id"])) {
                echo json_encode("good");
            } else {
                echo json_encode("error");
            }
        } else {
            echo json_encode("good");
        }
    }

    // Vérifie si l'image respecte certaines caractéristiques pour la modification
    public function verifyImgUpCat()
    {
        // Réccupération du nom, du chemin, de la taille et de l'erreur de l'image
        $filename = $_FILES['file']['name'];
        $filetmp_name = $_FILES['file']['tmp_name'];
        $filesize = $_FILES['file']['size'];
        $fileerror = $_FILES['file']['error'];

        // Extension de l'image
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // Tableau d'extensions que nous acceptons
        $tab_ext = ["png", "jpg", "jpeg"];

        if (in_array($ext, $tab_ext)) {
            if ($filesize <= 10000000 && $fileerror === 0) {
                $file = uniqid("category_image-", true);
                $filename = $file . "." . $ext;
                $location = '../public/ressources/images/categories_images/' . $filename;
                $img = $_GET["img"];
                unlink('../public/ressources/images/categories_images/' . $img);
                move_uploaded_file($filetmp_name, $location);
                echo json_encode($filename);
            } else {
                echo json_encode("Image non correcte");
            }
        }
    }

    public function updateCategory()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->category = new Category();
        $this->id = $this->sanitaze($data->id);
        $this->category_name = $this->sanitaze($data->category_name);
        $this->category_description = $this->sanitaze($data->category_description);
        $this->category->updateCategory($data->file, $this->category_name, $this->category_description, $this->id);
        $controller = "?goto=" . $this->datacrypt('dashboard');
        $action = "action=" . $this->datacrypt('category');
        $url = $controller . "&" . $action;
        echo json_encode("$url");
    }

}