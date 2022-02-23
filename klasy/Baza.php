<?php
    class Baza {
        private $mysqli; 
        public function __construct($serwer, $user, $pass, $baza) {
            $this->mysqli = new mysqli($serwer, $user, $pass, $baza);
        
            if ($this->mysqli->connect_errno) {
                printf("Nie udało sie połączenie z serwerem: %s\n", $this->mysqli->connect_error);
                exit();
            }
            /* zmien kodowanie na utf8 */
            if ($this->mysqli->set_charset("utf8")) {
            //udało sie zmienić kodowanie
            }
        } //koniec funkcji konstruktora
        function __destruct() {
            $this->mysqli->close();
        }

        public function select($sql, $pola) {
        //parametr $sql – łańcuch zapytania select
        //parametr $pola - tablica z nazwami pol w bazie
        //Wynik funkcji – kod HTML tabeli z rekordami (String)
            $tresc = "";
            if ($result = $this->mysqli->query($sql)) {
                $ilepol = count($pola); //ile pól
                $ile = $result->num_rows; //ile wierszy
                // pętla po wyniku zapytania $results
                $tresc.="<table><tbody>";
                while ($row = $result->fetch_object()) {
                    $tresc.="<tr>";
                    for ($i = 0; $i < $ilepol; $i++) {
                        $p = $pola[$i];
                        $tresc.="<td>" . $row->$p . "</td>";
                    }
                    $tresc.="</tr>";
                }
                $tresc.="</table></tbody>";
                $result->close(); /* zwolnij pamięć */
            }
            return $tresc;
        }

        public function wyswietlUzytkownika($sql, $pola) {

            $tresc = "<style>table, th, td {border: 1px solid black;}</style>";
            if ($result = $this->mysqli->query($sql)) {
                $ilepol = count($pola); //ile pól
                $ile = $result->num_rows; //ile wierszy
                // pętla po wyniku zapytania $results
                $tresc.="<table><tbody><tr><td id='naglowek'>Nazwa użytkownika</td><td id='naglowek'>Imię i nazwisko</td><td id='naglowek'>Email</td></tr>";
                while ($row = $result->fetch_object()) {
                    $tresc.="<tr>";
                    for ($i = 0; $i < $ilepol; $i++) {
                        $p = $pola[$i];
                        $tresc.="<td>" . $row->$p . "</td>";
                    }
                    $tresc.="</tr>";
                }
                $tresc.="</table></tbody>";
                $result->close(); /* zwolnij pamięć */
            }
            return $tresc;
        }

        public function pokazKoszyk($sql, $pola, $userId) {
            //parametr $sql – łańcuch zapytania select
            //parametr $pola - tablica z nazwami pol w bazie
            //Wynik funkcji – kod HTML tabeli z rekordami (String)
                $tresc = "";
                $j = 0; //zmienna pomocnicza licznik do przycisku usun
                if ($result = $this->mysqli->query($sql)) {
                    $ilepol = count($pola); //ile pól
                    $ile = $result->num_rows; //ile wierszy
                    // pętla po wyniku zapytania $results
                    if($ile === 0){
                        $tresc.="Koszyk jest pusty!";
                        
                    }
                    else{
                    $tresc.="<br><table class='table'><tbody><tr><td id='naglowek'>ID Produktu</td><td id='naglowek'>Nazwa produktu</td><td id='naglowek'>Cena</td><td id='naglowek'>Kolor</td><td id='naglowek'>Ilość sztuk</td><td id='naglowek'>Akcja</td></tr>";
                    while ($row = $result->fetch_object()) {
                        $tresc.="<tr>";
                        $j = $row->itemId; //odczytujemy itemID z bazy
                        for ($i = 0; $i < $ilepol; $i++) {
                            $p = $pola[$i];//nazwy pol z tabeli
                            $tresc.="<td>" . $row->$p . "</td>";//$row->$p zawartosc z bazy
                            //var_dump( $row->$p);
                            
                        }
                       
                        $tresc.="<td><button id='usun' onclick='usunElement($j,$userId)' >usuń</button></td>";
                        $tresc.="</tr>";
                    }
                    $tresc.="</table></tbody>";
                    
                    $result->close(); /* zwolnij pamięć */
                }
                return $tresc;
            }
            }

        public function insert($sql) {
            if( $this->mysqli->query($sql)) return true; else return false;
        }

        public function delete($sql) {
            if( $this->mysqli->query($sql)) return true; else return false;
        }

        public function getMysqli() {
            return $this->mysqli;
        }

        public function selectUser($login, $passwd, $tabela) {
            $id = -1;
            $sql = "SELECT * FROM $tabela WHERE userName='$login'";
            if ($result = $this->mysqli->query($sql)) {
                $ile = $result->num_rows;
                    if ($ile == 1) {
                        $row = $result->fetch_object();
                        $hash = $row->passwd; 
                        if (password_verify($passwd, $hash))
                            $id = $row->id; 
                    }
            }
            return $id;
            $result->close();
           }

      
    }
?>