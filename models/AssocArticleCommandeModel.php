<?php

class AssocArticleCommandeModel
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=eatsmart_bdd_aymen;charset=utf8", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }





      public function getDBAllClient()
    {
        $stmt = $this->pdo->query("SELECT * FROM Client");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }






    public function getDBClientById ($idClient) {
        $req = "
            SELECT * FROM client
            WHERE client_id = :idClient
        ";
        $stmt = $this->pdo->prepare($req);
        $stmt->bindValue(":idClient", $idClient, PDO::PARAM_INT);
        $stmt->execute();
        $client = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $client;
    }








    public function createDBClient($data)
    {
        $req = " INSERT INTO client (client_id,client_nom,client_telephone)
            VALUES (:client_id, :client_nom, :client_telephone)";
             $stmt = $this->pdo->prepare($req);

            $stmt->bindParam(":client_id", $data['client_id'], PDO::PARAM_INT);
            $stmt->bindParam(":client_nom", $data['client_nom'], PDO::PARAM_STR);
            $stmt->bindParam(":client_telephone", $data['client_telephone'], PDO::PARAM_INT);
            
            $stmt->execute();
        
            $client = $this->getDBClientById($data['client_id']);        

        return $client;

    }








    public function updateDBClient ($id, $data)

    {
        $req = " UPDATE client 
                  SET client_id=:client_id, client_nom=:client_nom, client_telephone=:client_telephone
                  WHERE client_id= :id";


        $stmt = $this->pdo->prepare($req);

        $stmt->bindParam(":client_id", $data['client_id'], PDO::PARAM_INT);
        $stmt->bindParam(":client_nom", $data['client_nom'], PDO::PARAM_STR);
        $stmt->bindParam(":client_telephone", $data['client_telephone'], PDO::PARAM_INT);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

         $stmt->execute();
        
         //VERIFIE SI UNE LIGNE A ETAIT MODIFIER
        return $stmt->rowCount() > 0;
    }






    public function deleteDBClient ($id)

    {
        $req = " DELETE FROM  client 
                  WHERE client_id= :id";


        $stmt = $this->pdo->prepare($req);

       
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

         $stmt->execute();
        
         //VERIFIE SI UNE LIGNE A ETAIT MODIFIER
        return $stmt->rowCount() > 0;
    }





}
// $chauffeurModel = new ChauffeurModel();
// print_r($chauffeurModel->getDBAllChauffeurs());