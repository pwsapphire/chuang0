La base de donnée SQLite se trouve ici. Celle ci doit etre accessible a la fois en ecriture et lecture afin de pouvoir etre modifiee.

Il faut utiliser le driver pdo sqlite:
    $pdo = new PDO("sqlite:DB/yelp.db");
    Pas d'user et de mdp.