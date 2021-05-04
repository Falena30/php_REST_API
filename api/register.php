<?php
    header("Access-Control-Allow-Origin: http://localhost/php_crud/");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
    include_once "../class/user.php";
    include_once "../config/database.php";

    $database = new Databse;
    $db = $database->getConnection();

    //init db
    $user = new User($db);

    //buat inputan untuk json
    $data = json_decode(file_get_contents("php://input"));

    $user->firstname = $data->firstname;
    $user->lastname = $data->lastname;
    $user->email = $data->email;
    $user->password = $data->password;



    //eksekusi
    if(!empty($user->firstname) && !empty($user->email) && !empty($user->password) && $user->postUser()){
        http_response_code(200);
        echo json_encode(array("message" => "user berhasil register"));
    }else{
        http_response_code(400);
        echo json_encode(array("message" => "user gagal register"));
    }
?>