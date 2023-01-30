<!-- Main content -->
<section class="content">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view('layouts/alert'); ?>
            <?php // echo '<pre>'; print_r($this->session->userdata()); ?>

              <div class="col-lg-12">         
                    <?php
                    if($this->session->flashdata('message'))
                   {
                            echo"<div class='alert alert-success alert-dismissable'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>               
                                    <strong>
                                        <i class='icon-ok'></i>
                                    SUKSES !
                                    </strong> ".$this->session->flashdata('message')." .
                                </div>";
                       }
                    ?>
                    </div>


            <div class="nav-tabs-custom-aqua">
                <ul class="nav nav-tabs">
                   
                    
                    <li class="pull-right">
                        <a href="<?php echo site_url('Kategori/tambah_kategori'); ?>" class="btn btn-default btn-flat">
                            <i class="glyphicon glyphicon-plus"></i> Tambah Data
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div class="tab-pane active">
                        <table  class="table table-striped" id="myTable" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="10">No</th>
                                    <th width="30">Nama Kategori</th>
                                    
                                    <th width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                               <?php
                                    $no=1;
                                    foreach($kategori as $k){
                               ?>
                               
                                <tr>
                                    <td><?php echo $no++;?></td>
                                 
                                    <td>
                                            <?php echo $k->name?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle" data-toggle="dropdown" style="width: 80px;" aria-expanded="false">Action  <span class="caret"></span></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <!-- <li><a href="<?php echo site_url('home/view/1'); ?>"><span class="glyphicon glyphicon-zoom-in"></span> Details</a>
                                                    </li>
                                                    <li><a href="<?php echo base_url('home/edit/1'); ?>"><span class="glyphicon glyphicon-pencil"></span> Ubah</a>
                                                    </li> -->
                                                    <li><a href="<?php echo base_url('Kategori/update_kategori/'.$k->id); ?>"><span class="glyphicon glyphicon-pencil"></span> Update</a>
                                                    </li>
                                                    <!-- <li><a onclick="return confirm('Anda Yakin akan menghapus?')" href="<?php echo base_url('Kategori/delete_kategori/'.$k->id); ?>"><i class="glyphicon glyphicon-trash hapus_kategori"></i> Hapus</a>
                                                    </li> -->
                                                    <li><a  id="<?php echo $k->id?>" class="hapus_kategori"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
                                                    </li>

                                                </ul>
                                        </div>
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
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->
<script>
$(document).ready(function () {
    $('#myTable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
      
    });
});
</script>


<script>

$(document).on("click",".hapus_kategori",function(){
         var kategori_id=$(this).attr("id");

       // alert(kategori_id);
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
                url  : "<?php echo base_url();?>Kategori/delete_kategori",
                dataType: "JSON",
                data : "kategori_id="+kategori_id,
                success:function(data){
                    // reload_table();
                    // setTimeout(function() {
                    //     location.reload();   
                    //     //window.location = base_url+"Home/list";         
                    // }, 1000); 
                }

            });
           swal("Deleted!", "Data berhasil dihapus .", "success");
           setTimeout(function(){ 
            window.location = "<?php echo base_url();?>Kategori";
            
            }, 
            1000);
        });
            
    });
</script>