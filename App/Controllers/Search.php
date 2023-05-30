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
            if (count($users) == 0) {
                $articles = $article->searchLike($search);
                if (count($articles) == 0) {
                    $contacts = $contact->searchLike($search);
                    if (count($contacts) == 0) {
                        $categories = $category->searchLike($search);
                    }
                }
            }
            require_once("../App/Views/admin/search.phtml");
        }
    }

}