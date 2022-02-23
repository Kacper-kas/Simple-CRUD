/*.addEventListener('DOMContentLoaded', () => {
    var bWylogujNieaktywnych = document.getElementById('wylogujNieaktywnych');
    bWylogujNieaktywnych.addEventListener("click", () => {
    //wylogujNieaktywnych();
    console.log("dzialam!");
    });

   });*/


function dodajElement(przedmiot,userId) {
    const formData = new FormData();
    formData.append("userId", userId); //USERID ODCZYTYWANY Z SESSION
    formData.append("nazwa", document.getElementById('nazwa'+przedmiot).innerHTML);
    formData.append("cena", document.getElementById('cena'+przedmiot).innerHTML);
    formData.append("kolor", document.getElementById('kolor'+przedmiot).innerHTML);
    formData.append("ilosc", 1);
    formData.append("itemId", przedmiot);
   
    fetch("ajax/dodajElement.php", {
    method: "post",
    body: formData
    })
    .then( response => response.text())
    .then(response => {

    //wyciecie z response skryptu js do zmiany ilosc elementow w koszyku
    var indexStart = response.indexOf("<script>document.getElementById('licznik').innerHTML = ")+55;//bazujemy na dlugosci stringa
    var indexEnd = response.indexOf("</script>" , indexStart);

    document.getElementById('licznik').innerHTML =  response.substring(indexStart,indexEnd);//"wyluskana" wartosc liczbowa

    document.getElementById('odpowiedz').innerHTML = response + "Produkt: "+document.getElementById('nazwa'+przedmiot).innerHTML;
    });
   }

   function pokazKoszyk(userId) {
    const formData = new FormData();
    formData.append("userId", userId);//przesylamy userId uzytkownika zeby wyswietlic koszyk dla zalogowanego usera
    fetch("ajax/pokazKoszyk.php", {
        method: "post",
        body: formData
        })
    .then((response) => {
    if (response.status !== 200) {
    return Promise.reject('Coś poszło nie tak!');
    }
    return response.text();
    })
    .then((response) => {
    document.getElementById('koszyk').innerHTML = response;
    })
    .catch((error) => {
    console.log(error);
    });
}

function usunElement(przedmiot,userId) {
    const formData = new FormData();
    formData.append("userId", userId);
    formData.append("przedmiot", przedmiot);
    fetch("ajax/usunElement.php", {
        method: "post",
        body: formData
        })
    .then((response) => {
    if (response.status !== 200) {
    return Promise.reject('Coś poszło nie tak!');
    }
    return response.text();
    })
    .then((response) => {
    document.getElementById('koszyk').innerHTML = response;
    var indexStart = response.indexOf("<script>document.getElementById('licznik').innerHTML = ")+55;//bazujemy na dlugosci stringa
    var indexEnd = response.indexOf("</script>" , indexStart);

    document.getElementById('licznik').innerHTML =  response.substring(indexStart,indexEnd);
    })
    .catch((error) => {
    console.log(error);
    });
}

function usunKoszyk(userId) {
    const formData = new FormData();
    formData.append("userId", userId);//przesylamy userId uzytkownika zeby wyswietlic koszyk dla zalogowanego usera
    fetch("ajax/usunWszystko.php", {
        method: "post",
        body: formData
        })
    .then((response) => {
    if (response.status !== 200) {
    return Promise.reject('Coś poszło nie tak!');
    }
    return response.text();
    })
    .then((response) => {
    document.getElementById('koszyk').innerHTML = response;
    document.getElementById('licznik').innerHTML = 0;
    })
    .catch((error) => {
    console.log(error);
    });
}

function wylogujNieaktywnych(userId) {
    const formData = new FormData();
    formData.append("userId", userId);//przesylamy userId uzytkownika zeby nie wylogowac aktywnie zalogowanego uzytkownika
    fetch("ajax/wylogujNieaktywnych.php", {
        method: "post",
        body: formData
        })
    .then((response) => {
    if (response.status !== 200) {
    return Promise.reject('Coś poszło nie tak!');
    }
    return response.text();
    })
    .then((response) => {
    document.getElementById('odpowiedz').innerHTML = response;
    })
    .catch((error) => {
    console.log(error);
    });
}



