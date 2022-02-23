<?php 
//Podstrona - formularz logowania. Uzytkownik jest tutaj takze przekierowywany gdy wyloguje sie
include_once 'klasy/Baza.php';
include_once 'klasy/User.php';
include_once 'klasy/userManager.php';
include_once 'klasy/Strona.php';
$strona_akt = new Strona(); 
$tytul="Twoje konto"; 
$zawartosc="";
$db = new Baza("localhost", "root", "", "klienci");
$um = new UserManager();
//parametr z GET – akcja = wyloguj
if (filter_input(INPUT_GET, "akcja")=="wyloguj") {
   $um->logout($db);
   $zawartosc.="<center><h4 id='poprawne'>Użytkownik został wylogowany.</h4></center>";
}
//jesli kliknięto przycisk zaloguj
if (filter_input(INPUT_POST, "zaloguj")) {
  $userId=$um->login($db); //sprawdź parametry logowania
  if ($userId > 0) {//jesli uzytkownik poprawnie zalogowany
     header("location:zalogowany.php");
   } else {//w przeciwnym wypadku wyswietlamy odpowiedni komunikat
        $zawartosc.="<h4 id='blad'><center>Błędna nazwa użytkownika lub hasło</h4></center>";
       $zawartosc.=$um->loginForm(); //Pokaż formularz logowania
       
   }
} else {
   //wyswietlenie formularza logowania po raz pierwszy
   if(UserManager::sprawdzCzyZalogowany($db)===1){//dodatkowa weryfikacja czy zalogowany uzytkownik nie probuje ponownie sie zalogowac
      header("location:zalogowany.php");
   }
   else{
   $zawartosc.=$um->loginForm();//wyswietlenie formularza
   $zawartosc.=" <center>Nie masz konta? <a class='nav-item' href='rejestracja.php'>Załóż konto</a></center>";
   }

}
//wywolanie metod do wyswietlania strony
$strona_akt->ustaw_tytul($tytul); 
$strona_akt->ustaw_zawartosc($zawartosc); 
$strona_akt->wyswietl(); 




