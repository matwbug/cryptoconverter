<?php 
    class Site{
        public static function getCurrentUrl(){
            return $_SERVER['REQUEST_URI'];
        }

        public static function isHomologation(){
            $base = explode('/',Site::getCurrentUrl())[1]  == 'cryptoconverter' ? true : false;
            return $base; 
        }
        public static function checkManutencao(){
            $json_object = file_get_contents('config.json');
            $data = json_decode($json_object, true);
            if($data['manutencao'] == true){
                if(Administrador::sessionAdminIsTrue()){
                    return false;
                }else{
                    return true;
                }
            }else{
                return false;
            }
        }

        public static function gerarCSFRToken(){
            if(!isset($_SESSION['token'])){
                $_SESSION['token'] = bin2hex(random_bytes(32));
            }
            return $_SESSION['token'];
        }

        public static function validarCSFRToken($token){
            if(!isset($_SESSION['token'])){
                return false;
            }
            
            if($_SESSION['token'] != $token){
                return false;
            }
            return true;
        }

        public static function getIP(){
            foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
                if (array_key_exists($key, $_SERVER) === true) {
                    foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                            return $ip;
                        }
                    }
                }else{
                    return 'Indefinido'; //TIRAR ISSO NO DEPLOY POR CAUSA DO LOCALHOST
                }
            }
        }

        public static function loadJs($vers,$path,$page,$arq){
            if(is_array($page)){$pages = $page;}
            
            if($path == 'admin'){$path = ADMIN;}else{$path = BASE;}
            $url = explode('/',strtok(self::getCurrentUrl(),'?')); 
            $allPages = $page == 'all' ? $allPages = true : $allPages = false; 
            $base = $url[1] == 'db' ? 'local' : 'online';
            if($base == 'local'){$key = $vers == 'admin' ? 3 : 2;}
            else{$key = $vers == 'admin' ? 2 : 1;}
            if( $allPages || $url[$key] == $page || in_array($url[$key], $pages)){
                echo '<script type="text/javascript" src='.$path.'JS/'.$arq.'.js></script>';
            }
        }

        public static function floorValue($value){
            $value = floatval($value);
            $value = round($value, 10);
            return $value;
        }
        

        public static function currencyOn(){
            $currencyon = isset($_COOKIE['currency']) ? strtolower($_COOKIE['currency']) : '';
            $curr = ['brl','usd','eur'];
            if(!in_array($currencyon,$curr)){
                setcookie('currency','usd', time() + (86400 * 30), '/');
            }
            return $_COOKIE['currency'];
        }

        public static function getInfoDB($db,$query = null){
            $query  = $query != null ? "SELECT * FROM `$db` WHERE $query" : "SELECT * FROM `$db`";
            $sql = MySql::conectar()->prepare($query);
            $sql->execute();
            if($sql->rowCount() >= 1){
                return $sql->fetch();
            }
            return false;
        }
        public static function getInfoDBAll($db,$query = null){
            $query  = $query != null ? "SELECT * FROM `$db` WHERE $query" : "SELECT * FROM `$db`";
            $sql = MySql::conectar()->prepare($query);
            $sql->execute();
            if($sql->rowCount() >= 1){
                return $sql->fetchAll();
            }
            return false;
        }

        public static function getRowCountDB($db,$query = null){
            $query  = $query != null ? "SELECT * FROM `$db` WHERE $query" : "SELECT * FROM `$db`";
            $sql = MySql::conectar()->prepare($query);
            $sql->execute();
            return $sql->rowCount();
        }

        public static function removerAcentos($str){
            $caracteres_sem_acento = array(
                '??'=>'S', '??'=>'s', '??'=>'Dj','??'=>'Z', '??'=>'z', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A', '??'=>'A',
                '??'=>'A', '??'=>'A', '??'=>'C', '??'=>'E', '??'=>'E', '??'=>'E', '??'=>'E', '??'=>'I', '??'=>'I', '??'=>'I',
                '??'=>'I', '??'=>'N', '??'=>'N', '??'=>'O', '??'=>'O', '??'=>'O', '??'=>'O', '??'=>'O', '??'=>'O', '??'=>'U', '??'=>'U',
                '??'=>'U', '??'=>'U', '??'=>'Y', '??'=>'B', '??'=>'Ss','??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a', '??'=>'a',
                '??'=>'a', '??'=>'a', '??'=>'c', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'e', '??'=>'i', '??'=>'i', '??'=>'i',
                '??'=>'i', '??'=>'o', '??'=>'n', '??'=>'n', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'o', '??'=>'u',
                '??'=>'u', '??'=>'u', '??'=>'u', '??'=>'y', '??'=>'y', '??'=>'b', '??'=>'y', '??'=>'f',
                '??'=>'a', '??'=>'i', '??'=>'a', '??'=>'s', '??'=>'t', '??'=>'A', '??'=>'I', '??'=>'A', '??'=>'S', '??'=>'T',
            );
            return preg_replace("/[^a-zA-Z0-9]/", "", strtr($str, $caracteres_sem_acento));
        }



        
        
    }

?>