
<div style="height: 400px; width: 400px">
<canvas id="myChart" width="10" height="10"></canvas>
</div>
<script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data:{
            labels:[
                    @foreach($data['date'] as $d['date'])
                '{{ $d['date'] }}',
                    @endforeach
            ],
            datasets: [{
                label: '# of DC created ',
                data: [
                    @foreach($data['count'] as $d['count'])
                    '{{ $d['count'] }}',
                    @endforeach
                ],

                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>
