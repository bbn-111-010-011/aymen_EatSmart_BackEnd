<?php

class ArticleModel
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

    public function getDBAllArticles()
    {
        $stmt = $this->pdo->query("SELECT * FROM Article");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getDBArticleById ($idArticle) {
        $req = "
            SELECT * FROM article
            WHERE article_id = :Articleid
        ";
        $stmt = $this->pdo->prepare($req);
        $stmt->bindValue(":Articleid", $idArticle, PDO::PARAM_INT);

        $stmt->execute();

        $article = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $article;
    }


     public function getDBArticleByIdCommande ($idArticle) {
        $req = "
                    SELECT 
                    c.commande_id,
                    c.date_commande,
                    c.prix_total,
                    c.etat,
                    ac.quantite_article,
                    a.article_id,
                    a.nom AS article_nom,
                    a.prix AS article_prix
                FROM commande c
                INNER JOIN assoc_article_commande ac
                    ON c.commande_id = ac.commande_id
                INNER JOIN article a
                    ON ac.article_id = a.article_id
                WHERE a.article_id = :idArticle

        ";
        $stmt = $this->pdo->prepare($req);
        $stmt->bindValue(":idArticle", $idArticle, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $article;
    }





     

    public function createDBArticle($data)
    {
        $req = " INSERT INTO article (article_id, nom, prix,description, categorie_id)
            VALUES (:article_id,:nom,:prix,:description,:categorie_id)";
             $stmt = $this->pdo->prepare($req);

            $stmt->bindParam(":article_id", $data['article_id'], PDO::PARAM_INT);
            $stmt->bindParam(":nom", $data['nom'], PDO::PARAM_STR);
            $stmt->bindParam(":prix", $data['prix'], PDO::PARAM_STR);
            $stmt->bindParam(":description", $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(":categorie_id", $data['categorie_id'], PDO::PARAM_INT);
            $stmt->execute();
        
            $article=$this->getDBArticleById($data['article_id']);        

        return $article;
    }




     public function updateDBArticle ($id, $data)

    {
        $req = " UPDATE article
                  SET article_id=:article_id, nom=:nom, prix=:prix, description=:description, categorie_id=:categorie_id
                  WHERE article_id=:id";


        $stmt = $this->pdo->prepare($req);

        
            $stmt->bindParam(":article_id", $data['article_id'], PDO::PARAM_INT);
            $stmt->bindParam(":nom", $data['nom'], PDO::PARAM_STR);
            $stmt->bindParam(":prix", $data['prix'], PDO::PARAM_STR);
            $stmt->bindParam(":description", $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(":categorie_id", $data['categorie_id'], PDO::PARAM_INT);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

             $stmt->execute();
        
         //VERIFIE SI UNE LIGNE A ETAIT MODIFIER
        return $stmt->rowCount() > 0;
    }




    public function deleteDBArticle ($id)

    {
        $req = " DELETE FROM  article 
                  WHERE article_id= :id";


        $stmt = $this->pdo->prepare($req);

       
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

         $stmt->execute();
        
         //VERIFIE SI UNE LIGNE A ETAIT MODIFIER
        return $stmt->rowCount() > 0;
    }




    
}
// $chauffeurModel = new ChauffeurModel();
// print_r($chauffeurModel->getDBAllChauffeurs());


 