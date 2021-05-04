<?php
    header("Access-Control-Allow-Origin: http://localhost/php_crud/");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


    //JWT
    include_once '../config/core.php';
    include_once '../libs/src/BeforeValidException.php';
    include_once '../libs/src/ExpiredException.php';
    include_once '../libs/src/SignatureInvalidException.php';
    include_once '../libs/src/JWT.php';
    use \Firebase\JWT\JWT;

    //get posted data
    $data = json_decode(file_get_contents("php://input"));
    //get JWT
    $jwt = isset($data->jwt) ? $data->jwt : "";

    //decode jwt
    if($jwt){
        //jika sukses show
        try {
            //decode here
            $decoded = JWT::decode($jwt,$key,array('HS256'));
            // set response code
            http_response_code(200);
    
            // show user details
            echo json_encode(array(
                "message" => "Access granted.",
                "data" => $decoded->data
            ));
    
        }catch (Exception $e){
         
            // set response code
            http_response_code(401);
         
            // tell the user access denied  & show error message
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => $e->getMessage()
            ));
        }
    }else{
 
        // set response code
        http_response_code(401);
     
        // tell the user access denied
        echo json_encode(array("message" => "Access denied."));
    }
?>