<?php

require_once "models/CategorieModel.php";

class CategorieController
{
    private $model;

    public function __construct()
    {
        $this->model = new CategorieModel();
    }




    public function getAllCategories()
    {
        $categories = $this->model->getDBAllCategories();
        echo json_encode($categories);
    }

    public function getCategorieById ($idCategorie) {
        $lignesCategorie = $this->model->getDBCategorieById($idCategorie);
        echo json_encode($lignesCategorie);
    }




    public function getTrajetByIdDetails ($idTrajet) {
        $lignesTrajet = $this->model->getDBTrajetByIdDetails($idTrajet);
        echo json_encode($lignesTrajet);
    }


     public function createCategorie($data)
     {
        $lignesCategorie=$this->model->createDBCategorie($data);
        http_response_code(201);
        echo json_encode($lignesCategorie);
     }








      public function updateCategorie($id, $data)
     {
      
      $success=$this->model->updateDBCategorie($id ,$data);
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



     public function deleteCategorie($id)
     {
        $success=$this->model->deleteDBCategorie($id);
        if ($success)
        {
            http_response_code(204);
        }
        else
        {
            http_response_code(404);
            echo json_encode(["message"=> "categorie introuvable"]);
        }
     }


}
// $chauffeurController = new ChauffeurController();
// $chauffeurController->getAllChauffeurs();