<h3 class="flow-text">Convert price of your favorite cryptocurrency</h3>
<?php 
    $amount = isset($_GET['amount']) ? $_GET['amount'] : 1;
    $convertcoin = isset($_GET['convert']) ? $_GET['convert'] : 'bitcoin';

    use Codenixsv\CoinGeckoApi\CoinGeckoClient;
    $client = new CoinGeckoClient(); 

    try{
        $data = $client->coins()->getCoin($convertcoin, ['tickers' => 'false', 'market_data' => 'false']);
        $pricebtc = $client->simple()->getPrice($convertcoin, Site::currencyOn())[$convertcoin][Site::currencyOn()];
    }catch(Exception $e){
        $data = $client->coins()->getCoin('bitcoin', ['tickers' => 'false', 'market_data' => 'false']);
        $pricebtc = $client->simple()->getPrice('bitcoin', Site::currencyOn())['bitcoin'][Site::currencyOn()];
        echo '<div class="w100 flow-text flex-center" style="margin: 20px 0;">
                <p class="flex-center" style="margin: 0 3px;"> <i style="color:black;" class="material-icons">error</i>Essa moeda não foi encontrada</p>
            </div>';
    }
    
?>
<div class="ad w100 flex-center">
    <!-- anuncio -->
</div>

<p style="text-align:left;"><?php //echo '<pre>';print_r($data); echo '</pre>';?></p>
<div class="convertbox w100 flex-center direction-row">
    <div class="card w100 flex-center direction-row h100" style="flex-wrap:nowrap">
        
        <div class="selectcoin w33 h100 flex-center direction-row" style="flex-wrap:nowrap">
            <div class="inside">
                <div class="coininfo flex-center direction-row" coinid="<?php echo $data['id']?>">
                    <img class="avatar-img" style="width:20px" src="<?php echo $data['image']['large'];?>">
                    <span style="margin:0 3px;"><?php echo strtoupper($data['symbol']);?></span>
                    <i style="color:black;" class="material-icons">arrow_drop_down</i>
                </div>
            </div>
            <div class="tabopen flex-center direction-column notdisplay">
                <div class="list w100">
                    <div class="listopen w100 flex-center direction-row" style="flex-wrap:nowrap">
                        <input type="text" placeholder="Find" name="searchcrypto">
                    </div>
                    <div class="listinside">              
                        <?php 
                            $coins = $client->coins()->getMarkets(Site::currencyOn());
                            foreach($coins as $key => $value){
                                echo '<div title="'.strtoupper($value['id']).'" coinid="'.$value['id'].'" class="listopen cripto w100 flex-center direction-row">
                                        <img class="avatar-img" style="width:20px" src="'.$value['image'].'">
                                        <p>'.substr(strtoupper($value['symbol']),0, 6).'</p>
                                    </div>';
                                if($key == 30){break;}
                            }
                        ?>
                    </div>  
                </div>
            </div>
        </div>
        
        <div class="input-field flex-center direction-column">
          <input id="coinamount" type="text" class="coinamount" value="<?php echo $amount?>">
          <span class="helper-text">1 <?php echo strtoupper($data['symbol']);?> =  <?php echo sprintf('%.6f', $pricebtc) ?> <?php echo strtoupper(Site::currencyOn())?></span>
        </div>
    </div>

    <div class="swapbutton"><i style="color:white;" class="material-icons">swap_horiz</i></div>

    <?php 
        $currency =json_decode(file_get_contents('config.json'), true);
    ?>

    <div class="card w100 flex-center direction-row h100" style="flex-wrap:nowrap">
        <div class="selectcoin w33 h100 flex-center direction-row" style="flex-wrap:nowrap">
            <div class="inside">
                <div class="coininfo flex-center direction-row">
                    <img style="width:20px;" src="<?php echo BASE.$currency['suportedCurrencys'][Site::currencyOn()]['image']?>">
                    <span style="margin:0 3px;"><?php echo strtoupper($currency['suportedCurrencys'][Site::currencyOn()]['name']) ?></span>
                    <i style="color:black;" class="material-icons">arrow_drop_down</i>
                </div>
            </div>
            <div class="tabopen flex-center direction-column notdisplay">
                <div class="list w100" style="overflow-y:auto;">
                    <?php 
                    
                        foreach($currency['suportedCurrencys'] as $key => $value){
                            echo '<div title="'.strtoupper($value['id']).'" fiatid="'.$value['id'].'" class="listopen fiat w100 flex-center direction-row">
                                        <img style="width:20px" src="'.$value['image'].'">
                                        <p>'.substr(strtoupper($value['name']),0, 6).'</p>
                                    </div>';
                        }
                    
                    ?>
                    
                </div>
            </div>
        </div>
        <div class="input-field fiat flex-center direction-column">
          <input id="fiatamount" type="text" class="fiatamount" value="<?php echo $amount*$pricebtc; ?>">
          <span class="helper-text">1 <?php echo strtoupper(Site::currencyOn() .' = ' .sprintf('%.6f',(1 / floatval($pricebtc)))).' '.strtoupper($data['symbol']);?></span>
        </div>
    </div>


<?php 
    $client = new CoinGeckoClient();
    $coins = $result = $client->coins()->getMarkets('usd');
?>
<p class="flow-text w100 flex-center" style="background:var(--p-color); padding:10px 0; margin:20px 0; color:white; border-radius:3px;">Markets</p>
<div class="containermain-listmarkets flex-center direction-row">
<?php foreach($coins as $key => $value){ 
    $changeprice24hr = round(floatval($value['price_change_percentage_24h']),2);
    $valorizacao =  $changeprice24hr >= 0 ? true : false ;
    
    ?>
    <div coinname="<?php echo $value['id']?>" class="container-listmarkets flex-center direction-column <?php if($valorizacao){echo 'greencard';}?>"  style="flex-wrap:unset;">
        <div class="image" style="margin:10px 0;">
            <img class="avatar-img" style="width:50px;" src="<?php echo $value['image'];?>">
        </div>
        <div class="flow-text">
            <p style="font-size: medium;"><?php echo $value['name']?></p>
            <p style="font-size: xx-large;">$<?php echo round($value['current_price'],5)?></p>
            <span style="font-size: medium;"><?php if($valorizacao){echo '+';} echo $changeprice24hr?>%</span>
        </div>
        <?php //print_r($coins);?>
    </div>
    <?php
    if($key == 9){break;}
} ?>
</div>

