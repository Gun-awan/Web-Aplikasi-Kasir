<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$conn = mysqli_connect("localhost","root","","kasirapp");
?>
<?php
date_default_timezone_set('Asia/Jakarta');
?>