var rozsuniete = 0; //ZMIENNA GLOBALNA NA POTRZEBY OBSLUGI SPA(SINGLE PAGE APPLICATION)

function edycjaDanych() {

    if(rozsuniete==0){//jesli menu nie jest rozwiniete to wypelnij zawartoscia
        zawartosc="$um->showEditForm();"
        zawartosc= zawartosc + "if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {$um->checkEditForm();} ";
        document.getElementById('blok').innerHTML = zawartosc;
        rozsuniete = 1;
    }
    else{//w przeciwnym wypadku "schowaj" zawartość
        zawartosc="";
        document.getElementById('blok').innerHTML = zawartosc;
        rozsuniete = 0;

    }
    

}

function zastosowania() {

    if(rozsuniete==0){//jesli menu nie jest rozwiniete to wypelnij zawartoscia
        zawartosc='<br/><center><img src="https://www.komputronik.pl/informacje/wp-content/uploads/2019/01/jak-dziala-drukarka-3d.jpg" width="400" height="300"></center><br/></div><div class="col">Do najbardziej spektakularnych projektów z drukarek 3D należą te wykorzystane w medycynie. Mogą one bowiem z powodzeniem zastąpić niektóre struktury (np. kości), które uległy zniszczeniu, uszkodzeniu lub też w ogóle nie wykształciły się podczas rozwoju danego organizmu. W 2015 roku lekarze z Poznania wszczepili pacjentowi znaczną część kości miednicy – własne tkanki pacjenta uszkodzone zostały przez nowotwór. Była to wówczas jedna z największych tego typu operacji na świecie.</div>'
        document.getElementById('blok').innerHTML = zawartosc;
        rozsuniete = 1;
    }
    else{//w przeciwnym wypadku "schowaj" zawartość
        zawartosc="";
        document.getElementById('blok').innerHTML = zawartosc;
        rozsuniete = 0;

    }
    

}

