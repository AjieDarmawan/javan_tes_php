<section class="content">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view('layouts/alert'); ?>
            <?php // echo '<pre>'; print_r($this->session->userdata()); ?>
            <div class="nav-tabs-custom-aqua">
               
                <div class="tab-content">
                   

         <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Nama Kategori</h3>
            </div>
                        <div class="box-body"> 
                        <form action="<?php echo base_url('Kategori/update_simpan')?>" method="post"> 
                            <div class="form-group">
                                <label>Edit Kategori</label>
                                    <input type="text" class="form-control nama" value="<?php echo $data->name?>" placeholder="nama kategori" name="name_kategori" >
                            </div>

                            <input type="hidden" id="" value="<?php echo $data->id?>" name="id" class="form-control id">

                            <button type="submit" class="btn btn-success btn-sm edit">Simpan</button>
                            <a  onclick="goBack()" class="btn btn-danger btn-sm">Kembali</a>
                            </div>
                          </form> 
                            <!-- /.box-body -->
                        </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
</section>

<script>
function goBack() {
  window.history.back();
}
</script>

<script>

// $(document).on("click",".edit",function(){
//          var name_kategori=$(".nama").val();
//          var id=$(".id").val();
//          //alert(name_kategori);
//         // swal({
//         //     title: "Yakin Hapus Data ini  ?",
//         //     type: "warning",
//         //     showCancelButton: true,
//         //     confirmButtonColor: "#DD6B55",
//         //     confirmButtonText: "Ya, Hapus!",
//         //     closeOnConfirm: false
//         // }, function () {

//             $.ajax({
//                 type : "POST",
//                 url  : "<?php echo base_url();?>Kategori/update_simpan",
//                 dataType: "JSON",
//                 data : "name_kategori="+name_kategori+"&id="+id,
//                 success:function(data){
//                    // reload_table();
//                     // setTimeout(function() {
//                     //     //location.reload();  
//                     //    // window.location = base_url+"kategori";  
//                     //    window.location = "<?php echo base_url();?>Kategori/index";
                                
//                     // }, 1000); 
//                 }

//             });
//             swal("Success!", "Data berhasil diSimpan .", "success");
//             setTimeout(function(){ 
//             window.location = "<?php echo base_url();?>Kategori/index";
            
//             }, 
//             1000);
          
//         // });
            
//     });
</script>