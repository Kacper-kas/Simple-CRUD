<?php
include_once "../klasy/Baza.php";
$db = new Baza('localhost', 'root','','klienci');
$userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_ADD_SLASHES);
$sql = "select * from koszyk where userId = $userId";
echo $db->pokazKoszyk($sql,["itemId","nazwa","cena","kolor","ilosc"],$userId);//bez kolumny userId i itemId bo tego uzytkownik ma nie widziec
