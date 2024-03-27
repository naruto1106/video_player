<?php
// Assuming 'db.php' initializes the $database connection and defines $userId and $explorer
include('db.php');
include('header.php');
require 'vendor/autoload.php';

?>
<style>
    /* uncomment the following CSS for active parent / word indicator */ 
    
    .hyperaudio-transcript .active{
      background-color: #efefef;
    }

    .hyperaudio-transcript .active > .active {
      background-color: #ccf;
      text-decoration:  #00f underline;
      text-decoration-thickness: 3px;
    }
    
  </style>

<?php
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

use MongoDB\Client;
use MongoDB\BSON\ObjectId;
$id=new ObjectId($_REQUEST['id']);
$mediaItem = $database->contentPackMedia->findOne(["_id" => $id]);   

$poster=$database->contentPackMedia->findOne(['_id'=>$id,'deleted'=>['$ne'=>true],'status'=>'live']);

$packId=$mediaItem['packId'];
$pack=$database->contentPacks->findOne(["_id"=>$packId]);

if(!$mediaItem) { header("Location: index.php"); die(); }
$noaccess=false;
if($explorerType == "kid") {
	$kid=$database->kids->findOne(["_id" => new ObjectId($explorerId)]);
	if(!$kid) {
		header("Location: explorer.php"); die(); 
	}
	$inpackitems=false;
	if(isset($kid['contentPackItems'])) {
		foreach($kid['contentPackItems'] as $k => $v) {
			if((string)$v == (string)$mediaItem['_id']) {
				$inpackitems=true;
			}
		}
	}		
	$inautopacks=false;
	if(isset($kid['autopacks'])) {
		$found=false;
		foreach($kid['autopacks'] as $k => $v) {
			if((string)$packId == (string)$v) {
				$found=true;
			}
		}
		if($found) {
			$recItems=getRecommendedPackItems($kid['_id'],$packId);
			foreach($recItems as $k => $v) {
				if((string)$v['_id'] == (string)$mediaItem['_id']) {
					$inautopacks=true;
				}	

			}
		}
	}
	if(!$inautopacks && !$inpackitems) {
		$noaccess=true;
	}
}



$userHistory=$database->userQuizHistory->findOne(["mediaItem"=>$id,"explorerType"=>$explorerType,"explorerId"=>$explorerId]);
if($userHistory) {
	if(isset($userHistory['pass']) && $userHistory['pass'] === true) {
		//echo "<center>You passed this quiz already ;)  Good job!<hr><a href=index.php>Click here to keep exploring!</a></center>";
	//	$noaccess=true;
	}
}


function generateMediaEmbedTag($mediaUrl) {
    // Determine the file's extension
    $extension = strtolower(pathinfo($mediaUrl, PATHINFO_EXTENSION));

    // Define common audio and video types
    $audioTypes = [
        'mp3' => 'audio/mpeg',
        'wav' => 'audio/wav',
        'ogg' => 'audio/ogg', // OGG audio by default
    ];

    $videoTypes = [
        'mp4' => 'video/mp4',
        'ogg' => 'video/ogg', // You might add logic to handle OGG video explicitly
        'webm' => 'video/webm',
    ];

    // Check if it's audio and generate the audio tag
    if (array_key_exists($extension, $audioTypes)) {
        return "<audio controls style='max-width:100%'><source src=\"$mediaUrl\" type=\"{$audioTypes[$extension]}\">Your browser does not support the audio element.</audio>";
    }
    // Check if it's video and generate the video tag
    elseif (array_key_exists($extension, $videoTypes)) {
        return "<video controls style='max-width:100%'><source src=\"$mediaUrl\" type=\"{$videoTypes[$extension]}\">Your browser does not support the video element.</video>";
    }
    // File type is not supported
    else {
        return "Error: The file format is not supported for embedding.";
    }
}

  if(isset($mediaItem['questionImageUrl']) && $mediaItem['questionImageUrl'] != "") {
      echo   '<div class="questionImage" >';
      echo      "<img src='".$mediaItem['questionImageUrl']."' style='width: 100%; height: 100%; object-fit: cover;'>";
      echo   '</div>';
  }

