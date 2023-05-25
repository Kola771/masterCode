<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/ViewArticle.php');
class ViewAdresseController
{
    use Crypt;
    private $adresse;
    public function addView()
    {
        if(isset($_GET["articleid"]))
        {
            $datas = file_get_contents("php://input");
            $datas = json_decode($datas);
            $this->adresse = new ViewArticle;
            $articleId = intval($this->datadecrypt($_GET["articleid"]));
            $adresses = $this->datadecrypt($datas->adresse);
            $tableau = $this->adresse->getAllViewsById($articleId);
            if (count($tableau) > 0) {
                $tableau_decrypt = [];
                for ($i = 0; $i < count($tableau); $i++) {
                    array_push($tableau_decrypt, $this->datadecrypt($tableau[$i]["nom_hote"]));
                }
                if (in_array($adresses, $tableau_decrypt)) {
                    echo json_encode("Ce visiteur a déjà vu cet article !!!");
                } else {
                    $this->adresse->addViewsArticles($datas->adresse, $articleId);
                }
            } else {
                $this->adresse->addViewsArticles($datas->adresse, $articleId);
            }
        }
    }
}