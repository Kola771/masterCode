<?php
require_once("../App/Controllers/crypt.php");
require_once("../App/Controllers/UserController.php");
require_once("../App/Controllers/ArticleController.php");
require_once("../App/Controllers/ContactController.php");
require_once("../App/Controllers/CategoryController.php");
class Home {
    use Crypt;
    use AdresseIp;
    use ViewArticleIp;
    
    public function newviewHome()
    {
        require_once("../App/Views/FrontendUser/homePage.phtml");
    }
    
    public function newViewLogin()
    {
        require_once("../App/Views/FrontendUser/loginPage.phtml");
    }

    public function newViewForget()
    {
        require_once("../App/Views/FrontendUser/forgetPass.phtml");
    }
    
    public function newContact()
    {
        require_once("../App/Views/FrontendUser/contactPage.phtml");
    }
    
    public function newAbout()
    {
        require_once("../App/Views/FrontendUser/aboutPage.phtml");
    }
    
    public function newArticles()
    {
        $articles = new ArticleController();
        $views = $articles->getAllviewsArt();
        $numCom = $articles->getCountByArt();
        $numLike = $articles->getCountByLike();
        $allArticles = $articles->getAllArticlesPublier();
        require_once("../App/Views/FrontendUser/articlesPage.phtml");;
    }

    public function articleOne()
    {
        $articles = new ArticleController();
        $oneView = $articles->getViewsById();
        $oneCom = $articles->getAllComment();
        $onelike = $articles->selectCountLike();
        $oneArticle = $articles->getOneArticleByArtId();
        require_once("../App/Views/FrontendUser/articleOnePage.phtml");;
    }

    public function newLogout()
    {
        @session_start();
        unset($_SESSION["Auth"]);
        session_destroy();
        $controller = $this->datacrypt('home');
        $action = $this->datacrypt('newview-home');
        $url = "?goto=$controller&action=$action";
        header("Location:/$url");
    }

    public function dash()
    {
        @session_start();
        $users = new UserController();
        $contacts = new ContactController();
        $category = new CategoryController();
        $articles = new ArticleController();
        if($_SESSION["Auth"]["role"] === '0')
        {
            $allAr = $articles->getAllArticlesAttente();
        } else {
            $allAr = $articles->getAllArticlesAttenteBySession();
        }
        $articleSession = $articles->getAllArticlesBySession();
        $countBroullons = count($allAr);
        $countusers = $users->countUsers();
        $statistique = $users->statistique();
        $countadresses = $contacts->countAdresse();
        $stast = $contacts->stast();
        $countarticles = $articles->countArticle();
        $countcategories = $category->countCategories();
        $statistique_articles = $articles->statistique();
        $countDay = $contacts->countDay();
        require_once("../App/Views/admin/dashboard.phtml");
        //  require_once("../App/Views/BackendAdmin/pages/dashboard.phtml");
    }

    public function sauvegarde()
    {
        require_once("../App/Views/FrontendUser/dataUser.phtml");
    }
}