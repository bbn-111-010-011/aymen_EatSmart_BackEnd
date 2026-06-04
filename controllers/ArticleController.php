<?php

require_once "models/ArticleModel.php";

class ArticleController
{
    private $model;

    public function __construct()
    {
        $this->model = new ArticleModel();
    }

    public function getAllArticles()
    {
        $article = $this->model->getDBAllArticles();
        echo json_encode($article);
    }





    public function getArticleById ($idArticle) 
    {
        $lignesArticle = $this->model->getDBArticleById($idArticle);
        echo json_encode($lignesArticle);
    }





    public function getArticleByIdCommande ($idArticle)
     {
        $lignesArticle = $this->model->getDBArticleByIdCommande($idArticle);
        echo json_encode($lignesArticle);
    }






    public function createArticle($data)
     {
        $lignesArticle=$this->model->createDBArticle($data);
        http_response_code(201);
        echo json_encode($lignesArticle);
     }





     public function updateArticle($id, $data)
     {
      
      $success=$this->model->updateDBArticle($id ,$data);
      if($success)
      {
        http_response_code(204);
      }
      
      else 
      {
        http_response_code(404);
        echo json_encode(["message" => "article non trouve ou non mdifie"]);
      }
     }



     public function deleteArticle($id)
     {
        $success=$this->model->deleteDBArticle($id);
        if ($success)
        {
            http_response_code(204);
        }
        else
        {
            http_response_code(404);
            echo json_encode(["message"=> "article introuvable"]);
        }
     }

    


    
     
}
// $chauffeurController = new ChauffeurController();
// $chauffeurController->getAllChauffeurs();