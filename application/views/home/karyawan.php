<!-- Main content -->
<section class="content">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view('layouts/alert')?>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                <li class="active"><a href="#pengumuman" data-toggle="tab" aria-expanded="false"><i class="fa fa-bullhorn"></i> Pengumuman</a></li>
                </ul>
                <div class="tab-content">
                <div class="tab-pane active" id="pengumuman">
                    <ul class="timeline timeline-inverse">
                        <?php foreach($artikel as $a){?>
                            <li class="time-label"><span class="bg-blue"><?php echo TanggalIndo($a->tst_show)?></span></li>
                            <li>
                                <i class="fa fa-bullhorn bg-warning"></i>
                                <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> <?php echo date('H:m:s', strtotime($a->tgl_upload));?></span>
                                <h3 class="timeline-header"><a href="#"><?php echo $a->judul?></a></h3>
                                <div class="timeline-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <iframe src="<?php echo base_url() ?><?php echo $a->url ?>" width="100%" height="500px"></iframe>
                                        </div>
                                    </div>
                                    <?php echo $a->Deskripsi?>
                                </div>
                                <div class="timeline-footer">
                                    <a class="btn btn-success btn-sm" href="<?php echo base_url()?><?php echo $a->url ?>" target="_blank"><i class="fa fa-download"></i> Unduh</a>
                                </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>
</section>