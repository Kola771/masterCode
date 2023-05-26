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
    // public function viewHome()
    // {
    //     require_once("../App/Views/home.phtml");
    // }
    public function newviewHome()
    {
        require_once("../App/Views/FrontendUser/homePage.phtml");
    }
    // public function viewLogin()
    // {
    //     require_once("../App/Views/login.phtml");
    // }
    public function newViewLogin()
    {
        require_once("../App/Views/FrontendUser/loginPage.phtml");
    }

    public function register(){
        require_once("../App/Views/register.phtml");
    }

    public function viewForget()
    {
        require_once("../App/Views/forget.phtml");
    }

    // public function contact()
    // {
    //     require_once("../App/Views/contact.phtml");
    // }
    public function newContact()
    {
        require_once("../App/Views/FrontendUser/contactPage.phtml");
    }

    // public function about()
    // {
    //     require_once("../App/Views/about.phtml");
    // }
    public function newAbout()
    {
        require_once("../App/Views/FrontendUser/aboutPage.phtml");
    }
    // public function articles()
    // {
    //     require_once("../App/Views/articles.phtml");
    // }

    public function newArticles()
    {
        require_once("../App/Views/FrontendUser/articlesPage.phtml");;
    }

    public function articleOne()
    {
        require_once("../App/Views/FrontendUser/articleOnePage.phtml");;
    }

    // public function logout()
    // {
    //     @session_start();
    //     unset($_SESSION["Auth"]);
    //     session_destroy();
    //     $controller = $this->datacrypt('home');
    //     $action = $this->datacrypt('view-home');
    //     $url = "?goto=$controller&action=$action";
    //     header("Location:/$url");
    // }

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
        $users = new UserController();
        $contacts = new ContactController();
        $category = new CategoryController();
        $articles = new ArticleController();
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
}