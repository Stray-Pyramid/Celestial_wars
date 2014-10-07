<?php
//Logout Script
session_start();

unset($_SESSION['id']);

header("Location: http://www.straypyramid.com/celestial_wars/");
die();
?>