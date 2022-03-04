<?php 
    namespace Controllers;
    class HomeController{
        public function __construct(){
            $this->view = new \views\MainView('home',array(
                'titulo'=>'Crypto Converter',
                'desc'=>'Convert and find the price of your favorite cryptocurrencies!',
                'tags'=>'crypto, crypto convert, cryptocurrency, shiba inu, binance, cardano, tron, safemoon, nft, convert, DEFI, elon musk'
            ));
        }
        public function index(){
            $this->view->renderTemplate();
        }
    }
?>