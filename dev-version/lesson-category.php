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
header("Location:explorer.php?return=/lessons.php");
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


$catlessons=lessonsBySubCategories($kid['_id'],$_REQUEST['id']);

?>
<H2><?=categoryName($_REQUEST['id']);?> Lessons</h2>
<strong>Categories:</strong><br/>
<?php
foreach($catlessons['lessonsByCategory'] as $cat => $lessons) { 
?>
<a href=lesson-category.php?id=<?=$cat;?>><?=categoryName($cat);?></a> 
<?php } ?>
<hr>
<strong>Subjects:</strong><Br/>
<a href=javascript:void(0); onclick="$('.lesson').show();">All</a> 
<?php
foreach($catlessons['lessonsBySubject'] as $subj => $lessons) { 
?>
<a href=javascript:void(0); onclick="filterSubject('<?=cleanSubj($subj);?>');"><?=$subj;?></a> 
<?php } ?>
<hr>
<h1>Available Lessons</h1>
<?php
 
 
	foreach($catlessons['lessonsByCategory'] as $cat => $lessons) { ?>
<h3><?=categoryName($cat);?></h3>
<hr>
<?php foreach($lessons as $k => $lesson) { ?>
<div class="card lesson <?=cleanSubj($lesson['subject']);?>" ><a href="view-poster.php?id=<?=$lesson['_id'];?>"><img src="<?=$lesson['vImage']['thumbUrl'];?>" style="max-width:250px"></a>
<br/><?php if(isset($kid['starSystem']) && $kid['starSystem'] && isset($lesson['stars'])) { ?>Worth <?=$lesson['stars'];?> Stars<?php } ?></div>
<?php    }
 }
?>
 

 



<?php
include('footer.php');
?>
<script>
function filterSubject(subj) {
$(".lesson").each(function() { if($(this).hasClass(subj)) { $(this).show(); } else { $(this).hide(); } });
}
</script>