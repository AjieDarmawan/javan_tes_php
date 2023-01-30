<?php ob_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php if (!empty($title)) { echo $title;}?> | HRIS</title>
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/img/icon_telkomsat.png" />
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">

        <!-- Font Awesome -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome-4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/ionicons-2.0.1/css/ionicons.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/AdminLTE.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
        <link href="<?php echo base_url(); ?>assets/css/site.css" rel="stylesheet"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php 
        if (isset($css)) {
            for ($i = 0; $i < count($css); ++$i) {
                echo '<link href="'.base_url().'assets/'.$css[$i].'" rel="stylesheet" />';
            }
        }
        ?>

        <!-- jQuery 2.1.4 -->
        <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
        
        <?php 
        if (isset($js)) {
            for ($i = 0; $i < count($js); ++$i) {
                echo '<script type="text/javascript" src="'.base_url().'assets/'.$js[$i].'"></script>';
            }
        }
        ?>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
        <!-- page script -->
        <script>
            
            $(function () {
                $(".datatable").DataTable();
                $('.datatable2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true
                });
            });
            $(".alert").alert();
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo base_url(); ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>GG</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Gilland</b> Ganesha</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="hidden-xs">
                                <a>
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <script type="text/javascript">

                                            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                            var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
                                            var date = new Date();
                                            var day = date.getDate();
                                            var month = date.getMonth();
                                            var thisDay = date.getDay(),
                                                    thisDay = myDays[thisDay];
                                            var yy = date.getYear();
                                            var year = (yy < 1000) ? yy + 1900 : yy;
                                            document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);

                                    </script>
                                </a>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li class="hidden-xs">
                                <a>
                                    <i class="fa fa-clock-o"></i> <span id="jamweke"></span>
                                    <script type="text/javascript">
                                        <!--
                                        function startTime() {
                                                var today=new Date(),
                                                        curr_hour=today.getHours(),
                                                        curr_min=today.getMinutes(),
                                                        curr_sec=today.getSeconds();
                                         curr_hour=checkTime(curr_hour);
                                                curr_min=checkTime(curr_min);
                                                curr_sec=checkTime(curr_sec);
                                                document.getElementById('jamweke').innerHTML=curr_hour+":"+curr_min+":"+curr_sec;
                                        }
                                        function checkTime(i) {
                                                if (i<10) {
                                                        i="0" + i;
                                                }
                                                return i;
                                        }
                                        setInterval(startTime, 500);
                                        //-->
                                    </script>
                                </a>
                            </li>
                            <?php
                            $sess = $this->session->userdata();
                            ?>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php
                                    if (!empty($sess['pegawai'])) {
                                        ?>
                                        <img src="<?php echo !empty($sess['pegawai']['url']) ? base_url($sess['pegawai']['url']) : base_url('assets/img/user.jpg'); ?>" class="user-image">
                                        <span class="hidden-xs"><?php echo $sess['pegawai']['kar_nm']; ?></span>
                                    <?php
                                    } else {
                                        ?>
                                        <img src="<?php echo base_url('assets/img/'); ?>user.jpg" class="user-image" alt="User Image">
                                        <span class="hidden-xs">pegawai tidak diketahui</span>
                                    <?php
                                    }
                                    ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                    <?php
                                    if (!empty($sess['pegawai'])) {
                                        ?>
                                        <img src="<?php echo !empty($sess['pegawai']['url']) ? base_url($sess['pegawai']['url']) : base_url('assets/img/user.jpg'); ?>" class="img-circle">
                                        <p>
                                            <?php echo $sess['pegawai']['kar_nm']; ?>
                                        </p>
                                    <?php
                                    } else {
                                        ?>
                                        <img src="<?php echo base_url('assets/img/'); ?>user.jpg" class="img-circle" alt="User Image">
                                        <p>pegawai tidak diketahui</p>
                                    <?php
                                    }
                                    ?>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <!--<a href="<?php //echo base_url('auth/change_password'); ?>" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Ganti Password</a>-->
                                            <a href="" class="btn btn-default btn-flat"><i class="fa fa-home"></i> Portal</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Keluar</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <?php $this->load->view('layouts/menu'); ?>
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-breadcrumb">
                    <?php // $this->load->view('layouts/breadcrumb', $breadcrumb); ?>
                </section>
                <?php
                echo $contents;
                ?>
                <!-- Modal -->
                <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  style="width:50%">
                        <div class="modal-content" >
                        </div> <!-- /.modal-content -->
                    </div> <!-- /.modal-dialog -->
                </div> <!-- /.modal -->
            </div><!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Beta Version</b>
                </div>
                <strong>Copyright &copy; 2022 .</strong> All rights reserved.
            </footer>

            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div><!-- ./wrapper -->
    </body>
</html>
<?php ob_flush(); ?>