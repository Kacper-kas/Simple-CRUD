<?php
include_once "../klasy/Baza.php";
include_once "../klasy/User.php";
$db = new Baza('localhost', 'root','','klienci');
$userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_ADD_SLASHES);
$sql = "DELETE FROM logged_in_users WHERE lastUpdate < CURRENT_DATE - INTERVAL 1 HOUR;";//wylogowujemy uzytkownikow nieaktywnych od 1 godziny
if($db->delete($sql)){
echo "<p id='poprawne'>Wylogowano nieaktywnych</p>";
}
else{
    echo "<p id='blad'>Wystąpił problem!</p>";
}