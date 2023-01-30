<?php
$sess = $this->session->userdata();
// echo "<pre>";
// print_r($sess);

?>
<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <div class="profile sidebar-form" style="border-style: none">
        <ul>
            <li>
                <?php
                if (!empty($sess['pegawai'])) {
                    ?>
                    <img src="<?php echo !empty($sess['pegawai']['url']) ? base_url($sess['pegawai']['url']) : base_url('assets/img/user.jpg'); ?>" class="img-circle">
                <?php
                } else {
                    ?>
                    <img src="<?php echo base_url('assets/img/'); ?>user.jpg" class="img-circle" alt="User Image">
                <?php
                }
                ?>
            </li>
            <?php
            if (!empty($sess['pegawai'])) {
                echo '<li><b>'.$sess['pegawai']['kar_nm'].'</b></li>';
                echo '<li>Gilland Ganesha</li>';
            } else {
                echo '<li>pegawai tidak diketahui</li>';
                echo "<li style='color:white'>Gilland Ganesha</li>";
            }


           
            
            ?>
            <li style='color:white'><small>DIVISI : <?php error_reporting(0); echo strtoupper($sess['pegawai']['div_nm']); ?></small></li>
        </ul>
    </div>

    <ul class="sidebar-menu">

        <li class="active">
            <a href="<?php echo site_url('pegawai/beranda'); ?>">
                <i class="glyphicon glyphicon-home"></i> <span>Beranda</span>
            </a>
        </li> 


        <li class="active">
            <a href="<?php echo site_url('pegawai/absen'); ?>">
                <i class="glyphicon glyphicon-home"></i> <span>Absen</span>
            </a>
        </li> 

        <li class="active">
            <a href="<?php echo site_url('pegawai/absen'); ?>">
                <i class="glyphicon glyphicon-home"></i> <span>Jadwal Online</span>
            </a>
        </li> 

        <li class="active">
            <a href="<?php echo site_url('pegawai/absen'); ?>">
                <i class="glyphicon glyphicon-home"></i> <span>Persoanl Biodata</span>
            </a>
        </li> 

    </ul>
</section>