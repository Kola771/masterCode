<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/Article.php');
class ArticleController
{
    use Crypt;
    // Déclaration des variables
    private $article, $id, $title, $image, $code_html, $category_id, $user_id, $created_at, $updated_at;

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

    // Ajout des articles
    public function addArticles()
    {
        @session_start();
        if ((isset($_GET["categoryid"])) && (isset($_SESSION["Auth"]))) {
            $datas = file_get_contents("php://input");
            $datas = json_decode($datas);
            $this->category_id = $this->datadecrypt($_GET["categoryid"]);
            $this->user_id = $this->datadecrypt($_SESSION["Auth"]["id"]);
            $this->created_at = date("Y-m-d h:i:s");

            // instanciation de la classe model article
            $this->article = new Article();

            // Insertion de l'article
            $insert = $this->article->addArticle($datas->img, $datas->title, $datas->code_html, $datas->state, $this->category_id, $this->user_id, $this->created_at);
            $controller = "?goto=" . $this->datacrypt('dashboard');
            $action = "action=" . $this->datacrypt('articles');
            $url = $controller . "&" . $action;
            echo json_encode("$url");
        }
    }

    // Vérification du titre de l'article dans la bdd pour qu'il n'y ait pas de doublons
    public function verifyTitle()
    {
        $datas = file_get_contents("php://input");
        $datas = json_decode($datas);
        $this->article = new Article();
        $array = $this->article->getTitlesArticle($this->sanitaze($datas->title));
        if (count($array) == 0) {
            echo json_encode("good");
        } else {
            echo json_encode("Article_exist");
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
        $tab_ext = ["jpg", "jpeg"];

        if (in_array($ext, $tab_ext)) {
            if ($filesize <= 10000000 && $fileerror === 0) {
                $file = uniqid("image", true);
                $filename = $file . "." . $ext;
                $location = '../public/ressources/images/images_principales/' . $filename;
                move_uploaded_file($filetmp_name, $location);
                echo json_encode($filename);
            } else {
                echo json_encode("Image non correcte");
            }
        }
    }


    // Suppression des articles one by one
    public function deleteOneArticle()
    {
        $datas = file_get_contents("php://input");
        $datas = json_decode($datas);
        $this->id = $this->datadecrypt($datas->id);

        // instanciation de la classe model article
        $this->article = new Article();

        // Suppression d'un article
        $array = $this->article->deleteOneArticle($this->id);
        echo json_encode("supprime");
    }

    // Affiche tous les articles
    public function getAllArticles()
    {
        // instanciation de la classe model article
        $this->article = new Article();
        $array = $this->article->getAllArticles();
        return $array;
    }
    // public function getAllArticleAtBrouillons()
    // {
    //     // instanciation de la classe model article
    //     $this->article = new Article();
    //     $array = $this->article->getAllArticlesAtBrouillons();
    //     return $array;
    // }

    // Affiche tous les articles en attente
    public function getAllArticlesAttente()
    {
        // instanciation de la classe model article
        $this->article = new Article();
        $array = $this->article->getAllArticlesAttente();
        return $array;
    }

    // Affiche tous les articles en attente par Session
    public function getAllArticlesAttenteBySession()
    {
        if (isset($_SESSION["Auth"])) {
            // instanciation de la classe model article
            $this->article = new Article();
            $array = $this->article->getAllArticlesAttenteBySession($_SESSION["Auth"]["pseudo"]);
            return $array;
        }
    }

    // Affiche tous les articles par Session
    public function getAllArticlesBySession()
    {
        if (isset($_SESSION["Auth"])) {
            // instanciation de la classe model article
            $this->article = new Article();
            $array = $this->article->getAllArticlesBySession($_SESSION["Auth"]["pseudo"]);
            return $array;
        }
    }

    // Affiche tous les articles publiés
    public function getAllArticlesPublier()
    {
        // instanciation de la classe model article
        $this->article = new Article();
        $array = $this->article->getAllArticlesPublier();
        return $array;
    }

    // Pour afficher tous les titres des différents articles se trouvant dans la bdd
    public function getAllTitlesArticle()
    {
        // instanciation de la classe model article
        $this->article = new Article();
        $array = $this->article->getAllTitlesArticle();
        return $array;
    }

    // Pour afficher un article spécifique
    public function getOneArticleById()
    {
        if (isset($_GET["id"])) {
            // instanciation de la classe model article
            $this->article = new Article();
            $id = $this->datadecrypt($_GET["id"]);
            $array = $this->article->getOneArticleById($id);
            return $array;
        }
    }

    // Tant qu'une catégorie a été choisie, il fait une redirection
    public function redirect()
    {
        $datas = file_get_contents("php://input");
        $datas = json_decode($datas);
        $categoryid = $this->datacrypt($datas->categoryid);
        $controller = "?goto=" . $this->datacrypt('dashboard');
        $action = "action=" . $this->datacrypt('editor');
        $id = "categoryid=" . $categoryid;
        $url = $controller . "&" . $id . "&" . $action;
        echo json_encode("$url");
    }

    // Compte le nombre d'articles qu'il y a dans la bdd
    public function countArticle()
    {
        // instanciation de la classe model article
        $this->article = new Article();
        $array = $this->article->countArticle();
        return $array;
    }

    // Connaître le pourcentage des utilisateurs venus dans ce mois
    public function statistique()
    {
        @session_start();
        $pastMonth = intval(date("m")) - 1;
        if ($pastMonth == 0) {
            $pastMonth = 12;
            $currentYear = intval(date("Y")) - 1;
        } else {
            $currentYear = intval(date("Y"));
        }
        $daysPastMonth = DaysPast::daysPastMonth($pastMonth, $currentYear);
        $this->article = new Article();
        if ($_SESSION["Auth"]["role"] === '0') {
            $datas = $this->article->getAllArticles();
        } else {
            $datas = $this->article->getAllArticlesBySession($_SESSION["Auth"]["pseudo"]);
        }
        // $datas = $this->article->getAllArticles();
        $dat = [];
        $articlesPasts = 0;
        for ($i = 0; $i < count($datas); $i++) {
            $el = explode(" ", $datas[$i]["created_at"])[0];
            array_push($dat, $el);
        }
        for ($i = 0; $i < count($dat); $i++) {
            if (in_array($dat[$i], $daysPastMonth)) {
                $articlesPasts += 1;
            }
        }

        // $pourcentage = (100 * $articles_month)/ count($array);
        // $pourcentage = (100 * $articles_month)/ 1;

        return $articlesPasts;
    }

    public function updateState()
    {
        $datas = file_get_contents("php://input");
        $datas = json_decode($datas);
        $this->id = $this->datadecrypt($datas->id);
        echo json_encode($this->id);

        // instanciation de la classe model article
        $this->article = new Article();
        $update = $this->article->updateState($this->id, "publier");
    }

    // Vérifie s'il y'a pas de doublons lors de la modification d'un article
    public function verifyUpArt()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->id = $this->datadecrypt($data->id);
        $this->article = new Article();
        $array = $this->article->getTitlesArticle($this->sanitaze($data->title));
        if (count($array) > 0) {
            if (intval($this->id) === intval($array[0]["article_id"])) {
                echo json_encode("good");
            } else {
                echo json_encode("error");
            }
        } else {
            echo json_encode("good");
        }
    }

