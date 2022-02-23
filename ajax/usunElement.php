<?php
include_once "../klasy/Baza.php";
include_once "../klasy/User.php";
$db = new Baza('localhost', 'root','','klienci');
$userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_ADD_SLASHES);
$przedmiot = filter_input(INPUT_POST, 'przedmiot', FILTER_SANITIZE_ADD_SLASHES);
$sql = "DELETE FROM koszyk WHERE userId=$userId AND itemId=$przedmiot";
$sql_pokaz = "select * from koszyk where userId = $userId";//kod sql na potrzeby ponownego wyswietlenia koszyka
$db->delete($sql);
echo $db->pokazKoszyk($sql_pokaz,["itemId","nazwa","cena","kolor","ilosc"],$userId);//ponowne wyswietlenie koszyka po usunieciu elementu
echo User::updateBasketCount($db,$userId);