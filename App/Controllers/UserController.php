<?php
require_once('../App/Conf/Database.php');
require_once('../App/Models/User.php');

class UserController
{
    use Crypt;
    // connexion avec la table user
    private $user;
    // déclaration des variables
    private $id, $email, $pseudo, $password, $confirm_password, $role, $timestamps;

    // Vérifie si tous les champs du formulaires sont remplis.
    public function verifyInputs()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $this->sanitaze($data->email);
        $this->pseudo = $this->sanitaze($data->pseudo);
        $this->password = $this->sanitaze($data->password);
        $this->confirm_password = $this->sanitaze($data->confirm);
        $this->emptyInputs();
    }

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

    // passWord(), format des mots de passe qu'on accepte
    public function passWord()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->password = $data->password;
        if (preg_match("/^[a-zA-Z-\@]+[\d]+/i", $this->password) && strlen($this->password) >= 8) {
            echo json_encode("password_respect");
        } else {
            echo json_encode("password_not_respect");
        }
    }

    // emptyInputs(), pour vérifiez si un des champs est vide
    public function emptyInputs()
    {
        if (empty($this->email) || empty($this->pseudo) || empty($this->password) || empty($this->confirm_password)) {
            echo json_encode("empty_input");
        } else {
            echo json_encode("valid_input");
        }
    }

    // verifyPassword(), pour vérifiez si les deux mot de passe que l'utilisateur entre sont corrects
    public function verifyPassword()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->password = $data->password;
        $this->confirm_password = $data->confirm;
        if ($this->password !== $this->confirm_password) {
            echo json_encode("password_different");
        } else {
            echo json_encode("password_identique");
        }
    }

    // verifyEmail(), pour vérifiez si l'email suis les normes pré-requises
    public function verifyEmail()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $data->email;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode("email_invalid");
        } else {
            echo json_encode("email_valid");
        }
    }

    // Vérifie si dans notre bdd, on a un utilisateur qui a un email ou un pseudo correspondant à ceux entrés par un autre utilisateur. Si oui, il renvoie un tableau bien chargé.
    public function searchUser($email, $pseudo)
    {
        $this->user = new User();
        $array = $this->user->verifyEmailOrName($email, $pseudo);
        return $array;
    }

    // Renvoie un tableau contenant les informations liées à un pseudo spécifique 
    public function verifyPseudo($pseudo)
    {
        $this->user = new User();
        $array = $this->user->verifyPseudo($pseudo);
        return $array;
    }

    // Enrégistre les informations entrées par un utilisateur dans la `users` se trouvant dans notre bdd
    public function register()
    {
        session_start();
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $this->sanitaze($data->email);
        $this->pseudo = $this->sanitaze($data->pseudo);
        $this->password = $this->sanitaze($data->password);
        $this->role = 1;
        $this->user = new User();
        $this->timestamps = date("Y-m-d h:i:s");
        $tableColors = array(
            "9FCF00",    "FAEBD7",    "00FFFF",    "7FFFD4",    "F0FFFF",    "F5F5DC",    "FFE4C4",    "000000",    "FFEBCD",    "0000FF",    "8A2BE2",    "A52A2A",    "DEB887",    "5F9EA0",    "7FFF00",    "D2691E",    "FF7F50",    "6495ED",    "FFF8DC",    "DC143C",    "00FFFF",    "00008B",    "008B8B",    "B8860B",    "A9A9A9",    "006400",    "BDB76B",    "8B008B",    "556B2F",    "FF8C00",    "9932CC",    "8B0000",    "E9967A",    "8FBC8F",    "483D8B",    "2F4F4F",    "00CED1",    "9400D3",    "FF1493",    "00BFFF",    "696969",    "1E90FF",    "B22222",    "FFFAF0",    "228B22",    "FF00FF",    "DCDCDC",    "F8F8FF",    "FFD700",    "DAA520",    "808080",    "008000",    "ADFF2F",    "F0FFF0",    "FF69B4",    "CD5C5C",    "4B0082",    "FFFFF0",    "F0E68C",    "E6E6FA",    "FFF0F5",    "7CFC00",    "FFFACD",    "ADD8E6",    "F08080",    "E0FFFF",    "FAFAD2",    "90EE90",    "D3D3D3",    "FFB6C1",    "FFA07A",    "20B2AA",    "87CEFA",    "778899",    "B0C4DE",    "FFFFE0",    "00FF00",    "32CD32",    "FAF0E6",    "FF00FF",    "800000",    "66CDAA",    "0000CD",    "BA55D3",    "9370DB",    "3CB371",    "7B68EE",    "0FA9A ",    "48D1CC",    "C71585",    "191970",    "F5FFFA",    "FFE4E1",    "FFE4B5",    "FFDEAD",    "000080",    "FDF5E6",    "808000",    "6B8E23",    "FFA500",    "FF4500",    "DA70D6",    "EEE8AA",    "98FB98",    "AFEEEE",    "DB7093",    "FFEFD5",    "FFDAB9",    "CD853F",    "FFC0CB",    "DDA0DD",    "B0E0E6",    "800080",    "FF0000",    "BC8F8F",    "4169E1",    "8B4513",    "FA8072",    "F4A460",    "2E8B57",    "FFF5EE",    "A0522D",    "C0C0C0",    "87CEEB",    "6A5ACD",    "708090",    "FFFAFA",    "00FF7F",    "4682B4",    "D2B48C",    "008080",    "D8BFD8",    "FF6347",    "40E0D0",    "EE82EE",    "F5DEB3",    "FFFFFF",    "F5F5F5",    "FFFF00",    "9ACD32");
        $number = rand(0, count($tableColors));
        $bgc = "#" . $tableColors[$number];

        $tableau = $this->searchUser($this->email, $this->pseudo);
        if (count($tableau) > 0) {
            echo json_encode("bad");
        } else {
            $result = $this->user->insertUser($this->email, $this->pseudo, $this->role, $this->password, $bgc, $this->timestamps);
            $tableau = $this->verifyPseudo($this->pseudo);

            $_SESSION["Auth"]["id"] = $this->datacrypt($tableau[0]["user_id"]);
            $_SESSION["Auth"]["email"] = $tableau[0]["user_email"];
            $_SESSION["Auth"]["pseudo"] = $tableau[0]["user_pseudo"];
            $_SESSION["Auth"]["role"] = $tableau[0]["user_role"];
            $_SESSION["Auth"]["bgc"] = $tableau[0]["user_bgc"];
            $_SESSION["Auth"]["created_at"] = $tableau[0]["created_at"];

            $controller = "?goto=" . $this->datacrypt('home');
            $action = "action=" . $this->datacrypt('newview-home');
            $url = $controller . "&" . $action;
            echo json_encode("$url");
        }
    }

    // Affiche tous les utilisateurs
    public function getAllUsers()
    {
        $this->user = new User();
        $array = $this->user->getAllUsers();
        return $array;
    }

    // Affiche les informations d'un utilisateur spécifique
    public function getOneUser()
    {
        if (isset($_GET["userid"])) {
            $this->user = new User();
            $this->id = $this->datadecrypt($_GET["userid"]);
            $array = $this->user->getOneUser($this->id);
        }
        return $array;
    }

    // Modifie le status d'un utilisateur
    public function updateOneUser()
    {
        if (isset($_GET["userid"])) {
            $datas = file_get_contents("php://input");
            $datas = json_decode($datas);
            $state = $datas->status;
            $this->user = new User();
            $this->id = intval($this->datadecrypt($_GET["userid"]));
            $this->timestamps = date("Y-m-d h:i:s");
            $this->user->updateOneUser($this->id, $state, $this->timestamps);
            $controller = "?goto=" . $this->datacrypt('dashboard');
            $action = "action=" . $this->datacrypt('users');
            $url = $controller . "&" . $action;
            echo json_encode("$url");
        }
    }

    // Suppression d'un utilisateur one by one
    public function deleteOneUser()
    {
        $datas = file_get_contents("php://input");
        $datas = json_decode($datas);
        $this->id = $this->datadecrypt($datas->id);

        // instanciation de la classe model user
        $this->user = new User();

        // Suppression d'un user
        $array = $this->user->deleteOneUser($this->id);
        echo json_encode("supprime");
    }

    // Permet de savoir le nombre d'utilisateurs inscrits sur le site
    public function countUsers()
    {
        // instanciation de la classe model user
        $this->user = new User();
        $array = $this->user->countUser();
        return $array;
    }

    // Redirige sur la plateforme qui permet de modifier le status d'un utilisateur
    public function redirect()
    {
        $datas = file_get_contents("php://input");
        $datas = json_decode($datas);
        $userid = $datas->id;
        $controller = "?goto=" . $this->datacrypt('dashboard');
        $action = "action=" . $this->datacrypt('update-users');
        $id = "userid=" . $userid;
        $url = $controller . "&" . $id . "&" . $action;
        echo json_encode("$url");
    }

   
    // Connaître le pourcentage des utilisateurs venus dans ce mois
    public function statistique()
    {
        $pastMonth = intval(date("m")) - 1;
        if ($pastMonth == 0) {
            $pastMonth = 12;
            $currentYear = intval(date("Y")) - 1;
        } else {
            $currentYear = intval(date("Y"));
        }
        $daysPastMonth = DaysPast::daysPastMonth($pastMonth, $currentYear);
        $this->user = new User();
        $datas = $this->user->getAllUsers();
        $dat = [];
        $usersPast = 0;
        for ($i = 0; $i < count($datas); $i++) {
            $el = explode(" ", $datas[$i]["created_at"])[0];
            array_push($dat, $el);
        }
        for ($i = 0; $i < count($dat); $i++) {
            if (in_array($dat[$i], $daysPastMonth)) {
                $usersPast += 1;
            }
        }

        // $pourcentage = (100 * $users_month)/ count($array);
        return $usersPast;
    }
}