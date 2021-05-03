<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once "../config/database.php";
    include_once "../class/employee.php";

    //pnaggil class databae
    $databse = new Databse();
    //panggil fungsinya
    $db = $databse->getConnection();

    //panggil class employee
    $item = new employee($db);

    //ambil satu datanya
    $item->id = isset($_GET['id']) ? $_GET['id'] : die();

    //panggil fungsinya
    $item->getSingleData();

    //data tidak konsong
    if($item->name != null){
        //buatlah array
        $e = array(
            "id" => $item->id,
            "name" => $item->name,
            "age" => $item->age,
            "email" => $item->email,
            "designation" => $item->designation,
            "created" => $item->created //yang terakhir tidak usah ,
        );
        http_response_code(200);//ada
        //cetak
        echo json_encode($e);
    }else{
        http_response_code(404);//kosong
        echo json_encode("employee tidak ada");
    }
?>