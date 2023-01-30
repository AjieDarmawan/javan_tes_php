<style>
    a.disabled {
  pointer-events: none;
  cursor: default;
}
</style>

<div class="container">
    <?php 

    error_reporting(0);
         $sql = $this->db->query('select create_add from irt where id_event = "'.$id_event.'" order by create_add desc limit 1')->row();

         $waktu = TanggalIndo(date('Y-m-d', strtotime($sql->create_add))) . ' ' . date('H:i:s', strtotime($sql->create_add));
    ?>
<h5>Terakhir Di Tarik : <?php echo $waktu?> </h5> 
</div>

<div class="container pt-5">
        <h3><?= $title ?></h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a>List Event</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Data</li>
            </ol>
        </nav>

       <div class="text-right">
       <?php 
                    
                    $limit = 50;

                    $tot = ceil($total_peserta/$limit);

                    for ($i=1; $i < $tot+1; $i++) { 

                        if($i==1){
                            $offset = 0;    
                        }else{
                            $offset = ($i * $limit)-$limit;
                        }

                       

                        ?>

                      

                      <!--   <a class="btn btn-success btn-sm" target="_blank" href="<?php echo "https://backend.edunovasi.com/api_mobile/api_irt/kirim_irt_modif/".$id_event.'/'.$i.'/'.$limit.'/'.$offset?>"><?php echo $i;?></a> -->

                     
                        <?php
                        # code...
                    }
                    
                  //  $total_peserta
                    
                    ?>
       </div>


        <div class="row">
            <div class="col-md-12">
            <a class="btn btn-primary mb-2" href="<?= base_url('master/Irt_tarik/print/'.$id_event); ?>">Print</a>
            
            
            
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
                                        <th>Rangking</th>
                                      
                                       
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Asal Sekolah</th>
                                        <th>Skor</th>
                                       
                                       
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
                "url": '<?php echo base_url('master/Irt_tarik/ajax_list_skor/'.$id_event)?>',
                "type": "POST"
            }
        });
    </script>




  