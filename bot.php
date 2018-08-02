<?php

include("functions.php");
include("sendfunctions.php");

date_default_timezone_set('America/Sao_Paulo');

$currentunix = time();

file_put_contents("fb.txt", file_get_contents("php://input"));

$fb = file_get_contents("fb.txt");

//echo "<pre>";

$fb = json_decode($fb);

$db = mysqli_connect("db.db.db.db", "db", "db", "db"); 

$rid = $fb -> entry[0] -> messaging[0] -> sender -> id;
$msg = $fb -> entry[0] -> messaging[0] -> message -> text;

//START OF MSG VERIFICATION
if($msg != ""){

$query = mysqli_query($db, "SELECT COUNT(*) FROM db.tabela WHERE senderid=$rid;");
$row = mysqli_fetch_row($query);
$counter = $row[0];

$token = "token";

//WELCOME MESSAGE/FIRST TIME VISITING
include("estagio0.php");

//REST
if ($counter>0){
	
$query = mysqli_query($db, "SELECT estagio FROM db.tabela WHERE senderid=$rid;");
$row = mysqli_fetch_row($query);
$estagio = $row[0];


//ESTAGIO 1 
include("estagio1.php");

//ESTAGIO 2 
include("estagio2.php");

//ESTAGIO 3
include("estagio3.php");


}
//END OF MSG VERIFICATION
}
//print_r($fb);
?>			