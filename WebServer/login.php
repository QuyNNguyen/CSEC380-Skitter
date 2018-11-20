<?php



//authenticate users here



// generate csrf tokem
$_SESSION['token'] = bin2hex(random_bytes(32));

?>