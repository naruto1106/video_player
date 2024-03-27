<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
   <link rel="icon" sizes="32x32" href="./assets/img/logos1.png">
<link rel="stylesheet" href="css/hyperaudio-lite-player.css"> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.5.0/velocity.js"></script>
  <script src="https://platform.twitter.com/widgets.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Lexend:wght@100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">  
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Lexend+Deca:wght@100..900&family=Lexend:wght@100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<title>FrameBright Explorer</title>
 

<style>  .explorerbutton {
            margin: 5px;
            font-size: 25px;
        }

        .header-navbar {
            border: 1px solid #FD7500;
            background-color: #FD7500;
            border-radius: 30px;
            padding-left: 40px;
            padding-right: 40px;
            flex-grow: 0 !important;
        }

        .menu-item {
            color: white;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .star_img {

            margin-top: -10px;
            margin-left: 10px;
            margin-right: 10px;
        }

        .header_avartar {
            width: 60px;
            height: 60px;
			border-radius: 15px;
        }

        .logos {
            height: 60px;
            width: auto;
        }

        .nav_item_padding {
            margin-right: 30px !important;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dropdown-menu[data-bs-popper] {
    top: 186% !important;
    left: -76px !important;
    margin-top: var(--bs-dropdown-spacer);
}
  .dropdown_avatar {
            border: 0px !important;
            background: none !important;
        }
		
        @media (min-width: 965px) {
            .score_avatar {
                position: relative;

            }

            .bottom_header_container {
                display: none;
                position: relative;
            }

            .star_st {
                color: #F5B434;
                font-size: 22px;
                font-weight: 700;
            }

            .name_st {
                font-size: 20px;
                font-weight: 300;
                color: gray;
                font-family: "Red Hat Display";
                font-weight: 700;
            }
			 .score_sh {
            padding-right: 25px !important;
            padding-left: 25px !important;
            border-radius: 30px !important;
            padding-top: 11px !important;
            padding-bottom: 11px !important;
        }
		.star_img_st{
			width:30px;
			height:30px;
		}
        }

        @media (max-width: 965px) {
            .header-navbar {

                flex-grow: 1 !important;
            }

            .score_avatar {
                position: absolute;
                top: 80px;
                right: 0px;
				z-index:999;
            }

            .header_avartar {
                width: 50px;
                height: 50px;
				border-radius: 12px;
            }

            .bottom_header_container {
                position: fixed;
				display: unset;
				left: 50%;
				transform: translate(-50%, -50%);
				z-index: 999;
				bottom: 10px;
				z-index: 999;
            }

            .collapse1 {
                display: flex !important;
                flex-basis: auto;

            }

            .navbar-expand-lg .navbar-nav {
                flex-direction: row;
            }

            .score_sh {
                padding-right: 20px !important;
                padding-left: 20px !important;
                border-radius: 30px !important;
                padding-top: 8px !important;
                padding-bottom: 8px !important;
            }

            .star_st {
                color: #F5B434;
                font-size: 18px;
                font-weight: 700;
            }

            .name_st {
                font-size: 18px;
                font-weight: 300;
                color: gray;
            }
			.star_img_st{
			width:25px;
			height:25px;
		}
        }
</style>
</head>
<body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <?php
        $_SESSION['APP'] = false;
        if (isset($_REQUEST['return']) && str_contains($_REQUEST['return'], 'render')){
            $_SESSION['APP'] = true;
        }
        if ($_SESSION['APP'] == false ){
    ?>

      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid" style="position: relative;">

            <a class="navbar-brand" href="/"> <img src="./assets/img/logos1.png" class="logos" alt="logo"> </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#3navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <!-- <span class="navbar-toggler-icon"></span> -->
                <img src="./assets/icon/gear.svg" alt="Bootstrap" width="30" height="30">
            </button>
            <div class="collapse navbar-collapse header-navbar " id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item nav_item_padding">

                        <a class="nav-link  menu-item" aria-current="page" href="/">
                            <img src="./assets/icon/home.svg" alt="Bootstrap" width="30" height="24">
                            Home</a>
                    </li>
                    <li class="nav-item nav_item_padding">
                        <a class="nav-link menu-item" href="activities.php">
                            <img src="./assets/icon/activities.svg" alt="Bootstrap" width="30" height="24">
                            ACTIVITIES</a>
                    </li>
                    <li class="nav-item nav_item_padding">
                        <a class="nav-link menu-item" href="my-gallery.php">
                            <img src="./assets/icon/ImageSquare.svg" alt="Bootstrap" width="35px" height="28px">
                            MY POSTERS</a>
                    </li>

                    <li class="nav-item" style="display: flex;">
                        <a class="nav-link menu-item" href="star-center.php">
                            <img src="./assets/icon/Star.svg" alt="Bootstrap" width="30px" height="24px">
                            MY STARS</a>
                    </li>
                </ul>

            </div>

            <div class="score_avatar">
			 <?php
 
if(isset($explorerType) && $explorerType == "kid") {
	$kid=$database->kids->findOne(['_id'=>new MongoDB\BSON\ObjectId($explorerId)]);
 $stars=getKidStars($explorerId);
	//if($stars) { echo "<img src='".$kid['avatar']."' style='max-width:80px'> ".$kid['name'].": <a href=star-center.php>".$stars." Stars</a>"; }
}?> 

     

    <?php
        }
    ?>
                <div class="shadow score_sh pl-5 bg-body-tertiary rounded d-inline">
				<a href=star-center.php style="text-decoration: none;">
				<span class="name_st"><?php
				
					if(isset($stars)){
						echo $kid['name'];
					}
					
				?></span>
				<img src='./assets/icon/star_1.png' class='star_img star_img_st'  >
                    
                    <span class="star_st">
					<?php
					 if(isset($stars)){
						echo $stars==""?0:$stars;
					}
					?>
					</span>
					</a>
                </div>
                <div class="d-inline dropdown">
				
				
				<button class="dropdown_avatar" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                       <?php
				 if(isset($stars)){
				   echo "<img src='".$kid['avatar']."' class='m-3 header_avartar'>";
				  }
				 else{
				   echo "<img src='./assets/img/avarta.png' class='m-3 header_avartar'>";
				 }
				?>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="explorer.php">Change Explorer</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>

                    </ul>
				
				</div>
            </div>

            <div class="bottom_header_container">
                <div class="collapse1 navbar-collapse header-navbar " id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item nav_item_padding">

                            <a class="nav-link  menu-item" aria-current="page" href="/">
                                <img src="./assets/icon/home.svg" alt="Bootstrap" width="30" height="24">
                            </a>
                        </li>
                        <li class="nav-item nav_item_padding">
                            <a class="nav-link menu-item" href="activities.php">
                                <img src="./assets/icon/activities.svg" alt="Bootstrap" width="30" height="24">
                            </a>
                        </li>
                        <li class="nav-item nav_item_padding">
                            <a class="nav-link menu-item" href="my-gallery.php">
                                <img src="./assets/icon/ImageSquare.svg" alt="Bootstrap" width="35px" height="28px">
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-item" href="star-center.php">
                                <img src="./assets/icon/Star.svg" alt="Bootstrap" width="30px" height="24px">
                            </a>
                        </li>
                    </ul>

                </div>
            </div>

        </div>
    </nav>
	

   <div class="main-content111" style="position:relative; " >
        <div class="container" id="myContainer">

