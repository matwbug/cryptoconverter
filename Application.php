<?php 
    class Application{
        public function run(){
            /*
            if(isset($_GET['logout'])){
                Site::logout();
            }
            */
            $url = Site::isHomologation() ? explode('/',Site::getCurrentUrl())[2] : explode('/',Site::getCurrentUrl())[1];
            $url = explode('?',$url)[0];
            
            $url = $url == '' ? 'Home' : $url;
            $url.="Controller";
            

            if(file_exists('controllers/'.$url.'.php')){
                $className = 'controllers\\'.$url;
                $controller = new $className();
                $controller->index();
            }else{
                $className = 'controllers\\ErroController';
                $controller = new $className();
                $controller->index();
            }

            
        }
    }

?>