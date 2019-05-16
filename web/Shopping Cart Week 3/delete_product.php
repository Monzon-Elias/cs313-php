<?php
session_start();
array_pop($_SESSION['cart']);
var_dump($_SESSION['cart']);
?>

<br><br>
<a href="index.php">Return to products</a><br>
<a href="delete_product.php">Delete last product</a>