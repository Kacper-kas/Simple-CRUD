<?php
//Klasa zawierajaca metody do logowania, edycji danych, sprawdzania roli uzytkownika, wyswietlania danych itp.
include_once "Strona.php";
class UserManager {
    function loginForm() {
        
        $zawartosc="<section class='py-5'><div class='container'><div class='row'><div class='col'>
        <center><h3>Formularz logowania</h3><p>
        <form action='konto.php' method='post'>
        Login: <input type='text' name='login'><br>
        Hasło: <input type='password' name='passwd'><br>
        <input type='submit' value='Zaloguj' name='zaloguj' />
        <input type='reset' value='Anuluj' name='anuluj' />
        </form></p></center></div>";
        return $zawartosc; 
    }

    function login($db) {
        //funkcja sprawdza poprawność logowania
        //wynik - id użytkownika zalogowanego lub -1
        $args = [
        'login' => FILTER_SANITIZE_ADD_SLASHES,
        'passwd' => FILTER_SANITIZE_ADD_SLASHES
        ];
        //przefiltruj dane z GET (lub z POST) zgodnie z ustawionymi w $args filtrami:
        $dane = filter_input_array(INPUT_POST, $args);
        //sprawdź czy użytkownik o loginie istnieje w tabeli users
        //i czy podane hasło jest poprawne
        $login = $dane["login"];
        $passwd = $dane["passwd"];
        $userId = $db->selectUser($login, $passwd, "users");
        if ($userId >= 0) { //Poprawne dane
            //rozpocznij sesję zalogowanego użytkownika
            session_start();
            session_regenerate_id();//ZABEZPIECZENIE PRZED PROWADZENIEM WLASNEGO ID SESJI I PRZECHWYCENIA SESJI ZALOGOWANEGO UZYTKOWNIKA
            //usuń wszystkie wpisy historyczne dla użytkownika o $userId
            $db->delete("DELETE FROM logged_in_users WHERE userId=$userId");

            $date = new DateTime("NOW");
            //pobierz id sesji i dodaj wpis do tabeli logged_in_users"
            $db->insert('INSERT INTO logged_in_users(sessionId,userId,lastUpdate) VALUES ("'.session_id().'","'.$userId.'","'.$date->format('Y-m-d H:i:s').'")');
        }
        return $userId;
    }

    function logout($db) {
        
        //pobierz id bieżącej sesji (pamiętaj o session_start()
        session_start();
        $sessionId = session_id();
        //usuń sesję (łącznie z ciasteczkiem sesyjnym)
        $_SESSION = [];
        session_unset();
        if(isset($_COOKIE[session_name()])){
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
        //usuń wpis z id bieżącej sesji z tabeli logged_in_users
        $db->delete("DELETE FROM logged_in_users WHERE sessionId='$sessionId'");
        
    }

    static function getLoggedInUser($db, $sessionId) {
        $id = -1;
        if ($result = $db->getMysqli()->query("SELECT * FROM logged_in_users WHERE sessionId='$sessionId'")) {
            $ile = $result->num_rows;
                if ($ile == 1) {
                    $row = $result->fetch_object();
                    $id = $row->userId; 
                }
        }
        $result->close();
        return $id;
        //wynik $userId - znaleziono wpis z id sesji w tabeli logged_in_users
        //wynik -1 - nie ma wpisu dla tego id sesji w tabeli logged_in_users
    }
    static function getLoggedInFullName($db, $id) {
        if ($result = $db->getMysqli()->query("SELECT fullName FROM users WHERE id='$id'")) {
            $ile = $result->num_rows;
                if ($ile == 1) {
                    $row = $result->fetch_object();
                    $fullName = $row->fullName; 
                }
        }
        $result->close();
        return $fullName;

    }

    function isAdmin($db,$userId) {//sprawdzenie czy zalogowany uzytkownik to administrator
        
        if ($result = $db->getMysqli()->query("SELECT * FROM users WHERE status='2' AND id='$userId'")) {
            $ile = $result->num_rows;
                if ($ile == 1) {
                    return 1;//zwracamy 1 jesli jest administratorem
                }
                else
                return 0;
        }
        
    }


    static function sprawdzCzyZalogowany($db) { 
        

        if(isset($_COOKIE[session_name()])){
            $sesja = $_COOKIE["PHPSESSID"];
            if ($result = $db->getMysqli()->query("SELECT * FROM logged_in_users WHERE sessionId='$sesja'")) {
                $ile = $result->num_rows;
                    if ($ile == 1) {
                        $result->close();
                        return 1;//zwracamy 1 jesli zalogowany
                    }
                    else{
                        $result->close();
                        return 0;//w przeciwnym wypadku 0
                    }
            }

        }

    } 
    //wyswietlenie formularza edycji danych
    function showEditForm(){ 
        $zawartosc="
        <center><p>
        <form action='edytuj.php' method='post'>
        Wprowadź obecne hasło: <br/><input type='password' name='old_passwd' pattern='^[A-Za-z0-9]\w{7,}$' /><br/>
        Wprowadź nowe hasło: <br/><input type='password' name='passwd' pattern='^[A-Za-z0-9]\w{7,}$' /><br/>
        <input type='submit' name='submit' value='Zmień' />
        <input type='reset' value='Wyczyść' /><br/>
        </form></p></center></div>";
    return $zawartosc; 
    }

   
    //walidacja formularza edycji danych
    function checkEditForm($db, $userId){ 

        $args = 
        [
        'passwd' => ['filter' => FILTER_VALIDATE_REGEXP,
            'options' => ['regexp' => '/^[A-Za-z0-9]\w{7,}$/']],
        'old_passwd' => ['filter' => FILTER_VALIDATE_REGEXP,
            'options' => ['regexp' => '/^[A-Za-z0-9]\w{7,}$/']]
        ];
        $dane = filter_input_array(INPUT_POST, $args);
        $errors = "";
        foreach ($dane as $key => $val) {
            if ($val === false or $val === NULL) {
            $errors .= $key . " ";
            }
        }
        
        if ($errors === "") {//jesli walidacja pomyslna
            //sprawdzamy w bazie czy obecne haslo wprowadzone do formularza zgadza sie z tym z bazy danych
            $passwd = $dane['old_passwd'];
            $newPasswd = password_hash($dane['passwd'],PASSWORD_DEFAULT);
            $sql = "SELECT * FROM users WHERE id=$userId";
            if ($result = $db->getMysqli()->query($sql)) {
                $ile = $result->num_rows;
                if ($ile == 1) {
                    $row = $result->fetch_object();
                    $hash = $row->passwd;
                    if (password_verify($passwd, $hash)) {
                        $sql = "UPDATE users SET passwd='$newPasswd' WHERE id=$userId";
                        if ($db->getMysqli()->query($sql)) {
                            return "<p id='poprawne'>Haslo zostało zmienione</p>";
                        } else {
                            return "<p id='blad'>Wystapil problem ze zmiana hasla</p>";
                        }
                    }else
                        return "<p id='blad'>Obecne hasło nie jest zgodne!</p>";
                    
                }
            }else
                return "<p id='blad'>Wystapil problem ze zmiana hasla</p>";
            $result->close();
    }
    else {
        return "<p id='blad'>Błędne dane: $errors</p>";
    }

}
}
?>