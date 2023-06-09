<?php
require_once("../App/Controllers/crypt.php");
require_once("../App/Controllers/CategoryController.php");
require_once("../App/Controllers/ArticleController.php");
require_once("../App/Controllers/UserController.php");
require_once("../App/Controllers/ContactController.php");
class Dashboard
{
    use Crypt;
    use AdresseIp;

    public function category()
    {
        $categories = new CategoryController();
        $articles = new ArticleController();
        $allCategories = $categories->allCategories();
        $allAr = $articles->getAllArticlesAttente();
        $countBroullons = count($allAr);
        $contacts = new ContactController();
        $countDay = $contacts->countDay();
        require_once("../App/Views/admin/category_page.phtml");
    }

    public function users()
    {
        $articles = new ArticleController();
        $allAr = $articles->getAllArticlesAttente();
        $countBroullons = count($allAr);
        $users = new UserController();
        $allUsers = $users->getAllUsers();
        $contacts = new ContactController();
        $countDay = $contacts->countDay();
        require_once("../App/Views/admin/Users.phtml");
    }

    public function updateUsers()
    {
        $articles = new ArticleController();
        $allAr = $articles->getAllArticlesAttente();
        $countBroullons = count($allAr);
        $users = new UserController();
        $oneUser = $users->getOneUser();
        $contacts = new ContactController();
        $countDay = $contacts->countDay();
        require_once("../App/Views/admin/updateUsers.phtml");
    }

    public function articles()
    {
        @session_start();
        $categories = new CategoryController();
        $allCategories = $categories->allCategories();
        $articles = new ArticleController();
        if($_SESSION["Auth"]["role"] === '0')
        {
            $allAr = $articles->getAllArticlesAttente();
        } else {
            $allAr = $articles->getAllArticlesAttenteBySession();
        }
        $countBroullons = count($allAr);
        $allArticles = $articles->getAllArticlesPublier();
        $numCom = $articles->getCountByArt();
        $views = $articles->getAllviewsArt();
        $contacts = new ContactController();
        $countDay = $contacts->countDay();
        require_once("../App/Views/admin/articles.phtml");
    }

    public function editor()
    {
        @session_start();
        $articles = new ArticleController();
        if($_SESSION["Auth"]["role"] === '0')
        {
            $allAr = $articles->getAllArticlesAttente();
        } else {
            $allAr = $articles->getAllArticlesAttenteBySession();
        }
        $countBroullons = count($allAr);
        $contacts = new ContactController();
        $countDay = $contacts->countDay();
        require_once("../App/Views/admin/editor.phtml");
    }

    public function message()
    {
        $articles = new ArticleController();
        $contacts = new ContactController();
        $allAr = $articles->getAllArticlesAttente();
        $countBroullons = count($allAr);
        $countDay = $contacts->countDay();
        $allContacts = $contacts->getAllContacts();
        $stateValide = $contacts->stateValide();
        require_once("../App/Views/admin/message.phtml");
    }

    public function sendResponse()
    {
        $contacts = new ContactController();
        $countDay = $contacts->countDay();
        $oneContact = $contacts->getOneContact();
        require_once("../App/Views/admin/send-message.phtml");
    }

    public function setting()
    {
        $articles = new ArticleController();
        $allAr = $articles->getAllArticlesAttente();
        $countBroullons = count($allAr);
        $users = new UserController();
        $contacts = new ContactController();
        $countDay = $contacts->countDay();
        $allUsers = $users->getAllUsers();
        require_once("../App/Views/admin/settings.phtml");
    }

    public function brouillons()
    {
        @session_start();
        $categories = new CategoryController();
        $allCategories = $categories->allCategories();
        $articles = new ArticleController();
        if($_SESSION["Auth"]["role"] === '0')
        {
            $allArticles = $articles->getAllArticlesAttente();
        } else {
            $allArticles = $articles->getAllArticlesAttenteBySession();
        }
        $countBroullons = count($allArticles);
        $contacts = new ContactController();
        $countDay = $contacts->countDay();
        require_once("../App/Views/admin/brouillons.phtml");
    }

    public function updateArticle()
    {
        @session_start();
        $categories = new CategoryController();
        $allCategories = $categories->allCategories();
        $articles = new ArticleController();
        if($_SESSION["Auth"]["role"] === '0')
        {
            $allArticles = $articles->getAllArticlesAttente();
        } else {
            $allArticles = $articles->getAllArticlesAttenteBySession();
        }
        $countBroullons = count($allArticles);
        $oneArticle = $articles->getOneArticleById();
        $contacts = new ContactController();
        $countDay = $contacts->countDay();
        require_once("../App/Views/admin/upArt.phtml");
    }

    public function modalArticle()
    {
        @session_start();
        $categories = new CategoryController();
        $allCategories = $categories->allCategories();
        $articles = new ArticleController();
        if($_SESSION["Auth"]["role"] === '0')
        {
            $allArticles = $articles->getAllArticlesAttente();
        } else {
            $allArticles = $articles->getAllArticlesAttenteBySession();
        }
        $countBroullons = count($allArticles);
        $oneArticle = $articles->getOneArticleById();
        $contacts = new ContactController();
        $countDay = $contacts->countDay();
        require_once("../App/Views/admin/modalArticle.phtml");
    }



}