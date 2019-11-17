<?php
$host = "host = postgres.iro.umontreal.ca";
$port = "port = 5432";
$dbname = "dbname = brochum";
$credentials = "user = brochum_app password=Jikikool";

function db_connect()
{
    global $host;
    global $port;
    global $dbname;
    global $credentials;
    $db = pg_connect("$host $port $dbname $credentials");
    if (!$db) {
        die("Error : Unable to open database\n");
    }
    return $db;
}

function db_request($conn, $req)
{
    $result = pg_query($conn, $req);
    if (!$result) {
        die("Une erreur s'est produite.");
    }
    return $result;
}

function db_close($conn) {
    pg_close($conn);
}
