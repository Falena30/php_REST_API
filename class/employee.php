<?php
    //buatlah class untuk employee
    class employee{
        //buatlah vvariabel conn
        private $conn;

        //buatlah variabel untuk menampng nama table
        private $t_name = "employee";

        //buatlah variabel sejumlah kolomnya
        public $id;
        public $name;
        public $email;
        public $age;
        public $designation;
        public $created;

        //panggil construct untuk koneksi db
        public function __construct($db){
            $this->conn = $db;
        }

        //buatlah fungsi untuk mengambil semua nlai dari table
        public function getAll(){
            $sqlQuery = "SELECT * FROM ".$this->t_name."";
            //prepate stamt;
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            //kembalikan nilai stmt
            return $stmt;
        }

        //buatlah fungsi untuk create data ke table
        public function createEmployee(){
            $sqlQuery = "INSERT INTO ".$this->t_name."
                SET
                    name= :name,
                    email= :email,
                    age= :age,
                    designation= :designation,
                    created= :created";
            //persiapkan sqlnya dan masukkan ke dalam variabel stmt
            $stmt = $this->conn->prepare($sqlQuery);

            //senitaze
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->age=htmlspecialchars(strip_tags($this->age));
            $this->designation=htmlspecialchars(strip_tags($this->designation));
            $this->created=htmlspecialchars(strip_tags($this->created));

            //bind
            $stmt->bindParam(":name",$this->name);
            $stmt->bindParam(":email",$this->email);
            $stmt->bindParam(":age",$this->age);
            $stmt->bindParam(":designation",$this->designation);
            $stmt->bindParam(":created",$this->created);

            //eksekusi 
            if ($stmt->execute()){
                return true;
            }
            return false;
            
        }

        //buatlah fungsi yang bisa read single data
        public function getSingleData(){
            //buatlah query
            $sqlQuery = "SELECT 
                            * 
                        FROM
                        ".$this->t_name."
                        WHERE 
                            id = ?
                        LIMIT 0,1";
            //siapkan stmt
            $stmt = $this->conn->prepare($sqlQuery);
            //bindParam
            $stmt->bindParam(1,$this->id);
            //eksekusi perintahnya
            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->age = $dataRow['age'];
            $this->designation = $dataRow['designation'];
            $this->created = $dataRow['created'];
        }

        //buatlah function untuk update
        public function updateData(){
            //buatlah query, cobalah untuk vertical
            $sqlQuery = "UPDATE
                        ". $this->t_name ."
                    SET
                        name = :name, 
                        email = :email, 
                        age = :age, 
                        designation = :designation, 
                        created = :created
                    WHERE 
                        id = :id";
            //persiapkan statement
            $stmt = $this->conn->prepare($sqlQuery);

            //convert string
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->age=htmlspecialchars(strip_tags($this->age));
            $this->designation=htmlspecialchars(strip_tags($this->designation));
            $this->created=htmlspecialchars(strip_tags($this->created));
            //id karena ini update pada satu row
            $this->id=htmlspecialchars(strip_tags($this->id));

            //bind
            $stmt->bindParam(":name",$this->name);
            $stmt->bindParam(":email",$this->email);
            $stmt->bindParam(":age",$this->age);
            $stmt->bindParam(":designation",$this->designation);
            $stmt->bindParam(":created",$this->created);
            //id
            $stmt->bindParam(":id",$this->id);

            //eksekusi
            if($stmt->execute()){
                return true;
            }
            return false;
        }

        //buatlah fungsi untuk delete
        public function deleteData(){
            //buatlah query
            $sqlQuery = "DELETE FROM " . $this->t_name . " WHERE id = ?";

            //persiapkan stmt
            $stmt = $this->conn->prepare($sqlQuery);

            //cukup converte id
            $this->id=htmlspecialchars(strip_tags($this->id));

            //bind
            $stmt->bindParam(1,$this->id);

            //eksekusi
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>