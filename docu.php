<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class=" navbar-collapse justify-content-md-center" id="navbarsExample08">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./menupage.php">Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./index.php">Buttons</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./editpage.php">Edit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./docu.php">Documentation</a>
            </li>
        </ul>
    </div>
    <div class="navbar-collapse justify-content-md-center" id="navbarsExample08">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./menuday.php?day=1">Monday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./menuday.php?day=2">Tuesday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./menuday.php?day=3">Wednesday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./menuday.php?day=4">Thursday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./menuday.php?day=5">Friday</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <h1 class="text-white">Dokumentácia</h1>
    <div class="bg-dark text-white">
        <h2 class="text-white">GET</h2>
        <p>Zavolaním stránky - https://site179.webte.fei.stuba.sk/zadanie2r/menu.php pomocou metódy GET dostaneme všetky jedlá za celý týždeň</p>
    </div>
    <div class="bg-dark text-white">
        <h2 class="text-white">GET</h2>
        <p>Zavolaním stránky - https://site179.webte.fei.stuba.sk/zadanie2r/getmenuday.php?day="číslo dňa 1-5" pomocou metódy GET dostaneme všetky jedlá na konkrétny deň</p>
    </div>
    <div class="bg-dark text-white">
        <h2 class="text-white">PUT</h2>
        <p>Zavolaním stránky - https://site179.webte.fei.stuba.sk/zadanie2r/updatefood.php?foodID=ID&newPrice=PRICE pomocou metódy PUT upravíme cenu jedla konkrétneho ID</p>
    </div>
    <div class="bg-dark text-white">
        <h2 class="text-white">DELETE</h2>
        <p>Zavolaním stránky - https://site179.webte.fei.stuba.sk/zadanie2r/deletemenu.php?restaurantId?ID pomocou metódy DELETE odstránime všetky záznamy o danej reštaurácii</p>
    </div>
    <div class="bg-dark text-white">
        <h2 class="text-white">POST</h2>
        <p>Zavolaním stránky - https://site179.webte.fei.stuba.sk/zadanie2r/addmenu.php?dishName=NAZOV&restaurantId=ID&price=CENA pomocou metódy POST pridáme nový záznam do databázy</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tabulator/4.9.3/js/tabulator.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</body>
</html>