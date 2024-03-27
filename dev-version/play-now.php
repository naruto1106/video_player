<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

include 'db.php'; // Ensure DB connection

// Retrieve IDs from the query parameters
$mediaId = isset($_REQUEST['id']) ? new ObjectId($_REQUEST['id']) : null;
$displayId=isset($_REQUEST['display']) ? new ObjectId($_REQUEST['display']) : null;
$length=isset($_REQUEST['length']) ? (int)$_REQUEST['length'] : 60;

 $now = new MongoDB\BSON\UTCDateTime(time() * 1000);

$start= $now;
$end=new MongoDB\BSON\UTCDateTime((time()+$length) * 1000);

$database->playNow->insertOne(['displayId'=>$displayId,'mediaId'=>$mediaId,'start'=>$start,'end'=>$end,'explorerType'=>$explorerType,'explorerId'=>$explorerId]);

header("Location: my-gallery.php");
