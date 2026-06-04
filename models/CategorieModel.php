<?php

class CategorieModel
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


      public function getDBAllCategories()
    {
        $stmt = $this->pdo->query("SELECT * FROM Categorie");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getDBCategorieById ($idCategorie) {
        $req = "
            SELECT * FROM Categorie
            WHERE categorie_id = :idCategorie
        ";
        $stmt = $this->pdo->prepare($req);
        $stmt->bindValue(":idCategorie", $idCategorie, PDO::PARAM_INT);
        $stmt->execute();
        $categorie = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categorie;
    }





    public function getDBTrajetByIdDetails ($idTrajet) {
        $req = "
            SELECT trajet.trajet_id, chauffeur.chauffeur_nom, client.client_nom FROM trajet
            INNER JOIN chauffeur
            ON trajet.trajet_id = chauffeur.chauffeur_id
            INNER JOIN possede
            ON trajet.trajet_id = possede.trajet_id
            INNER JOIN client
            ON possede.client_id = client.client_id
            WHERE trajet.trajet_id = :idTrajet
        ";
        $stmt = $this->pdo->prepare($req);
        $stmt->bindValue(":idTrajet", $idTrajet, PDO::PARAM_INT);
        $stmt->execute();
        $trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $trajets;
    }



public function createDBCategorie($data)
    {
        $req = " INSERT INTO categorie (categorie_id, nom)
            VALUES (:categorie_id,:nom)";
             $stmt = $this->pdo->prepare($req);

            $stmt->bindParam(":categorie_id", $data['categorie_id'], PDO::PARAM_INT);
            $stmt->bindParam(":nom", $data['nom'], PDO::PARAM_STR);
           
            $stmt->execute();
        
            $categorie=$this->getDBCategorieById($data['categorie_id']);        

        return $categorie;
    }



    public function updateDBCategorie ($id, $data)

    {
        $req = " UPDATE categorie
                  SET categorie_id=:categorie_id, nom=:nom
                  WHERE categorie_id=:id";


        $stmt = $this->pdo->prepare($req);

        
            $stmt->bindParam(":categorie_id", $data['categorie_id'], PDO::PARAM_INT);
            $stmt->bindParam(":nom", $data['nom'], PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

             $stmt->execute();
        
         //VERIFIE SI UNE LIGNE A ETAIT MODIFIER
        return $stmt->rowCount() > 0;
    }


    public function deleteDBCategorie ($id)

    {
        $req = " DELETE FROM  categorie
                  WHERE categorie_id= :id";


        $stmt = $this->pdo->prepare($req);

       
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

         $stmt->execute();
        
         //VERIFIE SI UNE LIGNE A ETAIT MODIFIER
        return $stmt->rowCount() > 0;
    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                           

}
// $chauffeurModel = new ChauffeurModel();
// print_r($chauffeurModel->getDBAllChauffeurs());