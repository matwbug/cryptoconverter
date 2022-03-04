<html>
    <head>
        <title><?php echo $this->info['titulo'];?></title>
        <meta name="description" content="<?php echo $this->info['desc'];?>">
        <meta name="keywords" content="<?php echo $this->info['tags'];?>">
        <meta name="author" content="matwcode">
        <link rel="shortcut icon" href="<?php echo BASE ?>favicon.ico">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE;?>views/styles/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE;?>views/styles/materialize.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <BASE base="<?php echo BASE?>">
        <!-- scripts -->
        <script src="<?php echo BASE?>js/jquery.min.js"></script>
        <script src="<?php echo BASE?>js/functions.js"></script>
        <!-- ----- -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9262116885905351"
        crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="navbar-up flex-center direction-row" style="justify-content: space-between;">
            <i style="color:black; font-size:40px;" class="menubtn material-icons">menu</i>
            <div class="flex-center direction-row logo" style="margin:5px 0;">
                <div id="logo"></div>
                <span style="margin: 0 10px;"class="left flow-text">CryptoConverter</span>  
            </div>
            <div class="navchooses flex-center direction-row">
                <!--
                <select name="language" style="margin:3px 10px; width:150px;" class="browser-default">
                    <option value="english" selected>English</option>
                    <option value="portuguese">Português</option>
                    <option value="spanish">Español</option>
                </select>
                -->
                <div class="select">
                    <select name="currency" style="margin:3px 10px; width:100px;" class="browser-default">
                        <?php 
                            $data =json_decode(file_get_contents('config.json'), true);
                            foreach($data['suportedCurrencys'] as $key => $value){
                                $selected = Site::currencyOn() == strtolower($value['id']) ? 'selected' : '';
                                echo '<option '.$selected.' value="'.$value['id'].'">'.strtoupper($value['name']).'</option>';
                            }
                        ?>
                    </select>
                </div>
                
            </div>

         </div>
        <!--<div class="navbar-down flex-center"></div> -->

        <div class="maincontent flex-center direction-column" style="justify-content:flex-start; flex-wrap:nowrap;">
            <div class="loadingio-spinner-rolling-5ntybuno3cg ajaxLoading notdisplay">
                <div class="ldio-orghusu292g">
                <div></div>
            </div>
        </div>
        
        
