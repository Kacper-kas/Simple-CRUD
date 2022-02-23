<?php 
//Klasa odpowiedzialna za zawartosc strony
include_once "klasy/User.php";
include_once "klasy/Baza.php";
include_once 'klasy/userManager.php';


class Strona { 
    
    protected $zawartosc; 
    protected $tytul = ""; 
    protected $slowa_kluczowe = "php, strona"; 
    protected $przyciski = array(
         "Strona główna" => "index.php?strona=index", 
        "Historia" => "index.php?strona=historia", 
        "Rodzaje" => "index.php?strona=rodzaje", 
          "Zastosowania"=>"index.php?strona=zastosowania",
          "Kontakt"=>"index.php?strona=kontakt"
        ); 
    //interfejs klasy – metody modyfikujące fragmenty strony 
    public function ustaw_zawartosc($nowa_zawartosc) { 
        $this->zawartosc = $nowa_zawartosc; 
    }function ustaw_tytul($nowy_tytul) { 
        $this->tytul = $nowy_tytul; 
    } 
    public function ustaw_slowa_kluczowe($nowe_slowa) { 
        $this->slowa_kluczowe = $nowe_slowa; 
    } 
    public function ustaw_przyciski($nowe_przyciski) { 
        $this->przyciski = $nowe_przyciski; 
    } 
    public function ustaw_style($url) { 
        echo '<link rel="stylesheet" href="' . $url . '" type="text/css"  />'; 
    } 
 
    //interfejs klasy – funkcje wyświetlające stronę 
    public function wyswietl() { 
        $this->wyswietl_naglowek(); 
        $this->wyswietl_zawartosc(); 
 
    } 
    public function wyswietl_tytul() { 
        echo "<title>$this->tytul</title>"; 
    } 
    public function wyswietl_slowa_kluczowe() { 
        echo "<meta name=\"keywords\" contents=\"$this-
>slowa_kluczowe\">"; 
    } 


    
    public function wyswietl_menu() { 

        echo"<header class='bg-dark py-1'>
            <div class='container px-4 px-lg-5 my-5'>
                <div class='text-center text-white'>
                    <h1 class='display-4 fw-bolder'>$this->tytul</h1><!--Tytuł główny-->
                    
                </div>
            </div>
        </header>";
        
        

    } 

    /*WYSWIETLANIE MENU NAWIGACYJNEGO*/
    public function wyswietl_naglowek() { 
        ?>   
        <!DOCTYPE html>
        <html lang="pl">
            <head>
                <meta charset="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
                <!-- Bootstrap icons-->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
                <!-- Core theme JS-->
                <script src="js/scripts.js"></script>
            </head>
            <body>
                <!-- Menu nawigacyjne-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container px-4 px-lg-5">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                                <?php
                                        //HIPERLACZA W MENU
                                        foreach($this->przyciski as $nazwa => $url){     
                                            echo '<li class="nav-item"><a class="nav-link" href="'. $url .'">' . $nazwa . '</a></li>';
                                        } 
                                        ?>
                                <!--przycisk sklep-->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sklep</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="index.php?strona=drukarki">Drukarki 3D</a></li>
                                        <li><a class="dropdown-item" href="index.php?strona=filament">Filament</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <!--Przycisk koszyk-->

                            <form class="d-flex">
                                <button class="btn btn-outline-dark" type="submit">
                                    <i class="bi-cart-fill me-1"></i>
                                    <a class="nav-item" href="index.php?strona=koszyk">Twój koszyk</a> <!--Hiperlacze do koszyka-->
                                    <span id="licznik" class="badge bg-dark text-white ms-1 rounded-pill">0</span><!--Licznik elementow w koszyku-->
                                </button>
                            </form>
                            <!--Hiperlacze do konta-->
                            <form class="d-flex">
                                <button class="btn btn-outline-dark" type="submit">
                                    <i class="bi-people-fill"></i>
                                    <span id="uzytkownik"><a class="nav-item" href="konto.php">Konto</a></span>
                                    
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>
                 <?php 
                   
                    $this->ustaw_style('css/styles.css'); 
                    $this->ustaw_style('css/styl.css'); 
                    echo "<title>".$this->tytul."</title></head><body>"; 
                    
                
    } 



    public function wyswietl_zawartosc() { 

        $this->wyswietl_menu(); 
        echo "</div></div>"; 
        echo "<div id='main'>"; 
        echo $this->zawartosc . "</div>"; 


        //LICZNIK ILOSCI ELEMENTOW W KOSZYKU 
        if(isset($_COOKIE[session_name()])){
            $db = new Baza('localhost', 'root','','klienci');
            $sesja = $_COOKIE["PHPSESSID"];
            $userId=UserManager::getLoggedInUser($db,$sesja);
            User::updateBasketCount($db, $userId);
        } 


    
    } 





}