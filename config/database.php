<?php
    //buatlah clss untu db
    class Databse
    {
        //buatlah varaibale yang berhubungan dengan db
        private $host = "localhost";//atau 127.0.0.1
        private $db_name = "phpapidb";
        private $username = "root";
        private $password = "";

        //buatlah variabel untuk menmapung conn
        public $conn;
        //buatlah fungsi untuk menghubungkan ke db
        public function getConnection(){
            //kosongkan dulu conn
            $this->conn = null;
            try {
                //konkesikan ke database
                //jangan pakai mysqli ya
                $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name,$this->username,$this->password);
                //eksekusi perintah
                $this->conn->exec("set names utf8");
            } catch (PDOException $exception) {
                //cetak jika terjadi kesalahan
                echo "Databse tidak bisa di hubungkan". $exception->getMessage();
            }
            //kembalikan nilai conn
            return $this->conn;
        }
    }
    
?>