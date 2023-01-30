<!-- Main content -->
<section class="content">
    <!-- Main row -->
    <div class="row box">

    <?php $this->load->view('document/header_menu');?>
      
        <div class="col-md-12">
            <?php $this->load->view('layouts/alert'); ?>
            <?php // echo '<pre>'; print_r($this->session->userdata()); ?>

            

            <div class="nav-tabs-custom-aqua">
                <ul class="nav nav-tabs">

                    <?php
                        $q = $this->uri->segment('3');
                        if(in_array('admin memo', $this->session->userdata('permission'))){
                    ?>
                    <li class="pull-right">
                        <a href="<?php echo site_url('document/tambah/').$q; ?>" class="btn btn-default btn-flat">
                            <i class="glyphicon glyphicon-plus"></i> Tambah Data
                        </a>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div class="tab-pane active">

                          <table id="table" class="display table table-striped" cellspacing="0" width="100%">
                          <thead>
                                <tr>
                                   <th width="15px">No</th>
                                   <th width="150px">No. Surat</th>
                                   <th width="auto">Perihal Surat</th>
                                   <th width="100px">Tanggal Surat</th>
                                   <th width="20px">View</th>
                                   <?php
                                   if(in_array('admin memo', $this->session->userdata('permission'))){
                                    ?>
                                   <th width="20px">Action</th>
                                   <?php
                                   }
                                   ?>
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

<script type="text/javascript">
    var table;
    $(document).ready(function() {

        $('#SubmitAdvanceSearch').click(function(){
            reload_table();
            $('#modal-default').modal('hide');
        });
        //datatables
        table = $('#table').DataTable({
 
            "processing": true,
            "serverSide": true,
            "order": [],
             
            "ajax": {
                "url": "<?php echo $memo_url;?>",
                "type": "POST",
                "data": function ( data ) {
                    data.no_surat               = $('#cari_no_surat').val();
                    data.perihal                = $('#cari_perihal').val();
                    data.tanggal_mulai          = $('#cari_tanggal_mulai').val();
                    data.tanggal_selesai        = $('#cari_tanggal_selesai').val();
                    data.keyword                = $('#cari_keyword').val();
                    data.tanggal_efektif_mulai  = $('#cari_tanggal_efektif_mulai').val();
                    data.tanggal_efektif_selesai  = $('#cari_tanggal_efektif_selesai').val();
               
                }
            },
 
             
            "columnDefs": [
            {
                "targets": [ 0 ],
                "orderable": false,
            },
            ],
 
        });

      $.fn.dataTable.ext.errMode = 'none';
      function reload_table()
      {
          table.ajax.reload(null,false); //reload datatable ajax 
      } 

      $(document).on("click",".hapus_dokumen",function(){
         var id=$(this).attr("id");

      //  alert(id);
        swal({
            title: "Yakin Hapus Data ini  ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
            closeOnConfirm: false
        }, function () {

            $.ajax({
                type : "POST",
                url  : "<?php echo base_url();?>document/document_hapus",
                dataType: "JSON",
                data : "id="+id,
                success:function(data){
                    reload_table();
                    
                }

            });
           swal("Deleted!", "Data berhasil dihapus .", "success");
           
        });

    });
 
});
 
</script>

