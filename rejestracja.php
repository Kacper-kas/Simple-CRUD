
<?php

// FORMULARZ REJESTRACYJNY
    include_once("klasy/Baza.php");
    include_once('klasy/User.php');
    include_once('klasy/RegistrationForm.php');
    include_once 'klasy/Strona.php';
    $strona_akt = new Strona(); 
    $rf = new RegistrationForm();
    $tytul="Formularz rejestracji";
    $db = new Baza("localhost", "root", "", "klienci");
    $db2 = mysqli_connect('localhost', 'root', '', 'klienci');
    $blad = ""; //zmienna pomocnicza, ktora bedzie przechowywala blad walidacji formularza
    if(UserManager::sprawdzCzyZalogowany($db)===1){//zabezpieczenie przed tym, zeby zalogowany uzytkownik nie mogl zalozyc nowego konta
        header("location:zalogowany.php");
     }
    $zawartosc = $rf->showForm(); //wyświetla formularz rejestracji

    if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
        $user = $rf->checkUser($blad); //sprawdza poprawność danych
        if ($user === NULL){//walidacja nieprawidlowa
            $zawartosc.= "<p id='blad'>Niepoprawne dane rejestracji.</p>";
            $zawartosc.= $blad;//dolaczenie do komunikatu powyzej informacji o bledzie walidacji

        }
        else {//walidacja prawidlowa
            //sprawdzamy czy dane nie istnieja juz w bazie
            $username = $_POST['userName'];
            $email = $_POST['email'];
            $sql_u = "SELECT * FROM users WHERE userName='$username'";
            $sql_e = "SELECT * FROM users WHERE email='$email'";
            $res_u = mysqli_query($db2, $sql_u);
            $res_e = mysqli_query($db2, $sql_e);
            if (mysqli_num_rows($res_u) > 0) {//jesli zwrocono jakies rekody
                $zawartosc.= "<p id='blad'>Nazwa użytkownika jest już zajęta.</p>";
                }
                    else if(mysqli_num_rows($res_e) > 0){
                        $zawartosc.= "<p id='blad'>Adres email jest już zajęty.</p>";
                    }
                        else{  //jesli danych nie ma w bazie, tworzymy konto          
                            $zawartosc.= "<p id='poprawne'>Rejestracja przebiegła pomyślnie. <a class='nav-item' href='konto.php'>Zaloguj się</a></p>";
                            $user->saveDB($db);//zapisujemy dane do bazy
                        }

        }
    }

    $strona_akt->ustaw_tytul($tytul); 
    $strona_akt->ustaw_zawartosc($zawartosc); 
    $strona_akt->wyswietl();



