<?php
include_once "../klasy/Baza.php";
include_once "../klasy/User.php";
$db = new Baza('localhost', 'root','','klienci');
$userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_ADD_SLASHES);
$sql = "DELETE FROM koszyk WHERE userId = $userId";
if($db->delete($sql)){
echo "Usunięto zawartość twojego koszyka";
}
else{
    echo "<p id='blad'>Wystąpił problem z usuwaniem zawartości koszyka! Sprobuj ponownie później.</p>";
}