<?php
$_OVERRIDE=true;
require 'db.php'; // Database connection
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

$client = new MongoDB\Client($client);
$database = $client->$db;
$kidsCollection = $database->kids; // Use the kids collection

// Assuming you have a way to identify the current user (e.g., session)
$userId = $_SESSION['userId'];

 
   $result= $kidsCollection->insertOne([
        'userId' => new ObjectId($userId),
        'name' => $_POST['name'],
        'date' => $_POST['date'],
	'avatar' => $_POST['avatar']
    ]);
 

$insertedId = $result->getInsertedId();
    $galleriesCollection->insertOne([
        'userId' => new ObjectId($userId),
        'name' => "Gallery for: ".$_POST['name'],
        'kid' => $insertedId,
	'allowUpload' => false,
	'media' => [],
	'devices' => []
    ]);


header('Location: explorer.php');
exit;
