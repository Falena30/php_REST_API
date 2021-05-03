<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once "../config/database.php";
    include_once "../class/employee.php";

    //buatlah variabel untuk menampung class database
    $database = new Databse();
    //panggil fungsinya 
    $db = $database->getConnection();

    //panggil class employee
    $item = new employee($db);

    //buat intputan untuk json
    $data = json_decode(file_get_contents("php://input"));

    //masukkan datanya kedalam variabel
    $item->name = $data->name;
    $item->age = $data->age;
    $item->email = $data->email;
    $item->designation = $data->designation;
    $item->created = date('Y-m-d H:i:s');//khusus untuk date

    //panggil fungsinya
    if($item->createEmployee()){
        echo "employee berhasil ditambahkan";
    }else{
        echo "employee gagal ditambahkan";
    }
    
?>