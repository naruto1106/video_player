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
header("Location:explorer.php?return=/view-poster.php?id=".$_REQUEST['id']);
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

$posterId=new ObjectId($_REQUEST['id']);
$poster=$database->contentPackMedia->findOne(['_id'=>$posterId,'deleted'=>['$ne'=>true],'status'=>'live']);
if(!$poster) {
	header("Location: index.php"); die();
}

$mediaItem = $database->contentPackMedia->findOne(["_id" => $poster['_id']]);   

?>

<!-- <H2><?=$poster['title'];?></h2> --> 
<?php 

$useragent=$_SERVER['HTTP_USER_AGENT'];

//if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
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
?>

 
	


<div class="questionImage" >
      <img src="<?=$poster['hImage']['url'];?>" style='width: 100%; height: 100%; object-fit: cover;'>
</div>



<?php
if(isset($mediaItem['audioFile']) && $mediaItem['audioFile'] != "" && (!isset($mediaItem['hyperaudio']) || $mediaItem['hyperaudio'] === false)) { 
	?>
	<div class="container lessonContent d-flex justify-content-center">
		<?=generateMediaEmbedTag($mediaItem['audioFile']);?>
	</div>	
	
	<?php } ?>

	<?php
		if(isset($mediaItem['hyperaudio']) && $mediaItem['hyperaudio']) {
			?>
			<div class="d-flex justify-content-center align-items-center">
			<?php if(isset($mediaItem['videoFile']) && $mediaItem['videoFile'] != "") { ?>
			<video id="hyperplayer" class="hyperaudio-player lessonContent"  src="<?=$mediaItem['videoFile'];?>" type="" controls playsinline>
				<track id="hyperplayer-vtt" label="English" kind="subtitles" srclang="en" src="<?=$mediaItem['videoFile'];?>">
			</video>
			<?php } else { ?>
			<?php if(isset($mediaItem['audioFile']) && $mediaItem['audioFile'] != "") { ?>
			<audio id="hyperplayer" class="hyperaudio-player lessonContent"  src="<?=$mediaItem['audioFile'];?>" type="" controls></audio>
			<?php } ?>
			<?php } ?>
			</div>
			<div class="container lessonContent">
			<div id="hypertranscript" class="hyperaudio-transcript " style="overflow-y:scroll; height:fit-content; position:relative; border-style:dashed; border-width: 1px; border-color:#999; padding: 20px; margin-top: 10px; ">
				<?php echo $mediaItem['hyperaudiots']; ?>
			</div>
			</div>
			
			
	<?php } ?>

	
<?php
	if(isset($poster['lessonContent'])) {?>
		<div class="container lessonContent">
			<?=nl2br($poster['lessonContent']);?> 
		</div>	
<?php } ?>

<?php
	if(isset($mediaItem['videoFile']) && $mediaItem['videoFile'] != "" && (!isset($mediaItem['hyperaudio']) || $mediaItem['hyperaudio'] === false)) { 
	?>
	<div class="container lessonContent">
		<?=generateMediaEmbedTag($mediaItem['videoFile']);?>
	</div>
	
<?php } ?> 



<div class="poster-start-activity">
	<?php
	// if($poster['interactive'] || (isset($poster['lessonContent']) && $poster['lessonContent'] != "")) { 
		if(activityComplete($explorerType,$explorerId,$poster['_id'])) {
			echo "Activity Complete";
		} else {
			echo "<a style='text-decoration:none; color: white; display: flex;justify-content: center; align-items: center;' href=quiz.php?id=".(string)$poster['_id'].">Start Activity";
			?>
			<?php  
				if(isset($kid['starSystem']) && $kid['starSystem'] && isset($poster['stars'])) { ?>
				&nbsp;<img src="../assets/img/Star.png" style="width: 22px;" alt="star"><?=$poster['stars'];?><?php } ?>
			<?php
			echo "</a>";
		}
	// }  
	?>
	  
</div>
<div class="mobile-menu-position"></div>
<script>
	// Function to handle resizing of the image
    // function resizeImage() {
    //     var image = document.getElementById('poster-image');
    //     if (window.innerWidth < 768) {
    //         image.src = "<?=$poster['vImage']['url'];?>";
    //         image.style.height = "100%";
    //         image.style.objectFit = "cover";
    //     } else {
    //         image.src = "<?=$poster['hImage']['url'];?>";
    //         image.style.height = "100%";
    //         image.style.objectFit = "cover";
    //     }
    // }

    // // Call the function initially when the page loads
    // window.addEventListener('load', resizeImage);

    // // Check viewport width and change image orientation when window is resized
    // window.addEventListener('resize', resizeImage);

</script>
<?php
include("footer.php");

?>

<script src="js/hyperaudio-lite.js"></script>
  <script src="js/hyperaudio-lite-extension.js"></script>
   
  <script src="js/caption.js"></script>
  <script>
   

//   minimizedMode is still experimental - it aims to show the current words in the title, which can be seen on the browser tab.
  let minimizedMode = false;
  let autoScroll = true;
  let doubleClick = false;
  let webMonetization = false;
  let playOnClick = false;

  new HyperaudioLite("hypertranscript", "hyperplayer", minimizedMode, autoScroll, doubleClick, webMonetization, playOnClick);

  // Override scroll parameters
  //ht1.setScrollParameters(<duration>, <delay>, <offset>, <container>);

  // this should create captions  
  let cap1 = caption();
  cap1.init("hypertranscript", "hyperplayer", '37' , '21'); // transcript Id, player Id, max chars, min chars for caption line
  
  </script>