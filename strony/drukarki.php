<?php 
include_once 'klasy/userManager.php';
include_once 'klasy/Baza.php';
$db = new Baza('localhost', 'root','','klienci');
$tytul="Wybierz model dla siebie"; 
$zawartosc="<section class='py-5'><div><p id='odpowiedz'></p><div class='container px-4 px-lg-5 mt-5'><div class='row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center'>";

if(UserManager::sprawdzCzyZalogowany($db)===1){
    $sesja = $_COOKIE["PHPSESSID"];
    $userId=UserManager::getLoggedInUser($db,$sesja);


$zawartosc.="                    <div class='col mb-5'>
<div class='card h-100'>
    <!-- Zdjecie produktu-->
    <img class='card-img-top' src='zdjecia/drukarka1.jpg' alt='Drukarka1' />
    <!-- Szczegoly produktu-->
    <div class='card-body p-4'>
        <div class='text-center'>
            <!-- Nazwa produktu-->
            <h5 id='nazwa1' class='fw-bolder'>Drukarka nr 1</h5>
            <!-- Cena-->
            <div id='cena1'>1500</div>
            <div id='kolor1'>czarny</div>
        </div>
    </div>
    <!-- Akcja do wykonania na produkcie-->
    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
        <div class='text-center'><button type='button' id='przycisk' onclick='dodajElement(1,$userId)'>Dodaj do koszyka</button></div>
    </div>
</div>
</div>

<div class='col mb-5'>
<div class='card h-100'>
    <!-- Znaczek wyprzedaz-->
    <div class='badge bg-dark text-white position-absolute' style='top: 0.5rem; right: 0.5rem'>Wyprzedaż</div>
    <!-- Zdjecie produktu-->
    <img class='card-img-top' src='zdjecia/drukarka2.jpg' alt='Drukarka2' />
    <!-- Szczegoly produktu-->
    <div class='card-body p-4'>
        <div class='text-center'>
            <!-- Nazwa produktu-->
            <h5 id='nazwa2' class='fw-bolder'>Drukarka nr 2</h5>
            <!-- Product reviews-->
            <div class='d-flex justify-content-center small text-warning mb-2'>
                <div class='bi-star-fill'></div>
                <div class='bi-star-fill'></div>
                <div class='bi-star-fill'></div>
                <div class='bi-star-fill'></div>
                <div class='bi-star-fill'></div>
            </div>
            <!-- Cena-->
            <span class='text-muted text-decoration-line-through'>3000 zł</span>
            <div id='cena2'>2500</div>
            <div id='kolor2'>czarno-biały</div>
        </div>
    </div>
    <!-- Akcja do wykonania na produkcie-->
    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
        <div class='text-center'><button type='button' id='przycisk' onclick='dodajElement(2,$userId)'>Dodaj do koszyka</button></div>
    </div>
</div>
</div>
 <div class='col mb-5'>
<div class='card h-100'>
    <!-- Znaczek wyprzedaz-->
    <div class='badge bg-dark text-white position-absolute' style='top: 0.5rem; right: 0.5rem'>Wyprzedaż</div>
    <!-- Zdjecie produktu-->
    <img class='card-img-top' src='zdjecia/drukarka3.jpg' alt='Drukarka3' />
    <!-- Szczegoly produktu-->
    <div class='card-body p-4'>
        <div class='text-center'>
            <!-- Nazwa produktu-->
            <h5 id='nazwa3' class='fw-bolder'>Drukarka nr 3</h5>
            <!-- Cena-->
            <span class='text-muted text-decoration-line-through'>2000 zł</span>
            <div id='cena3'>1000</div>
            <div id='kolor3'>czarny</div>
        </div>
    </div>
    <!-- Akcja do wykonania na produkcie-->
    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
        <div class='text-center'><button type='button' id='przycisk' onclick='dodajElement(3, $userId)'>Dodaj do koszyka</button></div>
    </div>
</div>
</div>
<div class='col mb-5'>
<div class='card h-100'>
    <!-- Zdjecie produktu-->
    <img class='card-img-top' src='zdjecia/drukarka4.jpg' alt='Drukarka4' />
    <!-- Szczegoly produktu-->
    <div class='card-body p-4'>
        <div class='text-center'>
            <!-- Nazwa produktu-->
            <h5 id='nazwa4' class='fw-bolder'>Drukarka nr 4</h5>
            <!-- Product reviews-->
            <div class='d-flex justify-content-center small text-warning mb-2'>
                <div class='bi-star-fill'></div>
                <div class='bi-star-fill'></div>
                <div class='bi-star-fill'></div>
                <div class='bi-star-fill'></div>
                <div class='bi-star-fill'></div>
            </div>
            <!-- Cena-->
            <div id='cena4'>5000</div>
            <div id='kolor4'>zielony</div>
        </div>
    </div>
    <!-- Akcja do wykonania na produkcie-->
    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
        <div class='text-center'><button type='button' id='przycisk' onclick='dodajElement(4, $userId)'>Dodaj do koszyka</button></div>
    </div>
</div>
</div>
<div class='col mb-5'>
<div class='card h-100'>
    <!-- Znaczek wyprzedaz-->
    <div class='badge bg-dark text-white position-absolute' style='top: 0.5rem; right: 0.5rem'>Wyprzedaż</div>
    <!-- Zdjecie produktu-->
    <img class='card-img-top' src='zdjecia/drukarka5.jpg' alt='Drukarka5' />
    <!-- Szczegoly produktu-->
    <div class='card-body p-4'>
        <div class='text-center'>
            <!-- Nazwa produktu-->
            <h5 id='nazwa5' class='fw-bolder'>Drukarka nr 5</h5>
            <!-- Cena-->
            <span class='text-muted text-decoration-line-through'>10000 zł</span>
            <div id='cena5'>8000</div>
            <div id='kolor5'>czarny</div>
        </div>
    </div>
    <!-- Akcja do wykonania na produkcie-->
    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
        <div class='text-center'><button type='button' id='przycisk' onclick='dodajElement(5, $userId)'>Dodaj do koszyka</button></div>
    </div>
</div>
</div>                  <div class='col mb-5'>
<div class='card h-100'>
    <!-- Zdjecie produktu-->
    <img class='card-img-top' src='zdjecia/drukarka6.jpg' alt='Drukarka nr 6' />
    <!-- Szczegoly produktu-->
    <div class='card-body p-4'>
        <div class='text-center'>
            <!-- Nazwa produktu-->
            <h5 id='nazwa6' class='fw-bolder'>Drukarka nr 6</h5>
            <!-- Cena-->
            <div id='cena6'>4000</div>
            <div id='kolor6'>czerwony</div>
        </div>
    </div>
    <!-- Akcja do wykonania na produkcie-->
    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
        <div class='text-center'><button type='button' id='przycisk' onclick='dodajElement(6, $userId)'>Dodaj do koszyka</button></div>
    </div>
</div>
</div>";

}
else{
    $zawartosc.="<center><b>Aby mieć dostęp do oferty drukarek 3D musisz być zalogowany!<br/><a class='nav-item' href='konto.php'>Zaloguj się</a></b><br/></center>";
}

$zawartosc.="</div></div></section>";

