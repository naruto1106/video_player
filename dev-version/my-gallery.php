<?php
// Assuming 'db.php' initializes the $database connection and defines $userId and $explorer
include('db.php');
include('header.php');
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

$settings=$database->settings->findOne(['deleted'=>['$ne'=>true]]);
$settings=$settings['settings'];

// Check if $explorer is defined and has a 'parent' property
if(isset($explorer['parent'])) {
    header("Location: explorer.php");
    exit();
}

// Attempt to find the gallery for the current explorer
$gallery = $database->galleries->findOne(["kid" => $explorer['_id']]);
//print_r($gallery);

// If no gallery exists, create one
if(!$gallery) {
    $result = $database->galleries->insertOne([
        "name" => "Gallery for: " . $explorer['name'], 
        "userId" => $userId, 
        "kid" => $explorer['_id'], 
        "allowUpload" => false, 
        "media" => [], 
        "devices" => []
    ]);
    $galleryId = $result->getInsertedId();
    $gallery = $database->galleries->findOne(["_id" => $galleryId]);
}

// Check if postersAvailable is set for the explorer
if(!isset($explorer['postersAvailable'])) {
    $database->kids->updateOne(
        ["_id" => $explorer['_id']],
        ['$set' => ["postersAvailable" => 1]]
    );
    $postersAvailable = 1;
} else {
    $postersAvailable = $explorer['postersAvailable'];
}
echo "<div class='gallery-header-title'>UNLOCK NEW POSTERS FOR 20 STARS  🤩 </div>";
echo "<div class='gallery-header-title-sub'>Complete <a href='activities.php'>activities</a> to earn stars and display them on your screen!</div>";
echo "<div class='gallery-header-title-sub'>If you need more posters, ask your parents :)</div>";
// echo "Complete <a href='activities.php'>activities</a> and <a href='lessons.php'>lessons</a>, you'll be able to pick more personalized posters to show on your display. If you're allowed, you can upload posters here and select them to show on your screen when you unlock a new one. You can also ask your parents to add your favorite posters so you can choose from them :)<HR>";
?>

<!-- <div style="width: 100%; height: 100%;">
    <img src="../assets/img/gallery.png" style="width: 100%; height: 100%'; object-fit: cover;">
</div> -->
<?php
$starsys=false;
if(isset($explorer['starSystem']) && $explorer['starSystem']) {
$starsys=true;
$stars=getKidStars($explorer['_id']);
$postersAvailable=floor($stars/$settings['posterStarCost']);
// echo "<HR>";
// echo "<strong>You have ".$stars." stars. It costs ".$settings['posterStarCost']." stars to unlock a new poster.</strong>";
if($stars >= $settings['posterStarCost']) {
// echo " You can unlock up to ".floor($stars/$settings['posterStarCost'])." poster(s)";

} else {
// echo " You'll need to <a href=activities.php>complete activities</a> or <a href=lessons.php>lessons</a> to earn more stars!";
}
// echo "<HR>";
}

    $selectedMedia=[];
// Display posters if available
if(!$starsys) {
if($postersAvailable > 0) {
    echo "You have " . $postersAvailable . " poster(s) to pick! Let's pick one:";

} else {
echo "Keep interacting with FrameBright posters and you'll be able to add more posters of your own !";
}
}
    echo "<div class='how-it-works'>Click On The Posters You Want To add to Your Active Gallery</div>";
    
 if($postersAvailable > 0) { echo "<div class='how-it-works1'>Click on the poster you want to use!</div>"; }

    $selectedPosters = [];
    if(isset($gallery['selectedPosters'])) {
        foreach($gallery['selectedPosters'] as $k => $v) {
		$selectedPosters[]=(string)$v;
	}
    }
	$count=0;
    // Display media not yet selected as posters
    echo "<div class='gallery-item-contain'>";
    foreach($gallery['media'] as $media) { 


        $t=true;
		if (is_object($media) && isset($media->itemId)) {
            // Assuming $v->itemId is an ObjectId or can be directly used in the query
            $mediaObject  = $database->apiUserMedia->findOne(['_id' => $media->itemId]);
			$mid=(string)$media->itemId;
        } elseif ($media instanceof MongoDB\BSON\ObjectId) {
            // $v is directly an ObjectId
            $mediaObject  = $database->apiUserMedia->findOne(['_id' => $media]);
				$t=false; $mid=(string)$media;
		} 
        

        if(isset($mediaObject) && $mediaObject) {
            if(!in_array((string)$mid, $selectedPosters)) {
            $count++;
                // Ensure $mediaObject is found before trying to access 'thumbUrl'
                if($mediaObject) {
                    if($postersAvailable > 0) { 
                        echo '<a href=javascript:void(0) onclick="openModal(\''.htmlspecialchars((string)$mid).'\', \''.htmlspecialchars((string)$gallery['_id']).'\')">'; 
                        //echo '<a href=javascript:void(0) onclick="if(confirm(\'Are you sure you want to activate this poster?\')) { window.location.href=\'set-poster.php?id=' . htmlspecialchars((string)$mid) . '&gallery='.(string)$gallery['_id'].'\';} return false">'; 
                    }
                    echo '<div class="gallery-item"><img class="gallery-item-image" onerror="this.parentNode.removeChild(this)" src="' . htmlspecialchars($mediaObject['thumbUrl']) . '"><div class="lock-icon"><img src="../assets/img/LockSimple.png" class="locg-icon-image" alt="LockSimple"></div></div></a>';
                    //if($postersAvailable > 0) {		echo '<br>Select this poster!</a><br/>'; }
                }
            } else { $selectedMedia[]=$mediaObject; } }
        }
    echo "</div>";
        if($count == 0) {
            echo "<br/>You need to add some more posters to your gallery to pick from :)";
        }
 

    if(isset($gallery['allowUpload']) && $gallery['allowUpload'] == true || true) {
	?>
        <!-- <form action="process-upload-image.php" method="post" enctype="multipart/form-data">
	<input type=hidden name=galleryId value=<?=(string)$gallery['_id'];?>>
            <div class="mb-3">
                <label for="imageUpload" class="form-label">Select image to upload:</label>
                <input type="file" class="form-control" id="imageUpload" name="imageUpload" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload Image</button>
        </form> -->
        <!-- <center><input type=submit class="quiz-done" value="Done!"></center> -->
<?php
    }


