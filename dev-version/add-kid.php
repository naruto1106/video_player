<?php
 $_OVERRIDE=true;
include('db.php');
require 'vendor/autoload.php';
use MongoDB\Client;

$mongoClient = new Client($client);
$database = $mongoClient->selectDatabase($db);
$usersCollection = $database->users;
$userId = new MongoDB\BSON\ObjectId($_SESSION['userId']);
$user = $usersCollection->findOne(['_id' => $userId]);
$_SESSION['userName'] = $user['name'];

$kidsCollection = $database->kids;

// Assuming you have a way to identify the current user (e.g., session)
$userId = $_SESSION['userId'];

// Fetch kids related to the current user
$kidsCursor = $kidsCollection->find(['userId' => new MongoDB\BSON\ObjectId($userId)]);
$kids = iterator_to_array($kidsCursor);


include('header.php');

?>
<center><h1>Add a Kid</h1>
<form action=process-add-kid.php method=post>
Name: <input type=text name=name><Br/>
Birthdate: <input type=date name=date><br/>
Avatar:<br/>
<?php $avatars=$database->avatars->find(); 
foreach($avatars as $k => $v) {
	?><input type=radio name=avatar value="<?=$v['url'];?>"> <img style="max-width:250px; max-height:250px"  src="<?=$v['url'];?>"><br/><?php
}
?><br/>
<input type=submit>
</form>


<?php

include('footer.php');
?>
