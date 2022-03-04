<h4 class="flowtext">Cryptocurrencys list</h4>
<div class="listcrypto flex-center direction-row">
    <?php 
        $list = Site::getInfoDBAll('coins');
        foreach($list as $key => $value){
            echo '<div link='.$value['nameid'].'/ class="item redirect w100 flex-center direction-column">
                        <div class="img"><img src="'.$value['image'].'"></div>
                        <p style="margin:10px 0; font-weight:bold;">'.str_replace('-',' ', strtoupper($value['nameid'])).'</p>
                    </div>';
            if($key == 30){break;}
        }
    ?>
    
</div>