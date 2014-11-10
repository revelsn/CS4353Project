<?php

/*** mysql hostname ***/
$dbhostname = 'localhost';

$dbname = 'cs4345';

/*** mysql username ***/
$dbusername = 'root';

/*** mysql password ***/
$dbpassword = 'root';

try {
    $db = new PDO("mysql:host=$dbhostname;dbname=$dbname", $dbusername, $dbpassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /*** echo a message saying we have connected ***/
    echo 'Connected to database';
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
?>