if($noaccess) {
	echo "<center> This activity isn't recommended right now. Please <a href=index.php>select another one</a>.</center>";
} else {
	?>
	<form action=submit-answer.php method=post>
	<input type=hidden name=id value="<?=$_REQUEST['id'];?>">
  <!-- <img id="poster-image" src="<?=$poster['hImage']['url'];?>" style="width:100%; height: 100%; object-fit: cover;"> -->

  
	<?php  if(isset($mediaItem['questionText']) && $mediaItem['questionText'] != "") 
    echo "<div class='questionText'>";
    echo    nl2br($mediaItem['questionText']);
    if(isset($mediaItem['audioFileq']) && $mediaItem['audioFileq'] != "") {
  ?>
    <div class='speaker-contain' onclick="playAudio('<?php echo $mediaItem['audioFileq'] ?>')" ><img src='assets/img/speaker.png'></div>
  <?php
    }
    echo  "</div>";
//		if(isset($mediaItem['questionImageUrl']) && $mediaItem['questionImageUrl'] != "") echo "<img style=' max-width:250px; max-height:250px' src='".$mediaItem['questionImageUrl']."'>";
	?>


<!-- <?php
if(isset($mediaItem['audioFile']) && $mediaItem['audioFile'] != "" && (!isset($mediaItem['hyperaudio']) || $mediaItem['hyperaudio'] === false)) { 
?>
<?=generateMediaEmbedTag($mediaItem['audioFile']);?>

<?php } ?>

<?php
if(isset($mediaItem['videoFile']) && $mediaItem['videoFile'] != "" && (!isset($mediaItem['hyperaudio']) || $mediaItem['hyperaudio'] === false)) { 
?>
<?=generateMediaEmbedTag($mediaItem['videoFile']);?>

<?php } ?> -->



 
<!-- <?php
if(isset($mediaItem['hyperaudio']) && $mediaItem['hyperaudio']) {
?>
<div class="d-flex justify-content-center align-items-center">
<?php if(isset($mediaItem['videoFile']) && $mediaItem['videoFile'] != "") { ?>
  <video id="hyperplayer" class="hyperaudio-player"  src="<?=$mediaItem['videoFile'];?>" type="" controls>
    <track id="hyperplayer-vtt" label="English" kind="subtitles" srclang="en" src="<?=$mediaItem['videoFile'];?>">
  </video>
<?php } else { ?>
<?php if(isset($mediaItem['audioFile']) && $mediaItem['audioFile'] != "") { ?>
  <audio id="hyperplayer" class="hyperaudio-player"  src="<?=$mediaItem['audioFile'];?>" type="" controls></audio>
<?php } ?>
<?php } ?>
</div>

  <div id="hypertranscript" class="hyperaudio-transcript" style="overflow-y:scroll; height:500px; position:relative; border-style:dashed; border-width: 1px; border-color:#999; padding: 20px; margin-top: 10px; ">
    <?php echo $mediaItem['hyperaudiots']; ?>
  </div>

<?php } ?> -->



<div class="quiz-item-contain">
  <?php
  if(isset($mediaItem['questionType']) && $mediaItem['questionType'] == "multipleChoice" && $mediaItem['interactive']) { ?>
    <?php
    $letter = 'A';
      foreach($mediaItem['answers'] as $k => $v) {
    ?>
       <div class='quiz-item' id="quizItem<?=$k;?>" onclick="selectRadioButton('answer<?=$k;?>', this)" style="text-align: center;">
       
       <?php if(isset($v['answerImageUrl']) && $v['answerImageUrl'] != "") { ?>
              <div style="max-width: 135px; height: auto; display: inline-block;">
                  <?php echo "<img class='answerImage' src='".$v['answerImageUrl']."' />"; ?>
                  <?php if(isset($v['answerText']) && $v['answerText'] != "") echo "<span class='answerText-image' style='display:block;'>".nl2br($v['answerText'])."</span>"; ?>
              </div>
          <?php } else {
            if(isset($v['answerText']) && $v['answerText'] != "") echo "<span class='answerText' style='display:block;'>$letter. ".nl2br($v['answerText'])."</span>";
        } ?>
          <input type="radio" name="answer" value="<?=$k;?>" id="answer<?=$k;?>" style="display: none;">
      </div>

    <?php 
      $letter++;
    } ?>
    
    
  <?php } ?>
</div>


	<center style="padding-bottom: 100px;"><input type=submit class="quiz-done" value="Done!"></center>
	</form>
<script>
    // // Select all elements with the class 'answerImage'
    // var images = document.querySelectorAll('.answerImage');

    // // Iterate over each image and attach a click event listener
    // images.forEach(function(image) {
    //     image.addEventListener('click', function() {
    //         // Find the parent element of the clicked image
    //         var parent = this.parentNode;

    //         // Find the first input element within the parent element
    //         var input = parent.querySelector('input');

    //         // Trigger a click event on the found input element
    //         if (input) {
    //             input.click();
    //         }
    //     });
    // });

    function selectRadioButton(radioButtonId, divElement) {
        // Get all div elements with class 'quiz-item'
        var divs = document.querySelectorAll('.quiz-item');
        
        // Remove 'selected' class from all divs
        divs.forEach(function(div) {
            div.classList.remove('active');
        });

        // Add 'selected' class to clicked div
        divElement.classList.add('active');

        // Get the radio button element
        var radioButton = document.getElementById(radioButtonId);
        
        // Trigger click event on the radio button
        radioButton.click();
    }
    function playAudio(audioSrc) {
      console.log(audioSrc,'audioSrc')
        var audio = new Audio(audioSrc);
        audio.play();
    }
</script>
<?php 
	

}


include('footer.php');
?>

  <script src="js/hyperaudio-lite.js"></script>
  <script src="js/hyperaudio-lite-extension.js"></script>
   
  <script src="js/caption.js"></script>
  <script>
   

  // minimizedMode is still experimental - it aims to show the current words in the title, which can be seen on the browser tab.
  // let minimizedMode = false;
  // let autoScroll = true;
  // let doubleClick = false;
  // let webMonetization = false;
  // let playOnClick = false;

  // new HyperaudioLite("hypertranscript", "hyperplayer", minimizedMode, autoScroll, doubleClick, webMonetization, playOnClick);

  // // Override scroll parameters
  // //ht1.setScrollParameters(<duration>, <delay>, <offset>, <container>);

  // // this should create captions  
  // let cap1 = caption();
  // cap1.init("hypertranscript", "hyperplayer", '37' , '21'); // transcript Id, player Id, max chars, min chars for caption line
  
  </script>
