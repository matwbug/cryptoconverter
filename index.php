<?php 
    include('config.php'); //incluindo arquivo de configurações globalmente
    
    $autoload = function($class){
        $class = str_replace('\\','/',$class);
        if(file_exists($class.'.php')){ // caso existir o arquivo da class inclua ele
            include($class.'.php');
        }
        if(file_exists('class/'.$class.'.php')){
            include('class/'.$class.'.php');
        }
    };

    spl_autoload_register($autoload);
    require('vendor/autoload.php');

    $app = new Application();
    $app->run();
?>

<script>
    sessionStorage.setItem('token','<?php echo Site::gerarCSFRToken(); ?>');
</script>