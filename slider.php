<?php
include_once("connection.php");

// Caricamento delle immagini all'interno della galleria
$galleria = array();
$table = $pdo->query("SELECT * FROM comunicati_rov");

foreach($table as $row){
    array_push($galleria, $row["immagine"]);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider</title>

    <style>
        *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


body{
    display: flex;
    flex: 200px 1fr;
}

.sidebar{
    height: 100vh;
    width: 10vw;
    background-color: black;
    border-right: 1px solid white;
}

.sidebar h1{
    color: white;
    font-weight: bold;
}

.container{
    position: relative;
    display: flex;
    background-color: black;
    height: 100vh;
    width: 90vw;
    align-items: center;
    justify-content: space-evenly;
}

.slider{
    width: 700px;
    height: 900px;
    border: 1px solid white;
}

.slider img{
    object-fit: contain;
    width: 100%;
    height: 100%;
}
    </style>

</head>
<body>

<div class="sidebar">
    <h1 class="counter" id="counter"></h1>
</div>

<div class="container">
    <div class="slider" id="one">
        <img id="image-one" src="" alt="">
    </div>
    <div class="slider" id="two">
        <img id="image-two" src="" alt="">
    </div>
</div>

<script>
    // Passa l'elenco delle immagini da PHP a JavaScript
    const images = <?php echo json_encode($galleria); ?>;
    
    const MAX = 10;
    let i = 0;
    let j = MAX;
    const counter = document.getElementById('counter');
    const slide1 = document.getElementById('image-one');
    const slide2 = document.getElementById('image-two');

    function updateImages() {
        slide1.src = "images/" + images[i];
        slide2.src = "images/" + images[(i + 1) % images.length];

        // Avanza all'immagine successiva, tornando all'inizio se necessario
        i = (i + 1) % images.length;
    }

    function updateCounter() {
        counter.textContent = j;
        j--;

        if (j < 0) {
            j = MAX;
            updateImages();
        }
    }

    // Aggiornamento del contatore ogni secondo
    switch(images.length){
        case 0:
            slide1.src = "";
            slide2.src = "";
            break;
        case 1:
            slide1.src = "images/" + images[0];
            slide2.src = "";
            break;
        case 2:
            slide1.src = "images/" + images[0];
            slide2.src = "images/" + images[1];
            break;
        default:
            setInterval(updateCounter, 1000); // 1000 = 1 secondo
            updateImages();
            break;
        }


</script>

</body>
</html>
