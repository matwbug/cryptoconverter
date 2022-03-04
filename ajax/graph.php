<?php 

    use Codenixsv\CoinGeckoApi\CoinGeckoClient;
    error_reporting(E_ALL ^ E_NOTICE);

    session_start();
    $request = $_POST['request'];
    $token = @$_POST['token'];
    include('../class/Site.php');
    require('../vendor/autoload.php');
    include('../config.php');


    if(!\Site::validarCSFRToken($token)){
        $data['msg'] = 'Aconteceu algum erro, contate administração';
        $data['sucesso'] = false;
        die(json_encode($data));
    }

    if(isset($request)){
        $client = new CoinGeckoClient(); 

        if($request == 'graphconsult'){

            
        }
    }
    die(json_encode($data));
    
?>