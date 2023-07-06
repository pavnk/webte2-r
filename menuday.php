<!DOCTYPE html>
<html>
<head>

    <title>Menu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
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
<br>
<div class="container mt-5">
<div id="menu"></div>
</div>
<script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const day = urlParams.get('day');

        $.get('getmenuday.php', { day: day }, function(data) {
            let menuHtml = '';
            data.forEach(function(dish) {
                if (dish.price !== null && dish.price !== "null") {
                    menuHtml += '<div class="card mb-3 bg-dark text-light">';
                    menuHtml += '<div class="card-body">';
                    menuHtml += '<h3 class="card-title">' + dish.food_name + '</h3>';
                    menuHtml += '<p class="card-text">Cena: ' + dish.price + '</p>';
                    menuHtml += '<p class="card-text">Reštaurácia: ' + dish.name + '</p>';
                    menuHtml += '</div>';
                    menuHtml += '</div>';
                } else {
                    menuHtml += '<div class="card mb-3 bg-dark text-light">';
                    menuHtml += '<div class="card-body">';
                    menuHtml += '<h3 class="card-title">' + dish.food_name + '</h3>';
                    menuHtml += '<p class="card-text">Cena: Zadarmo k menu</p>';
                    menuHtml += '<p class="card-text">Reštaurácia: ' + dish.name + '</p>';
                    menuHtml += '</div>';
                    menuHtml += '</div>';
                }
            });
            $('#menu').html(menuHtml);
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tabulator/4.9.3/js/tabulator.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</body>
</html>