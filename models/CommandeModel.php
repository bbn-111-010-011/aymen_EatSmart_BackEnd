<?php

class CommandeModel
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


  public function getDBAllCommandes()
    {
        $stmt = $this->pdo->query("SELECT * FROM Commande");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public function getDBCommandeById ($idCommande) {
        $req = "
            SELECT * FROM commande
            WHERE commande_id = :idCommande
        ";
        $stmt = $this->pdo->prepare($req);
        $stmt->bindValue(":idCommande", $idCommande, PDO::PARAM_INT);
        $stmt->execute();
        $commande = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $commande;
    }


    public function getDBCommandeByIdDetails ($idTrajet) {
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

    public function createDBCommande($data)
    {
        $req = " INSERT INTO commande (commande_id, date_commande, prix_total ,etat)
            VALUES (:commande_id,:date_commande,:prix_total,:etat)";
             $stmt = $this->pdo->prepare($req);

            $stmt->bindParam(":commande_id", $data['commande_id'], PDO::PARAM_INT);
            $stmt->bindParam(":date_commande", $data['date_commande'], PDO::PARAM_STR);
            $stmt->bindParam(":prix_total", $data['prix_total'], PDO::PARAM_INT);
             $stmt->bindParam(":etat", $data['etat'], PDO::PARAM_STR);
            $stmt->execute();
        
            $commande=$this->getDBCommandeById($data['commande_id']);        

        return $commande;
    }





     public function updateDBCommande ($id, $data)

    {
        $req = " UPDATE commande
                 SET    commande_id=:commande_id, date_commande=:date_commande ,prix_total=:prix_total ,etat=:etat
                 WHERE  commande_id=:id";


        $stmt = $this->pdo->prepare($req);

        
           $stmt->bindParam(":commande_id", $data['commande_id'], PDO::PARAM_INT);
            $stmt->bindParam(":date_commande", $data['date_commande'], PDO::PARAM_STR);
            $stmt->bindParam(":prix_total", $data['prix_total'], PDO::PARAM_INT);
            $stmt->bindParam(":etat", $data['etat'], PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

             $stmt->execute();
        
         //VERIFIE SI UNE LIGNE A ETAIT MODIFIER
        return $stmt->rowCount() > 0;
    }



    public function deleteDBCommande ($id)

    {
        $req = " DELETE FROM  commande
                  WHERE commande_id= :id";


        $stmt = $this->pdo->prepare($req);

       
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

         $stmt->execute();
        
         //VERIFIE SI UNE LIGNE A ETAIT MODIFIER
        return $stmt->rowCount() > 0;
    }

}
// $chauffeurModel = new ChauffeurModel();
// print_r($chauffeurModel->getDBAllChauffeurs());