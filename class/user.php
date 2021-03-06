<?php
    class User{
        //buatlah variabel conn dan nama table
        private $conn;
        private $tabel = "user";

        //buatlah variabel untuk menampung kolom
        public $id;
        public $firstname;
        public $lastname;
        public $email;
        public $password;

        //panggil construct untuk koneksi db
        public function __construct($db){
            $this->conn = $db;
        }

        //bautlah method crate user
        function postUser(){
            $sqlQuery = "INSERT INTO ".$this->tabel."
                SET
                    firstname= :firstname,
                    lastname= :lastname,
                    email= :email,
                    password= :password";
            //persiapkan sqlnya dan masukkan ke dalam variabel stmt
            $stmt = $this->conn->prepare($sqlQuery);

            $this->firstname=htmlspecialchars(strip_tags($this->firstname));
            $this->lastname=htmlspecialchars(strip_tags($this->lastname));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));

            //bind
            $stmt->bindParam(":firstname", $this->firstname);
            $stmt->bindParam(":lastname", $this->lastname);
            $stmt->bindParam(":email", $this->email);
            //khusus password gunakan hash
            $password_hash = password_hash($this->password,PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $password_hash);

            //eksekusi 
            if ($stmt->execute()){
                return true;
            }
            return false;
        }

        //buatlah method email exits?
        function EmailExist(){
            $sqlQuery = "SELECT 
                            * 
                        FROM
                        ".$this->tabel."
                        WHERE 
                            email = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);
            $this->email = htmlspecialchars(strip_tags($this->email));
            $stmt->bindParam(1,$this->email);
            $stmt->execute();

            //hitung jumlah row
            $num = $stmt->rowCount();

            if($num > 0){
                //ambil record detailnaya
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                //masukkan dari database ke variabel
                $this->id = $row['id'];
                $this->firstname = $row['firstname'];
                $this->lastname = $row['lastname'];
                $this->password = $row['password'];
                return true;
            }
            return false;
        }

        public function update(){
 
            // if password needs to be updated
            $password_set=!empty($this->password) ? ", password = :password" : "";
         
            // if no posted password, do not update the password
            $query = "UPDATE " . $this->tabel . "
                    SET
                        firstname = :firstname,
                        lastname = :lastname,
                        email = :email
                        {$password_set}
                    WHERE id = :id";
         
            // prepare the query
            $stmt = $this->conn->prepare($query);
         
            // sanitize
            $this->firstname=htmlspecialchars(strip_tags($this->firstname));
            $this->lastname=htmlspecialchars(strip_tags($this->lastname));
            $this->email=htmlspecialchars(strip_tags($this->email));
         
            // bind the values from the form
            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':email', $this->email);
         
            // hash the password before saving to database
            if(!empty($this->password)){
                $this->password=htmlspecialchars(strip_tags($this->password));
                $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password_hash);
            }
         
            // unique ID of record to be edited
            $stmt->bindParam(':id', $this->id);
         
            // execute the query
            if($stmt->execute()){
                return true;
            }
         
            return false;
        }

    }
?>