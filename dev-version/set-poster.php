<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

include 'db.php'; // Ensure DB connection

// Retrieve IDs from the query parameters
$mediaId = isset($_GET['id']) ? new ObjectId($_GET['id']) : null;
$galleryId = isset($_GET['gallery']) ? new ObjectId($_GET['gallery']) : null;

$settings=$database->settings->findOne(['deleted'=>['$ne'=>true]]);
$settings=$settings['settings'];
$starsys=false;
if(isset($explorer['starSystem']) && $explorer['starSystem']) {
$starsys=true;
//echo "STARSYS";
$stars=getKidStars($explorer['_id']);
$postersAvailable=floor($stars/$settings['posterStarCost']);
if($postersAvailable == 0) {
die("You don't have enough stars.");
}
}
 

// Check if both IDs are provided
if ($mediaId && $galleryId) {
    // Fetch the gallery document
    $gallery = $database->galleries->findOne(["_id" => $galleryId]);

    // Check if the gallery exists
    if ($gallery) {
        // Check if the media ID is already in the selectedPosters array
	$p=[];
	if(isset($gallery['selectedPosters'])) {
	$p=json_decode(json_encode($gallery['selectedPosters']),1);
	}
        if (!in_array($mediaId, $p)) {
            // Add the mediaId to the selectedPosters array
            $updateResult = $database->galleries->updateOne(
                ["_id" => $galleryId],
                ['$push' => ['selectedPosters' => $mediaId]]
            );
$database->kids->updateOne(
    ["_id" => $explorerId],
    ['$inc' => ['postersAvailable' => -1]]
);


if($starsys) {

	if($explorerType == "kid") {

		$kid=$database->kids->findOne(['_id'=>$explorerId]);
		if(isset($kid['starSystem']) && $kid['starSystem']  ) {
		$database->starTransactions->insertOne(['kidId'=>$kid['_id'],'amount'=>($settings['posterStarCost']*-1),'reasonType'=>'buyPoster','itemId'=>$mediaId]);

		}
	}

} 


            // Check if the update was successful
            if ($updateResult->getModifiedCount() == 0) {
                // Handle case where the update did not succeed
                $_SESSION['error'] = "Failed to update the gallery.";
            }
        } else {
            // Handle case where the media ID is already selected
            $_SESSION['message'] = "This poster is already selected.";
        }
    } else {
        // Handle case where the gallery does not exist
        $_SESSION['error'] = "Gallery not found.";
    }
} else {
    // Handle case where not all required query parameters are provided
    $_SESSION['error'] = "Invalid request. Missing parameters.";
}

// Redirect back to my-gallery.php
header("Location: my-gallery.php");
exit;
