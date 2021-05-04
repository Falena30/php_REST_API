<?php
    // required headers
    header("Access-Control-Allow-Origin: http://localhost/php_crud/");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once "../class/user.php";
    include_once "../config/database.php";

    $database = new Databse;
    $db = $database->getConnection();

    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    $user->email = $data->email;
    $email_exist = $user->EmailExist();

    //JWT
    include_once '../config/core.php';
    include_once '../libs/src/BeforeValidException.php';
    include_once '../libs/src/ExpiredException.php';
    include_once '../libs/src/SignatureInvalidException.php';
    include_once '../libs/src/JWT.php';
    use \Firebase\JWT\JWT;

    if($email_exist && password_verify($data->password,$user->password)){
        $token = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "iss" => $issuer,
            "data" =>array(
                "id" => $user->id,
                "firstname" => $user->firstname,
                "lastname" => $user->lastname,
                "email" => $user->email
            )
        );
        http_response_code(200);
        //generate jwt
        $jwt = JWT::encode($token,$key);
        echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt
            )
        );
    }else{
        // set response code
        http_response_code(401);
    
        // tell the user login failed
        echo json_encode(array("message" => "Login failed."));
    }
    
?>