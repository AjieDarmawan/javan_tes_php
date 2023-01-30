<!-- Main content -->

<section class="content">
    <!-- Main row -->
    <div class="row box">

    <?php $this->load->view('document/header_menu');?>

        <div class="col-md-6">
            <?php //$this->load->view('layouts/alert'); ?>
            
            <div class="nav-tabs-custom-aqua">
                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div style="height:400px;overflow-y:auto;">
                        <div class="tabel-responsive">
                        <table  class="table table-striped" id="myTable" >
                        <div style="width:70%;height:30px;margin-bottom:-10px;background:#ff8f00">
                                    <center><h3 style="text-color:white">Policy</h3></center>
                        </div>
                        <thead style="background:#98fb98">
                                <tr>
                                    <th width="15px" class="text-center">No</th>
                                    <th width="auto">Perihal Policy</th>
                                    <th width="20px" class="text-center">Tanggal Policy</th>
                                    <th width="10px" class="text-center">View</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                    $no=1;
                                    foreach($policy as $k){
                               ?>
                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td >
                                        <?php echo $k->perihal?>
                                    </td>
                                    <td>
                                        <?php echo $k->tanggal_surat?>
                                    </td>
                                    <td> 
                                        <a target="_blank" 
                                        href="<?php echo base_url('userfiles/dokumen/').$k->document?>" 
                                        ><img src='<?php echo base_url('assets/img/pdf_icon.png')?>' width='20px'></a>
                                    </td>
                                </tr>

                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="nav-tabs-custom-aqua">
                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div  style="height:400px;overflow-y:auto">
                        <table  class="table table-striped" id="myTable1" cellspacing="0" width="100%">
                        <div style="width:70%;height:30px;margin-bottom:-10px;background:#ff8f00">
                                    <center><h3 style="text-color:white">SOP</h3></center>
                        </div>
                        <thead style="background:#98fb98">
                                <tr>
                                    <th width="15px" class="text-center">No</th>
                                    <th width="auto">Perihal SOP</th>
                                    <th width="20px" class="text-center">Tanggal SOP</th>
                                    <th width="10px" class="text-center">View</th>
                                </tr>
                            </thead>
                            <tbody>

                               <?php
                                    $no=1;
                                    foreach($sop as $k){
                               ?>

                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td>
                                        <?php echo $k->perihal?>
                                    </td>
                                    <td>
                                        <?php echo $k->tanggal_surat?>
                                    </td>
                                    <td>
                                    <a target="_blank" 
                                        href="<?php echo base_url('userfiles/dokumen/').$k->document?>" 
                                        ><img src='<?php echo base_url('assets/img/pdf_icon.png')?>' width='20px'></a>
                                    </td>
                                </tr>

                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="nav-tabs-custom-aqua">
               
                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div style="height:400px;overflow:auto">
                        <table  class="table table-striped" id="myTable2" cellspacing="0" width="100%">
                        <div style="width:70%;height:30px;margin-bottom:-10px;background:#ff8f00">
                                    <center><h3 style="text-color:white">SK</h3></center>
                        </div>
                        <thead style="background:#98fb98">
                                <tr>
                                    <th width="15px" class="text-center">No</th>
                                    <th width="auto" class="text-center">No.Surat</th>
                                    <th width="auto">Perihal SK</th>
                                    <th width="20px" class="text-center">Tanggal SK</th>
                                    <th width="10px" class="text-center">View</th>
                                </tr>
                            </thead>
                            <tbody>

                               <?php
                                    $no=1;
                                    foreach($sk as $k){
                               ?>

                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td>
                                        <?php echo $k->no_surat?>
                                    </td>
                                    <td>
                                        <?php echo $k->perihal?>
                                    </td>
                                    <td>
                                      <?php echo $k->tanggal_surat?>
                                    </td>
                                    <td>
                                    <a target="_blank" 
                                        href="<?php echo base_url('userfiles/dokumen/').$k->document?>" 
                                        ><img src='<?php echo base_url('assets/img/pdf_icon.png')?>' width='20px'></a>
                                    </td>
                                </tr>

                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="nav-tabs-custom-aqua">

                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div style="height:400px;overflow:auto">
                        <table  class="table table-striped" id="myTable3" cellspacing="0" width="100%">
                        <div style="width:70%;height:30px;margin-bottom:-10px;background:#ff8f00">
                            <center><h3 style="text-color:white">SE</h3></center>
                        </div>
                        <thead style="background:#98fb98">
                                <tr>
                                    <th width="15px" class="text-center">No</th>
                                    <th width="auto" class="text-center">No.Surat</th>
                                    <th width="auto">Perihal SE</th>
                                    <th width="20px" class="text-center">Tanggal SE</th>
                                    <th width="10px" class="text-center">View</th>
                                </tr>
                            </thead>
                            <tbody>

                               <?php
                                    $no=1;
                                    foreach($se as $k){
                               ?>
                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td><?php echo $k->no_surat?></td>
                                    <td><?php echo $k->perihal?></td>
                                    <td><?php echo $k->tanggal_surat?></td>
                                    <td>
                                        <a target="_blank" 
                                        href="<?php echo base_url('userfiles/dokumen/').$k->document?>" 
                                        ><img src='<?php echo base_url('assets/img/pdf_icon.png')?>' width='20px'></a>
                                    </td>
                                </tr>

                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="nav-tabs-custom-aqua">
               
                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div style="height:400px;overflow:auto">
                        <table  class="table table-striped" id="myTable4" cellspacing="0" width="100%">
                        <div style="width:70%;height:30px;margin-bottom:-10px;background:#ff8f00">
                                    <center><h3 style="text-color:white">Memo</h3></center>
                        </div>
                            <thead style="background:#98fb98">
                                <tr>
                                    <th width="15px" class="text-center">No</th>
                                    <th width="auto" class="text-center">No.Surat</th>
                                    <th width="auto">Perihal SE</th>
                                    <th width="20px" class="text-center">Tanggal SE</th>
                                    <th width="10px" class="text-center">View</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                    $no=1;
                                    foreach($memo as $k){
                               ?>
                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td><?php echo $k->no_surat?></td>
                                    <td><?php echo $k->perihal?></td>
                                    <td><?php echo $k->tanggal_surat?></td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('userfiles/dokumen/').$k->document?>" 
                                            ><img src='<?php echo base_url('assets/img/pdf_icon.png')?>' width='20px'>
                                        </a>
                                    </td>
                                </tr>

                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>

    </div>
</section>

<?php $this->load->view('document/advance_search_modal');?>

<script>
$(document).ready(function () {
    $('#myTable').DataTable({
      'paging'      : true,
      "pageLength"  : 5,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true

    });
});
</script>
<script>
$(document).ready(function () {
    $('#myTable1').DataTable({
      'paging'      : true,
      "pageLength"  : 5,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true

    });
    $('#myTable2').DataTable({
      'paging'      : true,
      "pageLength"  : 5,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true

    });
    $('#myTable3').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      "pageLength"  : 5,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true

    });
    $('#myTable4').DataTable({
      'paging'      : true,
      'lengthChange': false,
      "pageLength"  : 5,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true

    });
});
</script>

