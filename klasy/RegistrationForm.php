<?php
    class RegistrationForm {
        protected $user;

        function showForm(){ //metoda wyswietlajaca formularz rejestracji
            $zawartosc="<section class='py-5'><div class='container'><div class='row'><div class='col'>
            <center><p>
            <form action='rejestracja.php' method='post'>
            Nazwa użytkownika: <br/><input name='userName' pattern='^[0-9A-Za-ząęłńśćźżó_-]{2,25}$'/><br/>
            Imię i nazwisko: <br/><input name='fullName' pattern='^[a-zA-Z]+[a-zA-Z]+[\pL \'-]+$' /><br/>
            Hasło: <br/><input type='password' name='passwd' pattern='^[A-Za-z0-9]\w{7,}$' /><br/>
            Email: <br/><input name='email' type='email'/><br/>
            <input type='submit' name='submit' value='Rejestruj' />
            <input type='reset' value='Wyczyść' /><br/>
            </form></p></center></div>";
        return $zawartosc; 
        }

       

        function checkUser(&$blad){ //metoda do walidacji formularza
            $args = 
            [
            'userName' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[0-9A-Za-ząęłńśćźżó_-]{2,25}$/']],
            'fullName' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[a-zA-Z]+ [a-zA-Z]+[\pL \'-]+$/']],
            'passwd' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[A-Za-z0-9]\w{7,}$/']],
            'email' => ['filter' => FILTER_VALIDATE_EMAIL]
            ];
            $dane = filter_input_array(INPUT_POST, $args);
            $errors = "";
            foreach ($dane as $key => $val) {
                if ($val === false or $val === NULL) {
                $errors .= $key . " ";
                }
            }
            
            if ($errors === "") {//jesli walidacja pomyslna
                $this->user=new User($dane['userName'],$dane['fullName'],$dane['email'],$dane['passwd']);
            } else {//jesli walidacja nie przeszla pomyslnie, zwracamy komunikat bledu
                $blad = "<p id='blad'>Błędne dane: $errors</p>";
                $this->user = NULL;
            }
            return $this->user;
        }


    }
?>