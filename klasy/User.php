<?php
//klasa zwiazana z obsluga uzytkownikow
    class User {
        const STATUS_USER = 1;
        const STATUS_ADMIN = 2;
        protected $userName;
        protected $passwd;
        protected $fullName;
        protected $email;
        protected $date;
        protected $status;

        function __construct($userName, $fullName, $email, $passwd ){
        
            $this->status=User::STATUS_USER;
            $this->userName=$userName;
            $this->passwd=password_hash($passwd,PASSWORD_DEFAULT);
            $this->fullName=$fullName;
            $this->email=$email;
            $this->date=new DateTime("NOW");
        }


        static function getAllUsersFromDB($db){
            return $db->select("SELECT userName, fullName, email, status, date FROM users", ["userName", "fullName", "email", "status", "date"]);
        }

        static function countLoggedUsers($db){
            $ile = 0;
            if($result = $db->getMysqli()->query("SELECT * FROM logged_in_users")){
                $ile = $result->num_rows;
            }
            $result->close();
            return $ile;
     
        }

        static function countRegisteredUsers($db){
            $ile = 0;
            if($result = $db->getMysqli()->query("SELECT * FROM users")){
                $ile = $result->num_rows;
            }
            $result->close();
            return $ile;
     
        }

        static function countBasketItems($db,$userId){
            $ile = 0;
            if($result = $db->getMysqli()->query("SELECT SUM(ilosc) FROM koszyk WHERE userId=$userId")){
                $row = mysqli_fetch_assoc($result); //tablica asocjacyjna
                $ile = $row['SUM(ilosc)'];//przypisujemy do zmiennej wartosc zwroconej kolumny
                if($ile == NULL)
                    $ile=0;
            }
            $result->close();
            return $ile;
     
        }

        static function updateBasketCount($db, $userId){
            $ilosc = User::countBasketItems($db,$userId);
            echo"<script>document.getElementById('licznik').innerHTML = $ilosc</script>";
        }

        public function show(){
            echo "Nazwa uzytkownika: ".$this->username."<br>Hasło: ".$this->passwd."<br>Imie i nazwisko: ".$this->fullname."<br>Email: ".$this->email."<br>Data utworzenia: ".$this->date."<br>Status: ". $this->status;
        }

        Public function setUserName($userName){
            $this->userName=$userName;
        }

        Public function getUserName(){
            return $this->userName;
        }

        Public function setStatus($status){
           $this->status=$status; 
        }

        Public function getStatus(){
            return $this->status;
        }

        Public function saveDB($db){
            $db->insert("INSERT INTO users (userName, fullName, email, passwd, status, date) VALUES ('".$this->userName."','".$this->fullName."','".$this->email."','".$this->passwd."','".$this->status."','".$this->date->format('Y-m-d')."')");
        }


    }
?>