if(count($selectedMedia) > 0) { 
?>
<div class="my-active-gallery-contain" >
<div class='how-it-works'>Your Active Gallery:</div>
<div class="active-gallery-contain">
    <?php foreach($selectedMedia as $K => $v) { ?>
        <div class="active-gallery-item">
            <div class="active-gallery-item-image">
                <img onerror="this.parentNode.removeChild(this)"  src="<?=$v['thumbUrl'];?>">        
            </div>
            <div class="active-gallery-item-content">
                <?php if(isset($explorer['playnow']) && $explorer['playnow']) { ?>
                    <form action=play-now.php>
                        <input type=hidden name=id value="<?=$v['_id'];?>">
                        <p>Show On:</p>
                        <div class="custom-select" style="width:140px;">
                            <select name="display" id="display" style="width:100%; height: 40px; border-radius: 20px; padding-inline: 20px; appearance: none; -webkit-appearance: none; -moz-appearance: none;">
                                <?php
                                $displays = getKidDisplays($explorer['_id']);
                                foreach($displays as $k => $v) {
                                ?>
                                <option value="<?=$v['_id'];?>"><?=$v['name'];?></option>
                                <?php } ?>
                            </select>
                            <div class="select-arrow">&#9660;</div>
                        </div>
                        <br/>
                        <p style="margin-top: 10px;">For:</p>
                        <div class="custom-select" style="width:140px;">
                            <select name="length" id="length" style="width:100%; height: 40px; border-radius: 20px; padding-inline: 20px; appearance: none; -webkit-appearance: none; -moz-appearance: none;">
                                <option value=60>1 Minute</option>
                                <option value=300>5 Minutes</option>
                                <option value=<?=(60*30);?>>30 Minutes</option>
                                <option value=<?=(60*60);?>>1 Hour</option>
                            </select>
                            <div class="select-arrow">&#9660;</div>
                        </div>
                        
                        <br/>
                        <input type="submit" class="activity-play" value='Play Now'>
                    </form>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
</div>
<?php } 
include('footer.php');
?>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="position-close">
        <span class="close">&times;</span>
    </div>
    <div class="confirm-content">
        <p class="confirm-message">Are you sure you want to activate this poster for 20 stars?</p>
        <a href="" class="modal-active-btn"> ACTIVATE </a>
        <div class="modal-cancel-btn">cancel</div>
    </div>
  </div>

</div>


<script>

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

function openModal(mid, galleryId) {
    var modal = document.getElementById("myModal");
    var modalActiveBtn = document.querySelector(".modal-active-btn");
    var modalCancelBtn = document.querySelector(".modal-cancel-btn");
    var modalCloseBtn = document.querySelector(".close");

    // Set the href attribute of the activate button
    modalActiveBtn.setAttribute("href", "set-poster.php?id=" + encodeURIComponent(mid) + "&gallery=" + encodeURIComponent(galleryId));

    // Display the modal
    modal.style.display = "block";

    // Close the modal if cancel button is clicked
    modalCancelBtn.onclick = function() {
        modal.style.display = "none";
    }
    modalCloseBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Close the modal if user clicks anywhere outside of the modal content
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

// Function to close modal
function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}
</script>