<!-- Main content -->
<section class="content">
    <!-- Main row --> 

                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-exclamation"></i></span>

                            <div class="info-box-content">
                            <span class="info-box-text">Total Unbil Project</span>
                            <span class="info-box-number"><?php echo number_format($dashboard->total,0,',','.');?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                                
                            
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                     <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="fa fa-file"></i></span>

                            <div class="info-box-content">
                            <span class="info-box-text">Sudah Layak Tagih</span>
                            <span class="info-box-number"><?php echo number_format($dashboard->sudah_layak_tagih,0,',','.');?></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: <?php echo $belum_=($dashboard->sudah_layak_tagih/$dashboard->total)*100;?>%"></div>
                            </div>
                                
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                        <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box bg-aqua">
                            <span class="info-box-icon"><i class="fa fa-file-text-o"></i></span>

                            <div class="info-box-content">
                            <span class="info-box-text">Belum Layak Tagih</span>
                            <span class="info-box-number"><?php echo number_format($dashboard->belum_layak_tagih,0,',','.');?></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: <?php echo $belum_=($dashboard->belum_layak_tagih/$dashboard->total)*100;?>%"></div>
                            </div>
                                <!-- <span class="progress-description">
                                    70% Increase in 30 Days
                                </span> -->
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    <!-- /.info-box -->
                    </div>
                 
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <div id="container" ></div>
                    </div>
                    <div class="col-lg-6">
                        <div id="issue_chart" style="height:300px"></div>
                    </div>
                </div>

                
</section>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script>
$(document).ready(function () {

    Highcharts.setOptions({
        colors: ['#00c0ef', '#f6c811', '#f56954', '#ff6232'],
        navigation: {
            buttonOptions: {
                symbolSize: 12,
                symbolStrokeWidth: 1,
                enabled: true //change to false to hide
            }
        },
        xAxis: {
            labels: {
                style: {
                    color: '#000',
                    letterSpacing: '2px',
                    textTransform: 'uppercase',
                    fontSize: '10px',
                }
            },
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    allowOverlap: true,
                    padding: 0,
                }
            }
        },
        yAxis: {
            labels: {
                style: {
                    color: '#000',
                    fontWeight: '1000',
                    fontSize: '8px'
                },
            },
            title: {
                style: {
                    color: '#000',
                    fontSize: '12px'
                }
            },
            gridLineColor: '#dadce2'
        }
    });
    // Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'pie',
        height: 300,
    },
    title: {
        text: '<b>STATUS UNBIL</b>'
    },
    subtitle: {
        text: ''
    },
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y:.0f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
    },
    credits: {
        enabled: false
    },
    series: [
        {
            name: "status_unbil",
            colorByPoint: true,
            data: [
                // {
                //     name: "Sudah Invoice",
                //     y: <?php echo $status_unbil->sudah_invoice;?>
                // },
                {
                    name: "Sudah Layak Tagih",
                    y: <?php echo $status_unbil->sudah_layak;?>
                },
                {
                    name: "Belum Layak Tagih",
                    y: <?php echo $status_unbil->belum_layak;?>
                }
                
            ]
        }
    ]
});

Highcharts.chart('issue_chart', {
        spacingLeft: 0,
        title: {
            useHTML: true,
            text: '<b>ISSUE</b>',
            x: 0,
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            //categories: ['WO', 'BAUT', 'BAST', 'Proses <br>Invoice','Verifikasi<br> Dokumen'],
            categories : <?php echo json_encode($issue['kategori']);?>,
            crosshair: true,
            className: 'highcharts-color-black',
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.0f} ',
                }
            }
        },

        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value} '
            },
            title: {
                text: ' '
            }
        }, ],

        tooltip: {
            headerFormat: '<table><tr><td colspan="2">{point.key}</td></tr>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f} </b> issue</td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        credits: {
            enabled: false, // Enable/Disable the credits
            text: 'This is a credit'
        },


        series: [{
                showInLegend: false,
                name: '',
                type: 'column',
                data: <?php echo json_encode($issue['jumlah']);?>,
                tooltip: {
                    valueSuffix: ' '
                },
                marker: {
                    lineWidth: 2,
                    lineColor: Highcharts.getOptions().colors[1],
                    fillColor: 'white'
                },
                color: {
                    linearGradient: [0, 400, 0, 0],
                    stops: [
                        [0, '#7abc87'],
                        [1, '#169aed'],
                    ]
                },
            }
        ]
    });



});
</script>
