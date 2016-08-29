<style>
    .ui-datepicker {
        background-color: #fff;
        border: 1px solid #66AFE9;
        border-radius: 4px;
        box-shadow: 0 0 8px rgba(102,175,233,.6);
        display: none;
        margin-top: 4px;
        padding: 10px;
        width: 240px;
    }
    .ui-datepicker a,
    .ui-datepicker a:hover {
        text-decoration: none;
    }
    .ui-datepicker a:hover,
    .ui-datepicker td:hover a {
        color: #2A6496;
        -webkit-transition: color 0.1s ease-in-out;
        -moz-transition: color 0.1s ease-in-out;
        -o-transition: color 0.1s ease-in-out;
        transition: color 0.1s ease-in-out;
    }
    .ui-datepicker .ui-datepicker-header {
        margin-bottom: 4px;
        text-align: center;
    }
    .ui-datepicker .ui-datepicker-title {
        font-weight: 700;
    }
    .ui-datepicker .ui-datepicker-prev,
    .ui-datepicker .ui-datepicker-next {
        cursor: default;
        font-family: 'Glyphicons Halflings';
        -webkit-font-smoothing: antialiased;
        font-style: normal;
        font-weight: normal;
        height: 20px;
        line-height: 1;
        margin-top: 2px;
        width: 30px;
    }
    .ui-datepicker .ui-datepicker-prev {
        float: left;
        text-align: left;
    }
    .ui-datepicker .ui-datepicker-next {
        float: right;
        text-align: right;
    }
    .ui-datepicker .ui-datepicker-prev:before {
        content: "\e079";
    }
    .ui-datepicker .ui-datepicker-next:before {
        content: "\e080";
    }
    .ui-datepicker .ui-icon {
        display: none;
    }
    .ui-datepicker .ui-datepicker-calendar {
        table-layout: fixed;
        width: 100%;
    }
    .ui-datepicker .ui-datepicker-calendar th,
    .ui-datepicker .ui-datepicker-calendar td {
        text-align: center;
        padding: 4px 0;
    }
    .ui-datepicker .ui-datepicker-calendar td {
        border-radius: 4px;
        -webkit-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
        -moz-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
        -o-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
        transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
    }
    .ui-datepicker .ui-datepicker-calendar td:hover {
        background-color: #eee;
        cursor: pointer;
    }
    .ui-datepicker .ui-datepicker-calendar td a {
        text-decoration: none;
    }
    .ui-datepicker .ui-datepicker-current-day {
        background-color: #4289cc;
    }
    .ui-datepicker .ui-datepicker-current-day a {
        color: #fff
    }
    .ui-datepicker .ui-datepicker-calendar .ui-datepicker-unselectable:hover {
        background-color: #fff;
        cursor: default;
    }
</style>

<?php
        //dd($data);
        ?>

<div style="align-items: center;">

    <div style="float: left;
  text-align: right;
  display: inline" class="ui-datepicker">
        <span>Please choose the dates for rendering data</span><br>
        <input class="date" type="date" name="startDate" id="start">Start Date<br>
        <input type="date" name="lastDate" id="end">Last Date<br>
        <button id="submit">submit</button>
    </div>

    <div style="height: 400px; width: 400px  ;float: left;
  text-align:left;
  display: inline">
        <canvas id="myChart" width="10" height="10"></canvas>
    </div>

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
                label: '# of SO processed',
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

    $('#submit').click(function () {

        var startdt = $('#start').val();
        var enddt = $('#end').val();

        $('#graphview').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/reports/so?start=" + startdt+ "&end=" + enddt, function (data, status) {

            $('#graphview').html(data);


        });

        return true;
    });

</script>
