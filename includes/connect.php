<?php

 //localhost


$servername = "localhost";
$username = "root";
$password = "";//ep=CGQVnVVFR
$db = "championsmumbai_pptdemo";


/*
$servername = "localhost";
$username = "rathinfo_mailsend";
$password = "3XR{lE]n?cfd";
$db = "rathinfo_mailsend";
*/

$conn = mysqli_connect($servername, $username, $password, $db);


/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}else{

  //echo"DB conncet";
}


?>