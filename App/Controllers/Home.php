<?php
require_once("../App/Controllers/crypt.php");
require_once("../App/Controllers/UserController.php");
require_once("../App/Controllers/ArticleController.php");
require_once("../App/Controllers/ContactController.php");
require_once("../App/Controllers/CommentController.php");
require_once("../App/Controllers/CategoryController.php");
class Home {
    use Crypt;
    use AdresseIp;
    use ViewArticleIp;
    
    public function newviewHome()
    {
        $category = new CategoryController();
        $allCategory = $category->allCategories();
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
        $category = new CategoryController();
        $allCategory = $category->allCategories();
        require_once("../App/Views/FrontendUser/contactPage.phtml");
    }
    
    public function newAbout()
    {
        $category = new CategoryController();
        $allCategory = $category->allCategories();
        require_once("../App/Views/FrontendUser/aboutPage.phtml");
    }
    
    public function newArticles()
    {
        $articles = new ArticleController();
        $category = new CategoryController();
        $allCategory = $category->allCategories();
        $views = $articles->getAllviewsArt();
        $numCom = $articles->getCountByArt();
        $numLike = $articles->getCountByLike();
        $allArticles = $articles->getAllArticlesPublier();
        require_once("../App/Views/FrontendUser/articlesPage.phtml");;
    }
    
    public function categoryArticles()
    {
        $articles = new ArticleController();
        $category = new CategoryController();
        $allCategory = $category->allCategories();
        $views = $articles->getAllviewsArt();
        $numCom = $articles->getCountByArt();
        $numLike = $articles->getCountByLike();
        $allArticles = $articles->getAllArticlesPublierByCat();
        require_once("../App/Views/FrontendUser/categoryArticles.phtml");;
    }

    public function articleOne()
    {
        $articles = new ArticleController();
        $category = new CategoryController();
        $allCategory = $category->allCategories();
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
        $catDomine = $articles->catDomine();
        $getAllviewsArtDesc = $articles->getAllviewsArtDesc();
        $allArticles = $articles->getAllArticlesPublier();
        $numCom = $articles->getCountByArt();
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
        @session_start();
        $articles = new ArticleController();
        $category = new CategoryController();
        $allCategory = $category->allCategories();
        $datasusers = $articles->selectSessionId(); 
        $diff = $articles->dataReg();
        require_once("../App/Views/FrontendUser/dataUser.phtml");
    }

    public function comments()
    {
        @session_start();
        $articles = new ArticleController();
        $comments = new CommentController();
        $category = new CategoryController();
        $allCategory = $category->allCategories();
        $allComments = $comments->getAllCommentByIdUser();
        require_once("../App/Views/FrontendUser/comment.phtml");
    }
}