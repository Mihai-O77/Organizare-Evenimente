<?php

$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;

$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

//////////////////////////////////////////////////

/*$serverName="localhost";
$dbUserName="root";
$dbPassword="";
$dbName="pr_orgz_ev";

$conn=mysqli_connect($serverName, $dbUserName, $dbPassword, $dbName);*/

//$conn = $conn2 || $conn1;

 if(!$conn){
    die("Connection failed".mysqli_connect_error());
}
