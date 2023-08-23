<?php

$servername = 'localhost:3310';
$username = 'root';
$password = '';
$dbname = 'restate';
//attemp to connect to mysql database
$con = mysqli_connect($servername, $username, $password,$dbname);
if(!$con)
{
    echo 'cannot connect to the database';
}
/*
//testing if connected.
else{
    echo 'successful';
}