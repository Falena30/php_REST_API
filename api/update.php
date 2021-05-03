<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once "../config/database.php";
    include_once "../class/employee.php";

    $database = new Databse();
    $db = $database->getConnection();

    $item = new employee($db);

    //buat intputan untuk json
    $data = json_decode(file_get_contents("php://input"));

    //karean perlu where id
    $item->id = $data->id;

    //masukkan datanya kedalam variabel
    $item->name = $data->name;
    $item->email = $data->email;
    $item->age = $data->age;
    $item->designation = $data->designation;
    $item->created = date('Y-m-d H:i:s');

    //langsung eksekusi
    if($item->updateData()){
        echo "data berhasil di update";
    }else{
        echo "data gagal di update";
    }


?>