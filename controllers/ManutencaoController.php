<?php 
    namespace Controllers;
    class ManutencaoController{
        public function __construct(){
            $this->view = new \views\MainView('manutencao',array(
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