//POZOSTALE FUNKCJE 
/*WALIDACJA FORMULARZA NA POTRZEBY PODSTRONY KONTAKT*/
function sprawdzPole(pole_id, obiektRegex) {
    //Funkcja sprawdza czy wartość wprowadzona do pola tekstowego
    //pasuje do wzorca zdefiniowanego za pomocą wyrażenia regularnego
    //Parametry funkcji:
    //pole_id - id sprawdzanego pola tekstowego
    //obiektRegex - wyrażenie regularne
    //---------------------------------
    var obiektPole = document.getElementById(pole_id);
    if (!obiektRegex.test(obiektPole.value)) return (false);
    else return (true);
}
function sprawdz_radio(nazwa_radio) {
    //Funkcja sprawdza czy wybrano przycisk radio
    //z grupy przycisków o nazwie nazwa_radio
    //---------------------------------------
    var obiekt = document.getElementsByName(nazwa_radio);
    for (i = 0; i < obiekt.length; i++) {
        wybrany = obiekt[i].checked;
        if (wybrany) return true;
    }
    return false;
}
function sprawdz_box(box_id) {//Funkcja sprawdza czy przycisk typu checkbox
    //o identyfikatorze box_id jest zaznaczony
    //----------------------------------------
    var obiekt = document.getElementById(box_id);
    if (obiekt.checked) return true;
    else return false;
}
function sprawdz() { //Funkcja realizujaca sprawdzanie całego fomularza
    //wykorzystując funkcje pomocnicze
    //--------------------------------
    var ok = true; //zmienna informująca o poprawnym wypełnieniu formularza
    //Definicje odpowiednich wyrażeń regularnych dla sprawdzenia
    //poprawności danych wprowadzonych do pól tekstowych
    obiektNazw = /^[a-zA-Z]{2,20}$/; //wyrażenie regularne dla nazwiska
    obiektemail = /^([a-zA-Z0-9])+([.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-]+)+/;
    obiektIlosc = /^[1-9]{1,1}$/;
    obiektImie = /^[a-zA-Z]{2,20}$/;
    //Sprawdzanie kolejnych pól formularza.
    //w przypadku błędu - pojawia się odpowiedni komunikat
    if (!sprawdzPole("nazw", obiektNazw)) { //Sprawdzenie pola nazwisko
        ok = false;
        document.getElementById("nazw_error").innerHTML = "Wpisz poprawnie nazwisko!"; //Jesli niepoprawne nazwisko - wyswietl obok tekst
    }
    else document.getElementById("nazw_error").innerHTML = ""; //Jesli poprawne nazwisko - brak komunikatu

    if (!sprawdzPole("email", obiektemail)) {//Sprawdzenie pola email
        ok = false;
        document.getElementById("email_error").innerHTML = "Wpisz poprawnie email!"; //Jesli niepoprawny mail - wyswietl obok tekst
    }
    else document.getElementById("email_error").innerHTML = ""; //Jesli poprawny email - brak komunikatu

    if (!sprawdzPole("ilosc", obiektIlosc)) {//Sprawdzenie pola ilosc
        ok = false;
        document.getElementById("ilosc_error").innerHTML = "Wpisz poprawną ilość!"; //Jesli niepoprawna ilosc - wyswietl obok tekst
    }
    else document.getElementById("ilosc_error").innerHTML = ""; //Jesli poprawna ilosc- brak komunikatu

    if (!sprawdzPole("imie", obiektImie)) {//Sprawdzenie pola imie
        ok = false;
        document.getElementById("imie_error").innerHTML = "Wpisz poprawne imię!"; //Jesli niepoprawne imie - wyswietl obok tekst
    }
    else document.getElementById("imie_error").innerHTML = ""; //Jesli poprawne imie - brak komunikatu

    if (!sprawdz_box("drukarka1") && !sprawdz_box("drukarka2") && !sprawdz_box("drukarka3")) { //Sprawdzenie czy zostalo wybrane jakiekolwiek pole
        ok = false;
        document.getElementById("produkt_error").innerHTML = "Nie wybrano żadnej drukarki!"; //Jesli nie wybrano zadnego pola
    }
    else document.getElementById("produkt_error").innerHTML = ""; //Jesli wybrano jakiekolwiek pole - brak komunikatu



    if (ok) { //wyswietlenie podanych danych tylko pod warunkiem poprawnie wypelnionego formularza
        var tab_checkbox = document.querySelectorAll('input[name=drukarka]:checked'); //"odczytanie" pol checkbox, ktore sa zaznaczone
        var checkbox = ""; //aby ten kod zadzialal, zostala wprowadzona zmiana w kodzie html
        for (let i = 0; i < tab_checkbox.length; i++) {
            if (tab_checkbox[i].checked)
                checkbox += " " + tab_checkbox[i].value; //polaczenie zawartosci pol zaznaczonych checkboxow w jedna zmienna
        }

        var tab_radio = document.getElementsByName("zaplata"); //"odczytanie" wybranego pola radio
        var radio;
        for (let i = 0; i < tab_radio.length; i++) {
            if (tab_radio[i].checked)
                radio = tab_radio[i].value; //zapis wartosci pola radio do zmiennej
        }

        //Wyswietlenie komunikatu z podanymi w formularzu danymi
        var dane = "Następujące dane zostaną wysłane:\n";
        dane += "Email: " + document.getElementById('email').value + "\n" +
            "Nazwisko: " + document.getElementById('nazw').value + "\n" +
            "Imie: " + document.getElementById('imie').value + "\n" +
            "Ilosc: " + document.getElementById('ilosc').value + "\n" +
            "Zamawiam jako: " + document.getElementById('pyt').value + "\n" +
            "Wybrane produkty: " + checkbox + "\n" +
            "Sposob zaplaty: " + radio + "\n";
        window.confirm(dane); //wywolanie okienka z komunikatem
    }
    else {//jesli dane w formularzu sa niepoprawne - wyswietl komunikat
        var dane = "Popraw bledy w formularzu!";
        window.confirm(dane); //wywolanie okienka z komunikatem
    }

    return ok;
}

