<?php

include_once('AltoRouter.php');

$router = new AltoRouter();
$router->setBasePath('/webservice/');

function header_status($statusCode) {
    static $status_codes = null;

    if ($status_codes === null) {
        $status_codes = array (
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended'
        );
    }

    if ($status_codes[$statusCode] !== null) {
        $status_string = $statusCode . ' ' . $status_codes[$statusCode];
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
    }
}

/*********************************************************
 * Partie SERVEUR du service web RESTful. 
 *********************************************************/


/**
 * Connexion au SGBD
 */
try {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=bd_rest', 'root', '');
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}


/**
 * Champs de la ressource ville
 */
$cols = array('Nom_Ville','MAJ','Code_Postal','Code_INSEE','Code_Region','Latitude','Longitude','Eloignement');



/**
 * Verbe HTTP
 */
$method = $_SERVER['REQUEST_METHOD'];


/*********************************************************
 * Partie GETTER. 
 *********************************************************/


//obtenir toutes les villes
$router->map( 'GET', 'villes', function (){

    global $pdo,$cols,$sql;

    /**
     * Requète SQL
     */

    //$sql = "SELECT * FROM `villes` LIMIT 5";
    $sql = "SELECT * FROM `villes`";

    if($stmt = $pdo->query($sql)) {
        $items = $stmt->fetchAll();
    }

    /**
     * Affichage terminal : présentation en JSON
     */
    header('Content-Type: application/json');
    echo json_encode($items);
    // corrigé par Antunes Lonny
} );


//obtenir que les noms des villes
$router->map( 'GET', 'villes/noms/', function (){

    global $pdo,$cols,$sql;

    /**
     * Requète SQL
     */

    //$sql = "SELECT * FROM `villes` LIMIT 5";
    $sql = "SELECT Nom_Ville FROM `villes`";

    if($stmt = $pdo->query($sql)) {
        $items = $stmt->fetchAll();
    }

    /**
     * Affichage terminal : présentation en JSON
     */
    header('Content-Type: application/json');
    echo json_encode($items);
    // corrigé par Antunes Lonny
} );




//obtenir les villes dont le nom contient $villle
$router->map( 'GET', 'villes/[a:villes]', function ($villes) {
    global $pdo,$cols,$sql;
    
        /**
         * Requète SQL
         */

        //$sql = "SELECT * FROM `villes` LIMIT 5";      
        $sql = "SELECT * FROM `villes` WHERE MAJ LIKE '%$villes%' ";
        
        if($stmt = $pdo->query($sql)) {
            $items = $stmt->fetchAll();
             /**
             * Affichage terminal : présentation en JSON
             */ 
            header('Content-Type: application/json');       
            echo json_encode($items);

        } else {
            header_status(424);
        }
        
       

});
//obtenir la région d'une ville
$router->map( 'GET', 'ville/[i:id]/region/', function ($id) {
    global $pdo,$cols,$sql;
    
        /**
         * Requète SQL
         */

        $sql = "SELECT DISTINCT(Code_Region) FROM `villes` WHERE CODE_INSEE=$id ";
       
        if($stmt = $pdo->query($sql)) {
            $items = $stmt->fetchAll();
             /**
             * Affichage terminal : présentation en JSON
             */ 
            header('Content-Type: application/json');       
            echo json_encode($items);
            // corrigé par Antunes Lonny
        }else{
            header_status(424);
        }
        
       

});

//obtenir la position GPS d'une ville
$router->map( 'GET', 'ville/[i:id]/gps/', function ($id) {
    global $pdo,$cols,$sql;
    
        /**
         * Requète SQL
         */

        $sql = "SELECT Latitude,Longitude FROM `villes` WHERE CODE_INSEE=$id ";
       
        if($stmt = $pdo->query($sql)) {
            $items = $stmt->fetchAll();
             /**
             * Affichage terminal : présentation en JSON
             */ 
            header('Content-Type: application/json');       
            echo json_encode($items);
            // corrigé par Antunes Lonny
        }else{
            header_status(424);
        }
        
       

});


//obtenir une ville par CODE INSEE
$router->map( 'GET', 'ville/[i:di]', function ($id) {
    global $pdo,$cols,$sql;
    
        /**
         * Requète SQL
         */

        //$sql = "SELECT * FROM `villes` LIMIT 5";      
        $sql = "SELECT * FROM `villes` WHERE CODE_INSEE=$id ";

        if($stmt = $pdo->query($sql)) {
            $items = $stmt->fetchAll();
             /**
             * Affichage terminal : présentation en JSON
             */ 
            header('Content-Type: application/json');       
            echo json_encode($items);
        }else{
            header_status(424);
        }
        
       
        // corrigé par Antunes Lonny

});
/*********************************************************
 * Partie DELETE. 
 *********************************************************/

//DELETE  une ville par CODE INSEE
$router->map( 'DELETE', 'ville/[i:id]', function ($id) {
    global $pdo,$cols,$sql;
    
        /**
         * Requète SQL
         */

        //$sql = "SELECT * FROM `villes` LIMIT 5";      
        $sql = "DELETE FROM `villes` WHERE CODE_INSEE=$id ";

        if($stmt = $pdo->query($sql)) {
            $items = $stmt->fetchAll();
             /**
             * Affichage terminal : présentation en JSON
             */ 
            header('Content-Type: application/json');       
            echo json_encode($items);
        }else{
            header_status(424);
        }

});
/*********************************************************
 * Partie PATCH. 
 *********************************************************/
$router->map( 'PATCH', 'ville/[i:id]/[i:nb_habitant]', function ($id,$nb_habitant) {
    global $pdo,$cols,$sql;
    
        /**
         * Requète SQL
         */

        //$sql = "SELECT * FROM `villes` LIMIT 5";      
        $sql = "UPDATE nb_habitant =$nb_habitant FROM`villes` WHERE CODE_INSEE=$id ";

        if($stmt = $pdo->query($sql)) {
            $items = $stmt->fetchAll();
             /**
             * Affichage terminal : présentation en JSON
             */ 
            header('Content-Type: application/json');       
            echo json_encode($items);
        }else{
            header_status(424);
        }

});




// match route
$match = $router->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) {
   call_user_func_array( $match['target'], $match['params'] ); 
} else {
   header_status(404);
}
?>