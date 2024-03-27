
<?php
 
include('db.php');
require 'vendor/autoload.php';
use MongoDB\Client;
 use MongoDB\BSON\ObjectId;

include('header.php');
if($parent) {
$explorerType="parent";
$explorerId=$userId;
} else {
$explorerType="kid";
if(!isset($explorerId)) {
header("Location:explorer.php?return=/quiz.php?id=".$_REQUEST['id']);
}
$explorerId=$explorerId;
}
if($explorerType == "kid") {
	$kid=$database->kids->findOne(["_id" => new ObjectId($explorerId)]);
	if(!$kid) {
		header("Location: explorer.php"); die(); 
	}
}

echo "<div class='main-content'> </div>";
// Main content
echo "<div class='explorer-main'>";

if(!$parent) { 
echo " <div class='explorer-title'>";
echo "<h4 class='explorer-title-font'>HEY ".$explorer['name']."! IT’S TIME TO COLLECT STARS! 🤩</h4>";
echo "<h4 class='explorer-title-font'>CLICK ON ACTIVITIES TO GET STARTED. </h4>";
echo "</div>";
echo "<a href='activities.php' style='text-decoration: none; color: white;'><div class='explorer-active'  >";
echo 	"Activities";
echo "</div></a>";
echo "<div class='explorer-bottom'>";
echo 	"<a href='my-gallery.php' style='text-decoration: none; color: white;'><div class='explorer-bottom-item'>My posters  </div></a>";
echo 	"<a href='star-center.php' style='text-decoration: none; color: white;' ><div class='explorer-bottom-item'> My stars  </div> </a>";
echo "</div>";

 

?>

<!-- <ul> 
<li><a href=activities.php>Activities</a></li>
<li><a href=star-center.php>Star Center</a></li>
<li><a href=my-gallery.php>My Posters</a></li>
</ul> -->


<?php
} else { 
echo "Hello! Please scan a QR code to take part in an activity :)";
}
echo "</div>";

include('footer.php');
?>
