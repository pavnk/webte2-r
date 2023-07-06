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
<h1>Menu</h1>
<div id="menu-list" class="row"></div>
<script>
    fetch('https://site179.webte.fei.stuba.sk/zadanie2r/menu.php')
        .then(response => response.json())
        .then(menu => {
            const menuList = document.getElementById('menu-list');
            menu.forEach(item => {
                let den;
                if(item.day==="1")
                    den = "Pondelok";
                else if(item.day==="2")
                    den = "Utorok";
                else if(item.day==="3")
                    den = "Streda";
                else if(item.day==="4")
                    den = "Štvrtok";
                else if(item.day==="5")
                    den = "Piatok";
                else
                    den = "Unknown";

                if (item.price !== null && item.price !== "null") {
                    const div = document.createElement('div');
                    div.textContent = `${item.food_name} - ${item.price}, Reštaurácia: ${item.name}, ${den}`;
                    div.classList.add('col-md-4', 'menu-item');
                    menuList.appendChild(div);
                } else {
                    const div = document.createElement('div');
                    div.textContent = `${item.food_name}, Zadarmo k menu, Reštaurácia: ${item.name}, ${den}`;
                    div.classList.add('col-md-4', 'menu-item');
                    menuList.appendChild(div);
                }
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