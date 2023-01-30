<div class="container pt-5">
        <h3><?= $title ?></h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a>Materi</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Data</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
               
                <div mb-2>
                    <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                    
                    <?php $this->load->view('layouts/alert'); ?>


                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="tabledivisi">
                                <thead>
                                    <tr class="table-success">
                                        <th></th>
                                      
                                        <th>Nama Sekolah</th>
                                        <th>Nama Pendaftar</th>
                                        <th>Email Pendaftar</th>
                                        <th>Alamat</th>
                                        <th>Jumlah Siswa</th>
                                        <th>Provinsi</th>
                                        <th>Kota</th>
                                        
                                         <th>No Wa</th>
                                         <th>Kode Sekolah</th>
                                         <th>Password Sekolah</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                       
                                       
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="<?php echo base_url();?>assets/template/assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?php echo base_url();?>assets/template/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="<?php echo base_url();?>assets/template/assets/js/scripts.bundle.js"></script>
 
 
   
    <!--begin::Page Vendors(used by this page)-->
        <script src="<?php echo base_url();?>assets/template/assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <!--end::Page Vendors-->
        <!--begin::Page Scripts(used by this page)-->


    <script>
        //setting datatables
        $('#tabledivisi').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                //panggil method ajax list dengan ajax
                "url": '<?php echo base_url('master/Sekolah/ajax_list')?>',
                "type": "POST"
            }
        });
    </script>


<script type="text/javascript">

// function reload_table()
//         {
//             table.ajax.reload(null,false); //reload datatable ajax 
//         } 


    var table;
$(document).ready(function() {

       


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
                      url  : "<?php echo base_url();?>master/Sekolah/hapus",
                      dataType: "JSON",
                      data : "id="+id,
                      success:function(data){
                         // reload_table();
          
                          setTimeout(function() {
                              location.reload();
                          }, 1000);
                      }

                  });
                swal("Deleted!", "Data berhasil dihapus .", "success");
                
              });
          });
 
    }); 
    

    
</script>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>




  