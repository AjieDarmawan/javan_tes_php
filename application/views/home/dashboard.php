<!-- Main content -->
<section class="content">
    <!-- Main row --> 

                <div class="row">
                    <div class="col-lg-4">
                        <div id="account_revenue" style="height:270px"></div>
                    </div>
                    <div class="col-lg-4">
                        <div id="container" style="height:270px"></div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div id="issue_chart" style="height:270px"></div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-4">
                        <div id="billed_by_customer" style="height:250px" ></div>
                    </div>
                    <div class="col-lg-4">
                        <div id="unbil_by_customer" style="height:250px" ></div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div id="unbil_by_user" style="height:250px"></div>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="box box-info">
                            <div class="box-header">
                                5 BESAR PROJECT UNBILL (BY ISSUE <b>BAST</b>)
                            </div>
                            <div class="box-body no-padding">
                            <table class="table table-striped">
                            <tr class="bg-aqua color-palette"><th>No.</th>
                                <th>Customer</th>
                                <th>Project</th>
                                <th>Nilai</th>
                            </tr>
                            <?php
                                foreach ($issue_bast as $key) {
                                ?>
                                <tr><td><?php echo$i;?></td>
                                    <td><?php echo $key->nama_pelanggan;?></td>
                                    <td><?php echo $key->nama_project;?></td>
                                    <td class="text-right">Rp. <?php echo number_format($key->eqv_nilai_invoice,0,',','.');?></td>
                                </tr>
                                <?php
                                }
                            ?>
                            </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-6">
                        <div class="box box-info">
                            <div class="box-header">
                                5 BESAR PROJECT UNBILL (BY ISSUE <b>BA PERFORMANSI</b>)
                            </div>
                            <div class="box-body no-padding">
                            <table class="table table-striped">
                            <tr class="bg-aqua color-palette"><th>No.</th>
                                <th>Customer</th>
                                <th>Project</th>
                                <th>Nilai</th>
                            </tr>
                            <?php
                                foreach ($issue_BA_performansi as $key) {
                                ?>
                                <tr><td><?php echo$i;?></td>
                                    <td><?php echo $key->nama_pelanggan;?></td>
                                    <td><?php echo $key->nama_project;?></td>
                                    <td class="text-right">Rp. <?php echo number_format($key->eqv_nilai_invoice,0,',','.');?></td>
                                </tr>
                                <?php
                                }
                            ?>
                            </table>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="box box-info">
                            <div class="box-header">
                                5 BESAR PROJECT UNBILL (BY ISSUE <b> KONTRAK / WO</b>)
                            </div>
                            <div class="box-body no-padding">
                            <table class="table table-striped">
                            <tr class="bg-aqua color-palette"><th>No.</th>
                                <th>Customer</th>
                                <th>Project</th>
                                <th>Nilai</th>
                            </tr>
                            <?php
                                foreach ($issue_kontrak_wo as $key) {
                                ?>
                                <tr><td><?php echo$i;?></td>
                                    <td><?php echo $key->nama_pelanggan;?></td>
                                    <td><?php echo $key->nama_project;?></td>
                                    <td class="text-right">Rp. <?php echo number_format($key->eqv_nilai_invoice,0,',','.');?></td>
                                </tr>
                                <?php
                                }
                            ?>
                            </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-6">
                        <div class="box box-info">
                            <div class="box-header">
                                5 BESAR PROJECT UNBILL (BY ISSUE <b>VERIFIKASI</b>)
                            </div>
                            <div class="box-body no-padding">
                            <table class="table table-striped">
                            <tr class="bg-aqua color-palette"><th>No.</th>
                                <th>Customer</th>
                                <th>Project</th>
                                <th>Nilai</th>
                            </tr>
                            <?php
                                foreach ($issue_verifikasi as $key) {
                                ?>
                                <tr><td><?php echo$i;?></td>
                                    <td><?php echo $key->nama_pelanggan;?></td>
                                    <td><?php echo $key->nama_project;?></td>
                                    <td class="text-right">Rp. <?php echo number_format($key->eqv_nilai_invoice,0,',','.');?></td>
                                </tr>
                                <?php
                                }
                            ?>
                            </table>
                            </div>
                        </div>
                        
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

    Highcharts.chart('account_revenue', {
    chart: {
        type: 'pie',
        height: 270,
    },
    title: {
        text: '<b>ACCOUNT REVENUE</b>'
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
            name: "ACCOUNT REVENUE",
            colorByPoint: true,
            data: [
                {
                    name: "BILL",
                    y: <?php echo $status_revenue->bill;?>
                },
                {
                    name: "UNBILL",
                    y: <?php echo $status_revenue->unbill;?>
                }
                
            ]
        }
    ]
});
    // Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'pie',
        height: 270,
        marginTop:30,
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
        },
        pie: {
            // allowPointSelect: true,
            // cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true,
            marginLeft:-50
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
                {
                    name: "Sudah Layak Tagih",
                    y: <?php echo $status_unbil->sudah_layak;?>
                },
                {
                    name: "Belum Layak ",
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
            text: '<b>ISSUE UNBIL</b>',
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

Highcharts.chart('billed_by_customer', {
        spacingLeft: 0,
        title: {
            useHTML: true,
            text: '<b>BILLED BY CUSTOMER</b>',
            x: 0,
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            //categories: ['WO', 'BAUT', 'BAST', 'Proses <br>Invoice','Verifikasi<br> Dokumen'],
            categories : <?php echo json_encode($billed_customer['pelanggan']);?>,
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
                data: <?php echo json_encode($billed_customer['jumlah']);?>,
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

    Highcharts.chart('unbil_by_customer', {
        spacingLeft: 0,
        title: {
            useHTML: true,
            text: '<b>UNBIL BY CUSTOMER</b>',
            x: 0,
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            //categories: ['WO', 'BAUT', 'BAST', 'Proses <br>Invoice','Verifikasi<br> Dokumen'],
            categories : <?php echo json_encode($unbil_customer['pelanggan']);?>,
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
                data: <?php echo json_encode($unbil_customer['jumlah']);?>,
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

    Highcharts.chart('unbil_by_user', {
        spacingLeft: 0,
        title: {
            useHTML: true,
            text: '<b>UNBIL BY USER PROCESS</b>',
            x: 0,
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            //categories: ['WO', 'BAUT', 'BAST', 'Proses <br>Invoice','Verifikasi<br> Dokumen'],
            categories : <?php echo json_encode($user_process['PIC']);?>,
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
                data: <?php echo json_encode($user_process['jumlah']);?>,
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
