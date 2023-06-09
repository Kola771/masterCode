<?php

class Contact extends Database {
 /**
     * $conn, variable pour instancier la classe Connexion et pour faire la connexion à la bd avec la fonction connect()
     * 
     * $conn = $this->connect();
     */
    private $id, $email, $name, $theme, $body, $timestamps;

    // Affiche tous les messages que les utilisateurs ont envoyés sur le site
    public function getAllContact()
    {
        $conn = $this->connect();
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT `contacts`.contact_id, `contacts`.contact_email, `contacts`.contact_name, `contacts`.contact_theme, `contacts`.contact_body, `contacts`.state, `contacts`.created_at FROM `blog`.contacts ORDER BY `contacts`.created_at DESC;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll();
        return $result;
    }
    
    // Affichage un message spécifique
    public function getOneContact($id)
    {
        $conn = $this->connect();
        $this->id = $id;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT `contacts`.contact_id, `contacts`.contact_email, `contacts`.contact_name, `contacts`.contact_theme, `contacts`.contact_body, `contacts`.state, `contacts`.created_at FROM `blog`.contacts WHERE `contacts`.contact_id=?;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    // Affiche tout les messages en attente
    public function getAllContactAttente()
    {
        $conn = $this->connect();
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT `contacts`.contact_id, `contacts`.contact_email, `contacts`.contact_name, `contacts`.contact_theme, `contacts`.contact_body, `contacts`.state, `contacts`.created_at FROM `blog`.contacts WHERE `contacts`.state=?;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute(["attente"]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function stateValide()
    {
        $conn = $this->connect();
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT `contacts`.`state` FROM `contacts` WHERE state ='valide';";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll();
        return $result;
    }
    
    // Suppression d'un message
    public function deleteOneContact($id)
    {
        $conn = $this->connect();
        $this->id = $id;
        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "DELETE FROM `blog`.contacts WHERE `contacts`.contact_id=?;";
        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);
        $result = $stmt;
        return $result;
    }

    // Ajoute les messages des utilisateurs dans la bdd précisement dans la table contacts
    public function addContact($email, $name, $theme, $body, $timestamps) {

      $conn = $this->connect();

      $this->email = $email;
      $this->name = $name;
      $this->theme = $theme;
      $this->body = $body;
      $this->timestamps = $timestamps;

      /**
       * $sql, pour les requêtes vers la base de données
       */
      $sql = "INSERT INTO `blog`.contacts VALUES(NULL, :email, :name, :theme, :body, :attente, :timesdate)";
      
      /**
       * $stmt, pour recupérer la requête préparée
       */
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([
          ":email" => $this->email,
          ":name" => $this->name,
          ":theme" => $this->theme,
          ":body" => $this->body,
          ":attente" => "attente",
          ":timesdate" => $this->timestamps
      ]);

    return $result;

  }
  
  public function updateOneStateValide($id)
  {
      $conn = $this->connect();
      $this->id = $id;
      /**
       * $sql, pour les requêtes vers la base de données
       */
      $sql = "UPDATE `blog`.contacts set `contacts`.state = :state WHERE `contacts`.contact_id = :id";
      /**
       * $stmt, pour recupérer la requête préparée
       */
      $stmt = $conn->prepare($sql);
      $stmt->execute([
          ":state" => "valide",
          ":id" => $this->id
      ]);
  }
  
  public function searchLike($name)
  {
      $this->name = $name;

      $conn = $this->connect();

      /**
       * $sql, pour les requêtes vers la base de données
       */
      $sql = "SELECT * FROM `contacts` WHERE contact_name like ?;";

      /**
       * $stmt, pour recupérer la requête préparée
       */
      $stmt = $conn->prepare($sql);
      $stmt->execute([$this->name]);
      $result = $stmt->fetchAll();
      return $result;
  }
}