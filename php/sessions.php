<?php
require 'config.php';

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

?>
<br />
<a href="add.php">ajouter</a><br />
<a href="delete.php">supprimer</a><br />
<a href="delete.php?all=1">supprimer tout</a><br />