    // Vérifie si l'image respecte certaines caractéristiques pour la modification
    public function verifyImgUpArt()
    {
        // Réccupération du nom, du chemin, de la taille et de l'erreur de l'image
        $filename = $_FILES['file']['name'];
        $filetmp_name = $_FILES['file']['tmp_name'];
        $filesize = $_FILES['file']['size'];
        $fileerror = $_FILES['file']['error'];

        // Extension de l'image
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // Tableau d'extensions que nous acceptons
        $tab_ext = ["jpg", "jpeg"];

        if (in_array($ext, $tab_ext)) {
            if ($filesize <= 10000000 && $fileerror === 0) {
                $file = uniqid("image", true);
                $filename = $file . "." . $ext;
                $location = '../public/ressources/images/images_principales/' . $filename;
                $img = $_GET["img"];
                unlink('../public/ressources/images/images_principales/' . $img);
                move_uploaded_file($filetmp_name, $location);
                echo json_encode($filename);
            } else {
                echo json_encode("Image non correcte");
            }
        }
    }

    public function updateOneArticle()
    {
        $datas = file_get_contents("php://input");
        $datas = json_decode($datas);
        $this->id = $this->datadecrypt($datas->id);
        $this->article = new Article();
        $this->updated_at = date("Y-m-d h:i:s");
        // Insertion de l'article
        $update = $this->article->updateOneArticle($this->id, $datas->title, $datas->img, $datas->code_html, $datas->state, $this->updated_at);
    }
}