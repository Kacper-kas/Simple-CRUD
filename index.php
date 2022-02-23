<?php 
 
require_once("klasy/Strona.php"); 
$strona_akt = new Strona(); 
 
//sprawdź co wybrał użytkownik: 
if (filter_input(INPUT_GET, 'strona')) { 
    $strona = filter_input(INPUT_GET, 'strona'); 
    switch ($strona) { 
        case 'historia':
            $strona = 'historia'; 
            break; 
        case 'formularz':
            $strona = 'formularz'; 
            break; 
        case 'zastosowania':
            $strona = 'zastosowania'; 
            break; 
        case 'rodzaje':
            $strona = 'rodzaje'; 
            break; 
        case 'kontakt':
            $strona = 'kontakt'; 
            break;
        case 'filament':
            $strona = 'filament'; 
            break;
        case 'konto':
            $strona = 'konto'; 
            break;
        case 'drukarki':
            $strona = 'drukarki'; 
            break;
        case 'koszyk':
            $strona = 'koszyk'; 
            break;
        default:
            $strona = 'glowna'; 
    } 
} else { //jesli w żądaniu GET otrzymano cokolwiek innego, przekierowujemy na stronę główną
    $strona = "glowna"; 
} 
 
//dołącz wybrany plik z ustawioną zmienną $tytul i $zawartosc  
$plik = "strony/" . $strona . ".php"; 
if (file_exists($plik)) { 
    require_once($plik); 
    //wywolanie odpowiednich metod do wyswietlenia zawartosci strony
    $strona_akt->ustaw_tytul($tytul); 
    $strona_akt->ustaw_zawartosc($zawartosc); 
    $strona_akt->wyswietl(); 
}