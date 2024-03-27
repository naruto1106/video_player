
<?php
 $_OVERRIDE=true;
include('db.php');
require 'vendor/autoload.php';
use MongoDB\Client;
if(!isset($_SESSION['userId'])) die("Auth");
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
$kidsCursor = $kidsCollection->find(['userId' => new MongoDB\BSON\ObjectId($userId), 'deleted' => ['$ne' => true]]);
$kids = iterator_to_array($kidsCursor);

 
include('header1.php');

?>
<div class="home-main-text w-full text-center">
<h2>Welcome, Explorer! </h2>
</div>
<div class="home-sub-text text-center">
<h5>Please select your profile to customize your gallery and start completing activities :)</h5>
</div>

<ul class="kids-list">
<!-- <li> <a class=explorerbutton onerror="this.parentNode.removeChild(this)" href="set-explorer.php?id=user<?php if(isset($_REQUEST['return'])) { ?>&return=<?=urlencode($_REQUEST['return']);?><?php } ?>"  ><?=$user->name;?></a></li> -->
<?php
foreach($kids as $kid) { ?>
<li> <a class="explorerbutton kids-item" href="set-explorer.php?id=<?=$kid->_id;?><?php if(isset($_REQUEST['return'])) { ?>&return=<?=urlencode($_REQUEST['return']);?><?php } ?>" >
	<?php if(isset($kid['avatar'])) { ?><img onerror="this.parentNode.removeChild(this)" class="explorer-kids-image"  src="<?=$kid['avatar'];?>"><?php } ?>
</br>	<?=$kid->name;?>
	</a> 
</li>
<?php } ?>
</ul>


<hr>
<!-- <center><h6>More explorers ready to join? Add them in in the FrameBright parent app!</h6></center> -->
<?php /* 
<a href="add-kid.php">Add</a>
<hr>
<a href=logout.php>Log Out of App</a>
*/ ?>
<?php

include('footer.php');
?>
