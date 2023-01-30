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
                        <table  class="table table-striped" id="tablePolicy" >
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
                        <table  class="table table-striped" id="tableSOP" cellspacing="0" width="100%">
                        <div style="width:70%;height:30px;margin-bottom:-10px;background:#ff8f00">
                                    <center><h3 style="text-color:white">SCRUM</h3></center>
                        </div>
                        <thead style="background:#98fb98">
                                <tr>
                                    <th width="15px" class="text-center">No</th>
                                    <th width="auto">Perihal SCRUM</th>
                                    <th width="20px" class="text-center">Tanggal SCRUM</th>
                                    <th width="10px" class="text-center">View</th>
                                </tr>
                            </thead>
                            <tbody>

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
                        <table  class="table table-striped" id="tableSK" cellspacing="0" width="100%">
                        <div style="width:70%;height:30px;margin-bottom:-10px;background:#ff8f00">
                                    <center><h3 style="text-color:white">BAST</h3></center>
                        </div>
                        <thead style="background:#98fb98">
                                <tr>
                                    <th width="15px" class="text-center">No</th>
                                    <th width="auto" class="text-center">No.Surat</th>
                                    <th width="auto">Perihal BAST</th>
                                    <th width="20px" class="text-center">Tanggal BAST</th>
                                    <th width="10px" class="text-center">View</th>
                                </tr>
                            </thead>
                            <tbody>

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
                        <table  class="table table-striped" id="tableSE" cellspacing="0" width="100%">
                        <div style="width:70%;height:30px;margin-bottom:-10px;background:#ff8f00">
                            <center><h3 style="text-color:white">Pertanggungan</h3></center>
                        </div>
                        <thead style="background:#98fb98">
                                <tr>
                                    <th width="15px" class="text-center">No</th>
                                    <th width="auto" class="text-center">No.Surat</th>
                                    <th width="auto">Perihal Pertanggungan</th>
                                    <th width="20px" class="text-center">Tanggal Pertanggungan</th>
                                    <th width="10px" class="text-center">View</th>
                                </tr>
                            </thead>
                            <tbody>

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
                        <table  class="table table-striped" id="tableMemo" cellspacing="0" width="100%">
                        <div style="width:70%;height:30px;margin-bottom:-10px;background:#ff8f00">
                                    <center><h3 style="text-color:white">NDA</h3></center>
                        </div>
                            <thead style="background:#98fb98">
                                <tr>
                                    <th width="15px" class="text-center">No</th>
                                    <th width="auto" class="text-center">No.Surat</th>
                                    <th width="auto">Perihal NDA</th>
                                    <th width="20px" class="text-center">Tanggal NDA</th>
                                    <th width="10px" class="text-center">View</th>
                                </tr>
                            </thead>
                            <tbody>
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
    $.fn.dataTable.ext.errMode = 'none';

    $('#SubmitAdvanceSearch').click(function(){
        reload_table();
        $('#modal-default').modal('hide');
    });

    function reload_table(){
        tablePolicy.ajax.reload(null,false); //reload datatable ajax 
        tableSOP.ajax.reload(null,false); //reload datatable ajax 
        tableSK.ajax.reload(null,false); //reload datatable ajax 
        tableSE.ajax.reload(null,false); //reload datatable ajax
        tableMemo.ajax.reload(null,false); //reload datatable ajax
    }

    tablePolicy = $('#tablePolicy').DataTable({
      'paging'      : true,
      "pageLength"  : 5,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true,
      "processing": true,
            "serverSide": true,
            "order": [],
             
            "ajax": {
                "url": "<?php echo $policy_url;?>",
                "type": "POST",
                "data": function ( data ) {
                    data.no_surat               = $('#cari_no_surat').val();
                    data.perihal                = $('#cari_perihal').val();
                    data.tanggal_mulai     = $('#cari_tanggal_mulai').val();
                    data.tanggal_selesai   = $('#cari_tanggal_selesai').val();
                    data.keyword                = $('#cari_keyword').val();
                    data.tanggal_efektif_mulai  = $('#cari_tanggal_efektif_mulai').val();
                    data.tanggal_efektif_selesai  = $('#cari_tanggal_efektif_selesai').val();
               
                }
            },
 
            "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
            },],

    });

    tableSOP = $('#tableSOP').DataTable({
      'paging'      : true,
      "pageLength"  : 5,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true,
      "processing": true,
            "serverSide": true,
            "order": [],
             
            "ajax": {
                "url": "<?php echo $sop_url;?>",
                "type": "POST",
                "data": function ( data ) {
                    data.no_surat               = $('#cari_no_surat').val();
                    data.perihal                = $('#cari_perihal').val();
                    data.tanggal_mulai     = $('#cari_tanggal_mulai').val();
                    data.tanggal_selesai   = $('#cari_tanggal_selesai').val();
                    data.keyword                = $('#cari_keyword').val();
                    data.tanggal_efektif_mulai  = $('#cari_tanggal_efektif_mulai').val();
                    data.tanggal_efektif_selesai  = $('#cari_tanggal_efektif_selesai').val();
               
                }
            },
 
            "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
            },],

    });
    tableSK = $('#tableSK').DataTable({
      'paging'      : true,
      "pageLength"  : 5,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true,
      "processing": true,
            "serverSide": true,
            "order": [],
             
            "ajax": {
                "url": "<?php echo $sk_url;?>",
                "type": "POST",
                "data": function ( data ) {
                    data.no_surat               = $('#cari_no_surat').val();
                    data.perihal                = $('#cari_perihal').val();
                    data.tanggal_mulai     = $('#cari_tanggal_mulai').val();
                    data.tanggal_selesai   = $('#cari_tanggal_selesai').val();
                    data.keyword                = $('#cari_keyword').val();
                    data.tanggal_efektif_mulai  = $('#cari_tanggal_efektif_mulai').val();
                    data.tanggal_efektif_selesai  = $('#cari_tanggal_efektif_selesai').val();
               
                }
            },
 
            "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
            },],

    });
    tableSE = $('#tableSE').DataTable({
      'paging'      : true,
      "pageLength"  : 5,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true,
      "processing": true,
            "serverSide": true,
            "order": [],
             
            "ajax": {
                "url": "<?php echo $se_url;?>",
                "type": "POST",
                "data": function ( data ) {
                    data.no_surat               = $('#cari_no_surat').val();
                    data.perihal                = $('#cari_perihal').val();
                    data.tanggal_mulai     = $('#cari_tanggal_mulai').val();
                    data.tanggal_selesai   = $('#cari_tanggal_selesai').val();
                    data.keyword                = $('#cari_keyword').val();
                    data.tanggal_efektif_mulai  = $('#cari_tanggal_efektif_mulai').val();
                    data.tanggal_efektif_selesai  = $('#cari_tanggal_efektif_selesai').val();
               
                }
            },
 
            "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
            },],

    });
    tableMemo = $('#tableMemo').DataTable({
      'paging'      : true,
      "pageLength"  : 5,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true,
      "processing": true,
            "serverSide": true,
            "order": [],
             
            "ajax": {
                "url": "<?php echo $memo_url;?>",
                "type": "POST",
                "data": function ( data ) {
                    data.no_surat               = $('#cari_no_surat').val();
                    data.perihal                = $('#cari_perihal').val();
                    data.tanggal_mulai     = $('#cari_tanggal_mulai').val();
                    data.tanggal_selesai   = $('#cari_tanggal_selesai').val();
                    data.keyword                = $('#cari_keyword').val();
                    data.tanggal_efektif_mulai  = $('#cari_tanggal_efektif_mulai').val();
                    data.tanggal_efektif_selesai  = $('#cari_tanggal_efektif_selesai').val();
               
                }
            },
 
            "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
            },],

    });
});
</script>

