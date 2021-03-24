<br>

<div class="row">

    <div class="col-md-12 text-center">
        <img class="w-50" src="<?=base_url("assets/images/l2.png") ?>">
    </div>

    <br>

    <div class="col-md-12">
        <div class="chartDoughnut">
            <canvas id="myChart"></canvas>
        </div>
    </div>

</div>

<script>

    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
// The type of chart we want to create
        type: 'doughnut',

// The data for our dataset
        data: {
            datasets: [{
                data: [<?php echo $cp;?>, <?php echo $sp;?>, <?php echo $mp;?>,<?php echo $hp;?>],
                backgroundColor: ["#FE9028", "#9b9cb5", "#37A2E9", "#FE6383"]
            }],
            labels: [
                'CP',
                'SP',
                'MP',
                'HP'
            ]


        },

//Configuration options go here
        options: {}
    });
</script>


<?php

