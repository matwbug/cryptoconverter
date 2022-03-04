<style>
    #myChart{
        width:200px!important;height:100%!important;
    }
</style>

<script src="<?php echo BASE ?>js/sunflower.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php 
    use Codenixsv\CoinGeckoApi\CoinGeckoClient;

    $client = new CoinGeckoClient();
    $result = $client->coins()->getMarketChartRange('bitcoin', Site::currencyOn(), time() - (60*60), time());
    $values = [];
    $times = [];
    foreach($result as $key => $value){
        foreach($value as $k => $val){
            $values[] = floatval($val[1]);
            $times[] = floatval($val[0]);
        }
    }
?>



<canvas id="graphcoin"></canvas>
<script>
    const ctx = document.getElementById('graphcoin').getContext('2d');
</script>

<script>
        function converterTime(time){
            var date = new Date(parseInt(time));
            return date.getHours()+':'+date.getMinutes();
        }
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    <?php 
                        foreach($times as $k => $val){
                            echo 'converterTime('.$val.'),';
                        }
                    ?>
                ],
                datasets: [{
                    label: 'Preço ' + location.href.split('/')[5].toUpperCase(),
                    data: [
                        <?php 
                            foreach($values as $key => $values){
                                echo ($values).',';
                            }
                        ?>
                    ],
                    backgroundColor: 'transparent',
                    borderColor: 'rgb(75,0,130)',
                    borderWidth: 5
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    }
                },
                title:{
                    display: true,
                    fontSize:20,
                    text: "GRÁFICO "+ location.href.split('/')[5].toUpperCase(),

                }
            }
        });
</script>