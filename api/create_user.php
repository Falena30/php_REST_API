<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
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

    include_once "../class/user.php";
    include_once "../config/database.php";

    $database = new Databse;
    $db = $database->getConnection();

    $user = new User($db);

    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // get jwt
    $jwt=isset($data->jwt) ? $data->jwt : "";

    //decode jwt
    if($jwt){
        //jika sukses show
        try {
            //decode here
            $decoded = JWT::decode($jwt,$key,array('HS256'));
            
            $user->firstname = $data->firstname;
            $user->lastname = $data->lastname;
            $user->email = $data->email;
            $user->password = $data->password;
            $user->id = $decoded->data->id;

            // update the user record
            if($user->update()){
                // we need to re-generate jwt because user details might be different
                $token = array(
                    "iat" => $issued_at,
                    "exp" => $expiration_time,
                    "iss" => $issuer,
                    "data" => array(
                        "id" => $user->id,
                        "firstname" => $user->firstname,
                        "lastname" => $user->lastname,
                        "email" => $user->email
                    )
                );
                $jwt = JWT::encode($token, $key);
                
                // set response code
                http_response_code(200);
                
                // response in json format
                echo json_encode(
                        array(
                            "message" => "User was updated.",
                            "jwt" => $jwt
                        )
                    );
            }else{
                // set response code
                http_response_code(401);
            
                // show error message
                echo json_encode(array("message" => "Unable to update user."));
            }
    
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