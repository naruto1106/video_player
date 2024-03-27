<?php
 $_OVERRIDE=true;
include('db.php');
$_SESSION['explorer']=$_REQUEST['id'];
if(isset($_REQUEST['return'])) {
	header("Location: ".$_REQUEST['return']);
} else {
	header("Location: index.php");
}