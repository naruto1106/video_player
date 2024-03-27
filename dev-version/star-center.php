<?php
// Assuming 'db.php' initializes the $database connection and defines $userId and $explorer
include('db.php');
include('header.php');
require 'vendor/autoload.php';
if($parent) {
$explorerType="parent";
$explorerId=$userId;
} else {
$explorerType="kid";
if(!isset($explorerId)) {
header("Location:explorer.php?return=/activities.php");
}
$explorerId=$explorerId;
}

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

if($explorerType != "kid") {
	header("Location: index.php"); die();
}

$kid=$database->kids->findOne(["_id" => new ObjectId($explorerId)]);
if(!$kid) {
	header("Location: explorer.php"); die(); 
}
$starsys=false;
if(isset($kid['starSystem']) && $kid['starSystem']) { $starsys=true; }
if(!$starsys) { header("Location: index.php"); die(); }


?>
<h1 style="margin-top:70px;">Star History</h1>
<table class=table>
<thead>
<tr>
<th>Amount</th><th>Reason</th><th>Balance</th>
</tr>
<thead>
<tbody>
<?php
$bal=0;
$data=$database->starTransactions->find(['kidId'=>$kid['_id'],'deleted'=>['$ne'=>true]])->toArray();
foreach($data as $k => $v) {
?>
<tr>
<td><?=$v['amount'];?></td>
<td><?php
if($v['reasonType'] == "lesson") {
echo "Lesson Completed";
} else if($v['reasonType'] == "activity") {
echo "Activity Completed";
} else if($v['reasonType'] == "buyPoster") {
echo "Poster Activated";
}
?></td>
<td><?php
$bal=$bal+$v['amount'];
echo $bal; ?></td>
</tr>
<?php } ?>
</tbody>
</table>

<?php
include('footer.php');