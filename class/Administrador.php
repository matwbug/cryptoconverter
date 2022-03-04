<?php 
    class Administrador{
        public static function sessionAdminIsTrue(){
            if(isset($_COOKIE['loginToken'])){
                $sql = MySql::conectar()->prepare("SELECT * FROM `sessionlogin.token` WHERE `token` = ? AND `ip.user` = ?");
                $sql->execute(array($_COOKIE['admin_sessionToken'], Site::getIP()));
                if($sql->rowCount() == 1){
                    return true;
                }else{
                    setcookie('admin_sessionToken', false, time() + (-1),'/');
                    return false;
                }
            }else{
                return false;
            }
        }
    }
?>