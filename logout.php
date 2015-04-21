<?php

session_start();

$logging_out_user = $_SESSION['valid_user'];
unset($_Session['valid_user']);
session_destroy();
header('Location: index.php');

?>