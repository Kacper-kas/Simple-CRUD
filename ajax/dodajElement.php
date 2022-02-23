<?php
include_once "../klasy/Baza.php";
include_once "../klasy/User.php";
$db = new Baza('localhost', 'root', '', 'klienci');
$userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_ADD_SLASHES);
$nazwa = filter_input(INPUT_POST, 'nazwa', FILTER_SANITIZE_ADD_SLASHES);
$cena = filter_input(INPUT_POST, 'cena', FILTER_SANITIZE_ADD_SLASHES);
$kolor = filter_input(INPUT_POST, 'kolor', FILTER_SANITIZE_ADD_SLASHES);
$ilosc = filter_input(INPUT_POST, 'ilosc', FILTER_SANITIZE_ADD_SLASHES);
$itemId = filter_input(INPUT_POST, 'itemId', FILTER_SANITIZE_ADD_SLASHES);
if (!($userId && $nazwa && $cena && $kolor && $ilosc && $itemId)) {
 echo "Nie wypelniono niektórych pól";
} else { //jesli przeslane dane pomyslnie zwalidowane
    $ile = 0;
    if($result = $db->getMysqli()->query("SELECT * FROM koszyk where userId=$userId AND itemId=$itemId")){
        $ile = $result->num_rows;
        $row = $result->fetch_object();
        

        if($ile > 0){//jesli juz w koszyku jest taki przedmiot, to modyfikujemy ilosc w koszyku zamiast dodawac nowa pozycje
            
            $ilosc = $row->ilosc + 1;//odczytujemy ilosc przedmiotow w koszyku(w bazie) i zwiekszamy
            $sql = "UPDATE koszyk SET ilosc = $ilosc WHERE userId=$userId AND itemId=$itemId"; //aktualizujemy zawartosc bazy danych
        }else{//jesli juz w koszyku nie ma takiego przedmiotu, po prostu dodajemy go do bazy(koszyka)
            $sql = "INSERT INTO koszyk VALUES('$userId','$nazwa','$cena','$kolor','$ilosc','$itemId')";
        }
        
        
        //wywolanie sql
        if ($db->insert($sql)) {
        echo"<h4> <p id='poprawne'>Pomyślnie dodano do koszyka!</p></h4>";
        User::updateBasketCount($db, $userId);
        } else {
        echo"<h5> <p id='blad'>Pojawił się problem z dodaniem artykułu. Spróbuj ponownie za jakiś czas. </p></h5>"; }
       } 
       
    }
    
