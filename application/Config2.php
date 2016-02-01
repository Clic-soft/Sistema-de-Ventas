<?php

$dbhost="localhost";
$dblogin="root";
$dbpwd="";
$dbname="tienda";
  
$db =  mysql_connect($dbhost,$dblogin,$dbpwd);
mysql_select_db($dbname);  
?>