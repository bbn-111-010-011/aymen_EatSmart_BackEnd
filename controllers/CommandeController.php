<?php

require_once "models/CommandeModel.php";

class CommandeController
{
    private $model;

    public function __construct()
    {
        $this->model = new CommandeModel();
    }

    public function getAllCommandes()
    {
        $commandes = $this->model->getDBAllCommandes();
        echo json_encode($commandes);
    }

    public function getCommandeById($idCommandes)
    {
        $lignesCommandes = $this->model->getDBCommandeById($idCommandes);
        echo json_encode($lignesCommandes);
    }

    public function getCommandeByIdDetails($idCommandes)
    {
        $lignesCommandes = $this->model->getDBCommandeByIdDetails($idCommandes);
        echo json_encode($lignesCommandes);
    }

    public function createCommande($data)
    {
        // Supprimer id_commande si présent pour éviter le conflit AUTO_INCREMENT
        if (isset($data['id_commande'])) {
            unset($data['id_commande']);
        }

        try {
            $lignesCommandes = $this->model->createDBCommande($data);
            http_response_code(201);
            echo json_encode([
                "success" => true,
                "id_commande" => $lignesCommandes, // si ton modèle renvoie l'ID
                "message" => "Commande créée avec succès"
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Erreur lors de la création de la commande : " . $e->getMessage()
            ]);
        }
    }

    public function updateCommande($id, $data)
    {
        $success = $this->model->updateDBCommande($id, $data);
        if ($success) {
            http_response_code(204);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Commande non trouvée ou non modifiée"]);
        }
    }

    public function deleteCommande($id)
    {
        $success = $this->model->deleteDBCommande($id);
        if ($success) {
            http_response_code(204);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Commande introuvable"]);
        }
    }
}