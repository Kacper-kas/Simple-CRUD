<?php
//Podstrona na której uzytkownik moze edytowac swoje dane
 session_start();
 include_once 'klasy/Baza.php';
 include_once 'klasy/User.php';
 include_once 'klasy/userManager.php';
 
 $strona_akt = new Strona(); 
 $tytul="Edycja danych"; 
 $zawartosc="<center>";
 $db = new Baza("localhost", "root", "", "klienci");
 $um = new UserManager();
 $userId=UserManager::getLoggedInUser($db,session_id()); 
   if ($userId > 0) {//jesli uzytkownik zalogowany
      //wyswietl dane uzytkownika
      $zawartosc.="<br/><br/><b>Dane zalogowanego uzytkownika:</b> <br/><br/>";
      $zawartosc.=$db->wyswietlUzytkownika("select userName, fullName, email from users where id = $userId", ["userName","fullName","email"]);
      //wyswietl formularz edycji danych
      $zawartosc.=$um->showEditForm();
      if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
        //po nacisnieciu przycisku zmien, zwaliduj formularz
        $zawartosc.=$um->checkEditForm($db,$userId);
      }
    } else {//jesli uzytkownik niezalogowany
        header("location:konto.php");
    }

    if(UserManager::sprawdzCzyZalogowany($db) === 1){
      $zawartosc.="<script>document.getElementById('uzytkownik').innerHTML = ";
      $zawartosc.='"<a href=konto.php?akcja=wyloguj>Wyloguj"</script>';
    }
    $strona_akt->ustaw_tytul($tytul); 
    $strona_akt->ustaw_zawartosc($zawartosc); 
    $strona_akt->wyswietl(); 
 ?>
