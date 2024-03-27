<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

include('header.php');

include 'db.php'; // Ensures DB connection and initializes $parent, $userId, and $explorerId

// Retrieve ID from the query parameters
$mediaId = isset($_POST['id']) ? new ObjectId($_POST['id']) : null;
$explorerType = $parent ? "parent" : "kid";
$explorerId = $parent ? $userId : $explorerId; // Assuming $userId is for parent and $explorerId for kid

$mediaItem = $database->contentPackMedia->findOne(["_id" => $mediaId]);
$answer="";
if(isset($_REQUEST['answer'])) $answer = (int)$_REQUEST['answer'];
$answerObject = $mediaItem['answers'][$answer] ?? null; // Safeguard against undefined index
$pass = $answerObject && $answerObject['answerCorrect'] === true;

$userHistory = $database->userQuizHistory->findOne([
    "mediaItem" => $mediaId,
    "explorerType" => $explorerType,
    "explorerId" => $explorerId
]);
$alreadyPassed=false;

if($mediaItem['questionType'] == "multipleChoice" && $mediaItem['interactive']) {
if ($userHistory) {
    $database->userQuizHistory->updateOne(
        ["_id" => $userHistory['_id']], // Corrected from 'id' to '_id'
        ['$push' => ['attempts' => ['time' => new MongoDB\BSON\UTCDateTime(), 'answer' => $answerObject]]] // Corrected 'attemps' typo to 'attempts'
    );

    if ($pass && !$userHistory['pass']) {
        $database->userQuizHistory->updateOne(
            ["_id" => $userHistory['_id']],
            ['$set' => ['pass' => true]]
        );
        $database->kids->updateOne(
            ["_id" => $explorerId],
            ['$inc' => ['postersAvailable' => 1]]
        );
    } else {
	$alreadyPassed=true;
    }
} else {
    $database->userQuizHistory->insertOne([
        "explorerType" => $explorerType,
        "explorerId" => $explorerId,
        "mediaItem" => $mediaId,
        "attempts" => [['time' => new MongoDB\BSON\UTCDateTime(), 'answer' => $answerObject]],
        "pass" => $pass
    ]);

    if ($pass) {
        $database->kids->updateOne(
            ["_id" => $explorerId],
            ['$inc' => ['postersAvailable' => 1]]
        );
    }
}



} else {//type

if ($userHistory && $userHistory['pass']) {
$pass="repeat";
} else {
$pass="basic";
 $database->userQuizHistory->insertOne([
        "explorerType" => $explorerType,
        "explorerId" => $explorerId,
        "mediaItem" => $mediaId,
        "attempts" => [['time' => new MongoDB\BSON\UTCDateTime(), 'answer' => $answerObject]],
        "pass" => $pass
    ]);
 $database->kids->updateOne(
            ["_id" => $explorerId],
            ['$inc' => ['postersAvailable' => 1]]
        );


}

}
$stars=false;
echo "<div class='main-content'> </div>";
echo "<div class='submit-contain'><div style='text-align: center'>";
if($pass == "basic") {
    echo "<center class='submit-contain-text'>Good work :) <br/>";
    echo "<a class='submit-goto' href='activities.php'>Let's Go!</a></center>";
$stars=true;
} else if($pass == "repeat") {
   echo "<center class='submit-contain-text'>Good work :) <br/>";

} else if ($pass === true) {
    echo "<center class='submit-contain-text'> Good work ! </center> <br/>";
    echo "<center class='submit-contain-text'>Let's find more activitites! </center> <br/>";
    echo "<a class='submit-goto' href='activities.php'>Let's Go!</a>";
$stars=true;
} else {
    echo "<center class='submit-contain-text'>Try again, you got this!</center><br/>";
    echo "<a class='submit-goto' href='quiz.php?id=" . htmlspecialchars($_POST['id']) . "'>Click here to try again</a>";
}
echo "</div></div>";

if($stars) {

	if($explorerType == "kid") {

		$kid=$database->kids->findOne(['_id'=>$explorerId]);
		if(isset($kid['starSystem']) && $kid['starSystem'] && isset($mediaItem['stars'])) {
		$database->starTransactions->insertOne(['kidId'=>$kid['_id'],'amount'=>$mediaItem['stars'],'reasonType'=>'activity','activityId'=>$mediaItem['_id']]);

		}
	}

} 
include('footer.php');
?>