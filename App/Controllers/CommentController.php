<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/Comment.php');

class CommentController
{
    use Crypt;

    // $user; on va utiliser cette variable pour instancier la classe UserModel dans le controller
    private $user;

    // $comment; on va utiliser cette variable pour instancier la classe CommentModel dans le controller
    private $comment, $comments, $comment_id;


    // sanitaze(); pour les espacements et les injections de codes
    public function sanitaze($data)
    {
        $reg = trim($data);
        $reg = htmlspecialchars($reg);
        $reg = stripslashes($reg);
        $data = $reg;
        return $data;
    }

    // addComment(), pour insérer des commentaires dans la bd
    public function addComment()
    {
        @session_start();
        if ((isset($_GET["articleid"])) && (isset($_SESSION["Auth"]))) {
            $datas = file_get_contents("php://input");
            $datas = json_decode($datas);

            $this->comments = nl2br($datas->body);
            $articleid = $this->datadecrypt($_GET["articleid"]);
            $userid = $this->datadecrypt($_SESSION["Auth"]["id"]);
            $created_at = date("Y-m-d h:i:s");

            $this->comment = new Comment();
            $this->comment->addComment($this->comments, $userid, $articleid, $created_at);
            $oneCom = $this->comment->getAllComment($this->datadecrypt($_GET["articleid"]));
            include_once("../App/Views/FrontendUser/commentPost.phtml");
        }
    }

    public function upComment()
    {
        $datas = file_get_contents("php://input");
        $datas = json_decode($datas);
        $this->comment = new Comment();
        $this->comments = nl2br($datas->body);
        $this->comment->upComment($this->datadecrypt($datas->id), $this->comments);
    }

    // deleteOneComment(), pour supprimer un commentaire de la bd
    public function deleteOneComment()
    {
        $datas = file_get_contents("php://input");
        $datas = json_decode($datas);
        $id = $this->datadecrypt($datas->id);
        $this->comment = new Comment();
        $this->comment->deleteOneComment($id);
    }

    public function getAllCommentByIdUser()
    {
        if(isset($_SESSION["Auth"]))
        {
            $this->comment = new Comment();
            $pseudo = "%" . $_SESSION['Auth']['pseudo'] . "%";
            $allComments = $this->comment->getAllCommentByIdUser($this->datadecrypt($_SESSION["Auth"]["id"]), $pseudo);
        }
        return $allComments;
    }

    public function getAllCommentTriTarById()
    {
        @session_start();
        if(isset($_SESSION["Auth"]))
        {
            $datas = file_get_contents("php://input");
            $datas = json_decode($datas);
            $this->comment = new Comment();
            $time = "" . $datas->value . "%";
            $pseudo = "%" . $_SESSION['Auth']['pseudo'] . "%";
            $allComments = $this->comment->getAllCommentTriById($this->datadecrypt($_SESSION["Auth"]["id"]), $time);
            $allPosts = $this->comment->getAllCommentTriTarByPseu($pseudo, $time);
            require_once("../App/Views/FrontendUser/searchComment.phtml");
        }
    }

}