<?php
    //header
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    //masukkan database
    include_once "../config/database.php";
    include_once "../class/employee.php";

    //panggil class databse
    $databse = new Databse();
    //koneksikan dengan memanggil fungsinya
    $db = $databse->getConnection();

    //panggil class employee
    $item = new employee($db);

    //panggil fungsi read all dari employee
    $stmt = $item->getAll();
    //hitung berapa banyak datanya
    $itemCount = $stmt->rowCount();

    //encode ke json
    echo json_encode($itemCount);

    //jika count tidak 0
    if ($itemCount > 0){
        //buatlah array
        $employeeArr = array();
        $employeeArr["body"] = array();
        $employeeArr["itemCount"] = $item;

        //extract datanya
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            //tampung nilainya
            $e = array(
                "id" => $id,
                "name" => $name,
                "age" => $age,
                "email" => $email,
                "designation" => $designation,
                "created" => $created //yang terakhir tidak usah ,
            );

            //masukkan kedalam array
            array_push($employeeArr["body"], $e);
        }
        echo json_encode($employeeArr);
    }else{
        http_response_code(404);
        echo json_encode(
            array("message" => "no record found.")
        );
    }
?>