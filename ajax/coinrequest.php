<?php 
    use Codenixsv\CoinGeckoApi\CoinGeckoClient;
    error_reporting(E_ALL ^ E_NOTICE);

    session_start();
    $request = $_POST['request'];
    include('../class/Site.php');
    require('../vendor/autoload.php');
    include('../config.php');
    
    $token = @$_POST['token'];

    if(!\Site::validarCSFRToken($token)){
        $data['msg'] = 'Aconteceu algum erro, contate administração';
        $data['sucesso'] = false;
        die(json_encode($data));
    }

    if(isset($request)){
        include('../class/MySql.php');
        $data['sucesso'] = true;
        //$data['msg'] = '';
        //$data['redirect'] = '';
        $client = new CoinGeckoClient(); 
        if($request == 'coinchange'){
            
            $coinid = $_POST['coinid'];
            $amount = $_POST['amount'];
            $coins = $client->coins()->getMarkets(Site::currencyOn());
            $coinsA = '';
            foreach($coins as $key => $value){
                $coinsA .=  '<div coinid="'.$value['id'].'" class="listopen cripto w100 flex-center direction-row">
                                <img class="avatar-img" style="width:20px" src="'.$value['image'].'">
                                <p>'.strtoupper($value['symbol']).'</p>
                            </div>';
                if($key == 40){break;}
            }
            $price = $client->simple()->getPrice($coinid, Site::currencyOn());
            $result = $client->coins()->getCoin($coinid, ['tickers' => 'false', 'market_data' => 'false']);
                
            $data['coinchange'] = '<div class="selectcoin w33 h100 flex-center direction-row" style="flex-wrap:nowrap">
                                        <div class="inside">
                                            <div class="coininfo flex-center direction-row" coinid="'.$result['id'].'">
                                                <img class="avatar-img" style="width:20px" src="'.$result['image']['large'].'">
                                                <span style="margin:0 3px;">'.strtoupper($result['symbol']).'</span>
                                                <i style="color:black;" class="material-icons">arrow_drop_down</i>
                                            </div>
                                        </div>
                                        <div class="tabopen flex-center direction-column notdisplay">
                                        <div class="list w100">
                                            <div class="listopen w100 flex-center direction-row" style="flex-wrap:nowrap">
                                                <input type="text" placeholder="Find" name="searchcrypto">
                                            </div>
                                            '.$coinsA.'
                                        </div>
                                    </div>
                                    </div>
                                    
                                    <div class="input-field flex-center direction-column">
                                    <input id="coinamount" type="text" class="coinamount" value="'.$amount.'">
                                    <span class="helper-text">1 '. strtoupper($result['symbol']) .' =  '. sprintf('%.6f',$price[$coinid][Site::currencyOn()]).' '.strtoupper(Site::currencyOn()).'</span>
                                    </div>';
            
            $data['response'] = '<div class="input-field flex-center direction-column">
                                    <input id="fiatamount" type="text" class="fiatamount" value="'.(floatval($price[$coinid][Site::currencyOn()]) * floatval($amount)).'">
                                    <span class="helper-text">1 '.strtoupper(Site::currencyOn()).'  = '.sprintf('%.6f',$price[$coinid][Site::currencyOn()]).' '.strtoupper($result['symbol']).'</span>
                                </div>';

        }else if($request == 'changeamount'){
            $amount = $_POST['amount'];
            $coinid = $_POST['coinid'];
            $request = $client->simple()->getPrice($coinid, Site::currencyOn());
            
            $data['result'] = $_POST['iscrypto'] == true ? sprintf('%.12f',($request[$coinid][Site::currencyOn()] * floatval($amount)))  : sprintf('%.12f',(floatval($amount) / $request[$coinid][Site::currencyOn()]));
        }else if($request == 'searchcrypto'){
            $busca = Site::removerAcentos($_POST['search']);
            $busca = Site::getInfoDBAll('coins', "`nameid` LIKE '%$busca%' OR `symbol` LIKE '%$busca%'");
            $data['result'] = '';
            if($busca){
                foreach($busca as $key => $value){
                    $data['result'] .= '<div title="'.strtoupper($value['nameid']).'" coinid="'.$value['nameid'].'" class="listopen cripto w100 flex-center direction-row">
                                            <img class="avatar-img" style="width:20px" src="'.$value['image'].'">
                                            <p>'.substr(strtoupper($value['symbol']),0, 6).'</p>
                                        </div>';
                    if($key == 20){break;}
                }
            }else{$data['result'] = false;}
            
            /*
            $coins = $client->coins()->getList();
            foreach($coins as $key => $value){
                if(Site::getRowCountDB('coins', '`nameid`="'.$value['id'].'"') == 0){
                    try{
                        $info = $client->coins()->getCoin($value['id'], ['tickers' => 'false', 'market_data' => 'false']);
                        $sql = MySql::conectar()->prepare("INSERT INTO `coins` VALUES(null,?,?,?)");
                        $sql->execute(array($value['symbol'],$value['id'], $info['image']['large']));
                    }catch(Exception $e){}
                }
            }*/

        }else if($request == 'changecurrency'){
            $currency = $_POST['currency'];
            $curr = ['brl','usd','eur'];

            if(!in_array($currency,$curr)){
                setcookie('currency','usd', time() + (86400 * 30), '/');
                $data['sucesso'] = false;
            }else{
                setcookie('currency',$currency, time() + (86400 * 30), '/');
            }
        }
    die(json_encode($data));
    }
?>