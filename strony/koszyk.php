<?php 
include_once 'klasy/userManager.php';
include_once 'klasy/Baza.php';
$db = new Baza('localhost', 'root','','klienci');
$tytul="Twój koszyk"; 
$strona_akt->ustaw_style('css/styl.css'); 
echo "<style>table {width: 150%;} td, th{ text-align: center; } tr:nth-child(even) {background-color: #f2f2f2;}</style>";

$zawartosc="";

if(UserManager::sprawdzCzyZalogowany($db)===1){
    $sesja = $_COOKIE["PHPSESSID"];
    $userId=UserManager::getLoggedInUser($db,$sesja);

$zawartosc.="        <section class='py-5'> <!--odstep miedzy nagłowkiem, a kontenerem z tekstem-->
<div class='container'>
    <div class='row justify-content-md-center'>
      <div class='col-md-auto'>
        <form>
            <button type='button' onclick='pokazKoszyk($userId)'>Wyświetl zawartość koszyka</button>
            <button type='button' onclick='usunKoszyk($userId)'>Usuń wszystkie produkty</button>
            <br/>
        </form>
      </div>
    <div class='row'>
      <div class='col-md-auto'>
        <div id='koszyk'></div>
        <div id='edycja'></div>
      </div>
    </div>
  </div>

</section>";

}
else{
    $zawartosc.="<center><b><br/>Aby mieć dostęp do koszyka musisz być zalogowany!<br/><a class='nav-item' href='konto.php'>Zaloguj się</a></b><br/></center>";
}




