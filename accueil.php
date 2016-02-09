<!DOCTYPE HTML>
<html>
    <head>
        <title>Webforce Yelp</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="css/mainStyle.css">
    </head>
    <body>
        <!-- Emplacement du header général contenant tous les liens vers les différentes parties du site  -->
        
        <!-- Emplacement Google Maps -->
        <div id="gMap"></div>
        
        <!-- Test Connection DB via config.php -->
        <?php
            include 'php/config.php';
            
            echo checkUser('deltgen.david@gmail.com', 'webforce3');
        
        ?>
        
        <!-- Emplacement du slider avec les 10 derniers lieux: BONUS -->
        
    </body>
    <script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
    <script type="text/javascript" src="js/gmap.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnpzeUbspaqY2mQAlVfNDGAPWe94Nc0Mo&signed_in=true&callback=initGmap"></script>
</html>