<!-- Main content -->
<section class="content">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                Selamat Datang
                <?php echo $encryption ?>
                <a href="<?php echo site_url('biodata/view').'/'.$encryption ?>">Contoh pegawai id 1</a>
                <br>
                <?php echo $decryption ?>
                <br>
                <?php echo TanggalIndo('2014-11-22')?>
            </div>
            <div>
            </div>
        </div>
    </div>
</section>