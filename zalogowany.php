<?php
//STRONA DOSTEPNA DLA UZYTKOWNIKA PO ZALOGOWANIU
 session_start();
 include_once 'klasy/Baza.php';
 include_once 'klasy/User.php';
 include_once 'klasy/userManager.php';
 
$strona_akt = new Strona(); 
$tytul="Panel użytkownika"; 
$zawartosc="<center>";
 $db = new Baza("localhost", "root", "", "klienci");
 $um = new UserManager();
 //Zmienne pomocnicze
 $adm = 3;
 $userId=UserManager::getLoggedInUser($db,session_id()); 
 $fullName = UserManager::getLoggedInFullName($db, $userId);
 $adm = $um->isAdmin($db, $userId);//sprawdzenie czy uzytkownik jest administratorem

   if ($userId > 0) {//jesli uzytkownik zalogowany
      $zawartosc.= "<br/><h4>Witaj $fullName</h4>";
      $zawartosc.="Twoj numer ID użytkownika to: $userId <br />";

      if($adm === 1){//jesli uzytkownik jest administratorem
        $zawartosc.= "<br/><b>Witaj administratorze</b><br /><br/><b> Ilosc zarejestrowanych użytkowników: </b>";
        $zawartosc.= User::countRegisteredUsers($db);
        $zawartosc.= "<br/><b>Ilosc zalogowanych użytkowników:</b> ";
        $zawartosc.= User::countLoggedUsers($db);
        $zawartosc.="<br/><button type='button' onclick='wylogujNieaktywnych($userId)'>Wyloguj nieaktywnych użytkowników</button>";
        $zawartosc.="<div id='odpowiedz'></div>";

        
      }
      //Ta czesc wyswietlana jest niezaleznie od roli uzytkownika.
      $zawartosc.="<br/><br/><b>Twoje dane:</b> <br/><br/>";
      $zawartosc.=$db->wyswietlUzytkownika("select userName, fullName, email from users where id = $userId", ["userName","fullName","email"]);
      $zawartosc.="<br/><button name = 'przycisk'><a href=edytuj.php>Zmień hasło</a></button><div id='blok' class='col'></div></section>";
    } else {//jesli uzytkownik niezalogowany probuje recznie dostac do tej podstrony
        header("location:konto.php");
    }

    //Zmiana nazwy przycisku(hiperlacza) z konto na wyloguj przy uzyciu JS.
    if(UserManager::sprawdzCzyZalogowany($db) === 1){
      $zawartosc.="<script>document.getElementById('uzytkownik').innerHTML = ";
      $zawartosc.='"<a href=konto.php?akcja=wyloguj>Wyloguj"</script>';
    }
    
    $strona_akt->ustaw_tytul($tytul); 
    $strona_akt->ustaw_zawartosc($zawartosc); 
    $strona_akt->wyswietl(); 
 ?>
