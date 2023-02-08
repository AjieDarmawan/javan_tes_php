<div class="container pt-5">
        <!-- <h3><?= $title ?></h3> -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a>Keluarga</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Data</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <!-- <a class="btn btn-primary mb-2" href="<?= base_url('master/kantor/tambah'); ?>">Tambah</a> -->
                <div mb-2>
                    <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                    
                    <?php $this->load->view('layouts/alert'); ?>


                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="tablekantor">
                                <thead>
                                    <tr class="table-success">
                                        <th></th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 1;
                                        foreach($data as $d){
                                            ?>


                                            <tr>
                                                <td><?php echo $no++;?></td>
                                                <td><?php echo $d->nama;?></td>
                                                <td>Anak Budi</td>
                                            </tr>

                                       <?php     
                                        }
                                    ?>
                                </tbody>
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
 
 
   


<script type="text/javascript">

// function reload_table()
//         {
//             table.ajax.reload(null,false); //reload datatable ajax 
//         } 


    var table;
$(document).ready(function() {

       


      $(document).on("click",".hapus_dokumen",function(){
              var id=$(this).attr("id");

             alert(id);
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
                      url  : "<?php echo base_url();?>master/kantor/hapus",
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

  