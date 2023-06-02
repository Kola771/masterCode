<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/User.php');
require_once('../App/Models/Article.php');
require_once('../App/Models/Contact.php');
require_once('../App/Models/Category.php');

class Search
{
    use Crypt;

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

    public function searchView()
    {
        @session_start();
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $value = $this->sanitaze($data->value);
        $search = "%$value%";
        $user = new User();
        $article = new Article();
        $contact = new Contact();
        $category = new Category();
        if ($search !== "%%") {
            $users = $user->searchLike($search);
            $articles = $article->searchLike($search);
            $contacts = $contact->searchLike($search);
            $categories = $category->searchLike($search);
            require_once("../App/Views/admin/search.phtml");
        }
    }

}