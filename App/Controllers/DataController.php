<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/DataUser.php');
class DataController
{
    use Crypt;
    private $data;

    public function addData()
    {
        @session_start();
        if ((isset($_SESSION["Auth"]))) {
            $datas = file_get_contents("php://input");
            $datas = json_decode($datas);

            $this->data = new DataUser();
            $articleid = $this->datadecrypt($datas->value);
            $userid = $this->datadecrypt($_SESSION["Auth"]["id"]);
            $created_at = date("Y-m-d h:i:s");
            $array = $this->data->select($articleid, $userid);
            if ($array === false) {
                $this->data->addData($articleid, $userid, $created_at);
                echo json_encode("good");
            } else {
                echo json_encode("bad");
            }

        }
    }
}