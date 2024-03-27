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


$catactivities=activitiesBySubCategories($kid['_id'],$_REQUEST['id']);

?>
<!-- <H2><?=categoryName($_REQUEST['id']);?> Activities</h2> -->
<div class="categories-mobile">
	<strong class="categories_style"><?=categoryName($_REQUEST['id']);?> Activities</strong><br/>
	<strong class="categories_style" style="margin-inline: 10px;">Categories</strong><br/>
</div>
<div class="d-flex flex-nowrap" style="overflow-x:auto;">
	<?php
	foreach($catactivities['activitiesByCategory'] as $cat => $activities) { 
	?>
	<div class="category-item-contain"><a class="category-item" href=activity-category.php?id=<?=$cat;?>><?=categoryName($cat);?></a> </div>
	<?php } ?>

</div>

<strong class="categories_style">Subjects</strong><Br/>
<div class="d-flex flex-nowrap" style="overflow-x:auto;">
	<div class="category-item-contain">	<a class="category-item" href=javascript:void(0); onclick="$('.activity').show();">All</a> </div>
	<?php
	foreach($catactivities['activitiesBySubject'] as $subj => $activities) { 
	?>
	<div class="category-item-contain"> <a class="category-item" href=javascript:void(0); onclick="filterSubject('<?=cleanSubj($subj);?>');"><?=$subj;?></a> </div>
	<?php } ?>
</div>

<strong class="categories_style">Available Activities</strong><Br/>
<div >
	<?php
	foreach($catactivities['activitiesByCategory'] as $cat => $activities) { ?>
		<strong class="categories_style" style="margin-inline: 10px;"><?=categoryName($cat);?></strong><Br/>
		<div class="d-flex flex-nowrap" style="overflow-x:auto;">
<?php foreach($activities as $k => $activity) { ?>
<div class="activity activity-image-contain <?=cleanSubj($activity['subject']);?>"><a href="view-poster.php?id=<?=$activity['_id'];?>"><img src="<?=$activity['hImage']['thumbUrl'];?>" class="activity-image-item"></a>
<br/><?php if(isset($kid['starSystem']) && $kid['starSystem'] && isset($activity['stars'])) { ?> 
	<div class="activity-star-position"> <img src="../assets/img/Star.png" style="width:18px;" alt="star"> <?=$activity['stars'];?> <?php } ?> </div>
</div>
<?php   }
?>
</div>
<?php
 }
?>
</div>

<!-- <?php
 
 
	foreach($catactivities['activitiesByCategory'] as $cat => $activities) { ?>
<h3><?=categoryName($cat);?></h3>
<hr>
<?php foreach($activities as $k => $activity) { ?>
<div class="card activity <?=cleanSubj($activity['subject']);?>" ><a href="view-poster.php?id=<?=$activity['_id'];?>"><img src="<?=$activity['hImage']['thumbUrl'];?>" style="max-width:250px"></a>
<br/><?php if(isset($kid['starSystem']) && $kid['starSystem'] && isset($activity['stars'])) { ?>Worth <?=$activity['stars'];?> Stars<?php } ?></div>
<?php    }
 }
?> -->
 

 



<?php
include('footer.php');
?>
<script>
function filterSubject(subj) {
$(".activity").each(function() { if($(this).hasClass(subj)) { $(this).show(); } else { $(this).hide(); } });
}
</script>