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
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Lexend:wght@100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>FrameBright Explorer</title>
 

<style>
.explorerbutton { margin:5px; font-size: 25px; }
    
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
        }

        .score_sh {
            padding-right: 30px !important;
            padding-left: 30px !important;
            border-radius: 30px !important;
            padding-top: 11px !important;
            padding-bottom: 11px !important;
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
        }

        .star_img {

            margin-top: -10px;
            margin-left: 10px;
            margin-right: 10px;
        }

        .header_avartar {
            width: 70px;
            height: 70px;
        }

        .logos {
            height: 60px;
            width: auto;
        }
		.nav_item_padding{
			margin-right:30px !important;
		}
    @media screen and (max-width: 768px) {
        .explorerbutton{
           font-size: 18px;
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
       
    ?>
<body>
     <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"> <img src="./assets/img/logos1.png" class="logos" alt="logo"> </a>

        </div>
    </nav>
	
    <div class="main-content111" style="position:relative;" >
        <div class="container">
