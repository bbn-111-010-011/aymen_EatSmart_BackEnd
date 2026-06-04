<?php
require_once "controllers/ArticleController.php";
require_once "controllers/AssocArticleCommandeController.php";
require_once "controllers/CategorieController.php";
require_once "controllers/CommandeController.php";

require_once "models/ArticleModel.php";
require_once "models/AssocArticleCommandeModel.php";
require_once "models/CategorieModel.php";
require_once "models/CommandeModel.php";

header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$articleController = new ArticleController();
$assocarticlecommandeController = new AssocArticleCommandeController();
$categorieController = new CategorieController();
$commandeController = new CommandeController();



// Vérifie si le paramètre "page" est vide ou non présent dans l'URL
if (empty($_GET["page"])) {
    // Si le paramètre est vide, on affiche un message d'erreur
    echo "Cette page est introuvable.";
} else {
    // Sinon, on récupère la valeur du paramètre "page"
    // Par exemple, si l’URL est : index.php?page=chauffeurs/3
    // Alors $_GET["page"] vaut "chauffeurs/3"
    
    // On découpe cette chaîne en segments, en séparant sur le caractère "/"
    // Cela donne un tableau, ex : ["chauffeurs", "3"]
    $url = explode("/", $_GET['page']);
    $method = $_SERVER["REQUEST_METHOD"];
    // Affiche le contenu du tableau pour vérifier comment l’URL est interprétée
    //print_r($url);



    // On teste le premier segment pour déterminer la ressource demandée
    switch($url[0]) {
        case "articles" : 

            switch ($method) 
            {
                case "GET":
                            // Si un second segment est présent (ex: un ID), on l’utilise
                    if (isset($url[1])) 
                    {
                        if (isset($url[2])) 
                        {
                            $articleController->getArticleByIdCommande($url[1]);
                        } 
                        else 
                        {
                        // Exemple : /chauffeurs/3 → affiche les infos du chauffeur 3
                        $articleController->getArticleById($url[1]);
                        }
                    } 
                    else 
                    {
                        // Sinon, on affiche tous les chauffeurs
                        $articleController->getAllArticles();
                    }
                    break;

                 case "POST":
                    $data =json_decode(file_get_contents("php://input"),true);
                    $articleController->createArticle($data);   

                    break;

                case "PUT":
                    if (isset($url[1])) 
                        {
                        $data =json_decode(file_get_contents("php://input"),true);
                        $articleController->updateArticle($url[1],$data); 
                        echo json_encode($data);
                        }


                    else
                    {
                        http_response_code(400);
                        echo json_encode(["message"=>"ID du article manquant dans l'URL"]);
                    }


                    case "DELETE":
                        if (isset($url[1])) 

                        {
                           $articleController->deleteArticle($url[1]);

                        }

                        else
                        {
                            http_response_code(400);
                            echo json_encode(["message"=>"ID manquant manquant dans l'URL"]);
                        }

                    


           }
            break;
            case "clients" :
             switch ($method) 
            {
                case "GET":
                            // Si un second segment est présent (ex: un ID), on l’utilise
                    if (isset($url[1])) 
                    {
                        if (isset($url[2])) {
                            $clientController->getClientByIdVoitures($url[1]);
                        } else {
                        // Exemple : /chauffeurs/3 → affiche les infos du chauffeur 3
                        $clientController->getClientById($url[1]);
                        }
                    } 
                    else 
                    {
                        // Sinon, on affiche tous les chauffeurs
                        $clientController->getAllClients();
                    }
                    break;
                    case "POST":
                    $data =json_decode(file_get_contents("php://input"),true);
                    $clientController->createClient($data);    
                    break;


                    case "PUT":
                        if (isset($url[1])) 

                        {
                            $data =json_decode(file_get_contents("php://input"),true);
                            $clientController->updateClient($url[1], $data);
                            echo json_encode($data);

                        }

                        else
                        {
                            http_response_code(400);
                            echo json_encode(["message"=>"ID chauffeur manquant dans l'URL"]);
                        }


                        case "DELETE":
                        if (isset($url[1])) 

                        {
                           $clientController->deleteClient($url[1]);

                        }

                        else
                        {
                            http_response_code(400);
                            echo json_encode(["message"=>"ID chauffeur manquant dans l'URL"]);
                        }

           }

            break;
            case "categorie":
                switch ($method) 
            {
                case "GET":
                            // Si un second segment est présent (ex: un ID), on l’utilise
                    if (isset($url[1])) 
                    {
                        if (isset($url[2])) {
                            $categorieController->getCategorieByIdVoitures($url[1]);
                        } else {
                        // Exemple : /chauffeurs/3 → affiche les infos du chauffeur 3
                        $categorieController->getCategorieById($url[1]);
                        }

                    } 
                    else 
                    {
                        // Sinon, on affiche tous les chauffeurs
                        $categorieController->getAllCategories();
                    }
                    break;
                    case "POST":
                    $data =json_decode(file_get_contents("php://input"),true);
                    $categorieController->createCategorie($data);    
                    break;


                    case "PUT":
                        if (isset($url[1])) 

                        {
                            $data =json_decode(file_get_contents("php://input"),true);
                            $categorieController->updateCategorie($url[1], $data);
                            echo json_encode($data);

                        }

                        else
                        {
                            http_response_code(400);
                            echo json_encode(["message"=>"ID categorie manquante dans l'URL"]);
                        }


                        case "DELETE":
                        if (isset($url[1])) 

                        {
                           $categorieController->deleteCategorie($url[1]);

                        }

                        else
                        {
                            http_response_code(400);
                            echo json_encode(["message"=>"ID categorie manquant dans l'URL"]);
                        }
                        

           }

            break;
            case "commande":
                 switch ($method) 
            {
                case "GET":
                            // Si un second segment est présent (ex: un ID), on l’utilise
                    if (isset($url[1])) 
                    {
                        if (isset($url[2])) {
                            $commandeController->getCommandesByIdVoitures($url[1]);
                        } else {
                        // Exemple : /chauffeurs/3 → affiche les infos du chauffeur 3
                        $commandeController->getCommandeById($url[1]);
                        }

                    } 
                    else 
                    {
                        // Sinon, on affiche tous les chauffeurs
                        $commandeController->getAllCommandes();
                    }
                    break;
                    case "POST":
                    $data =json_decode(file_get_contents("php://input"),true);
                    $commandeController->createCommande($data);    
                    break;


                    case "PUT":
                        if (isset($url[1])) 

                        {
                            $data =json_decode(file_get_contents("php://input"),true);
                            $commandeController->updateCommande($url[1], $data);
                            echo json_encode($data);

                        }

                        else
                        {
                            http_response_code(400);
                            echo json_encode(["message"=>"ID COMMANDE manquant dans l'URL"]);
                        }


                        case "DELETE":
                        if (isset($url[1])) 

                        {
                           $commandeController->deleteCommande($url[1]);

                        }

                        else
                        {
                            http_response_code(400);
                            echo json_encode(["message"=>"ID comande manquant dans l'URL"]);
                        }
                        

           }


            break;
            // Si la ressource n'existe pas, on renvoie un message d’erreur
            default :
                echo "La page n'existe pas";
    }
}
