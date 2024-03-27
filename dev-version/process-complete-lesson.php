<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

include 'db.php'; // Ensures DB connection and initializes $parent, $userId, and $explorerId
$explorerType = $parent ? "parent" : "kid";
$explorerId = $parent ? $userId : $explorerId; // Assuming $userId is for parent and $explorerId for kid

$id=new ObjectId($_REQUEST['id']);

if($explorerType != "kid") {
	header("Location: index.php");
	die();
}

$kid=$database->kids->findOne(['_id'=>new ObjectId($explorerId),'deleted' => ['$ne' => true]]);
if(!$kid) {
	header("Location:explorer.php");
	die();
}

$poster=$database->contentPackMedia->findOne(['_id'=>$id,'deleted' => ['$ne'=>true],'status'=>'live']);
if(!$poster) {
	header("Location:index.php");
	die();
}


$completed=false;
	if(isset($kid['completedLessons'])) {
		foreach($kid['completedLessons'] as $k => $v) {
			if((string)$v == (string)$poster['_id']) {
				$completed=true;
			}
		}
	}


if(!$completed) {
$database->kids->updateOne(['_id'=>$kid['_id']],['$addToSet' => ['completedLessons' => $id]]);

if(isset($kid['starSystem']) && $kid['starSystem'] && isset($poster['stars'])) {
	$database->starTransactions->insertOne(['kidId'=>$kid['_id'],'amount'=>$poster['stars'],'reasonType'=>'lesson','lessonId'=>$poster['_id']]);
}

}

header("Location: lessons.php");
