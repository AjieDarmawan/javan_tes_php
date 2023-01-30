<div class="row container">

     <?php 
            // echo "<pre>";
            // print_r($sekolah);

            foreach($sekolah as $s){
                
                $query = $this->db->query('select create_add from irt where id_sekolah="'.$s->id_sekolah.'" and id_event="'.$s->id_event.'" limit 1')->row();
                 $total_peserta = $this->db->query('select create_add as total from irt where id_sekolah="'.$s->id_sekolah.'" and id_event="'.$s->id_event.'" GROUP by email')->result();
            
        ?>
    <div class="col-md-6 col-xl-4"> 
        <a href="<?php echo base_url('master/Irt_tarik/sekolah_detail/'.base64_encode($s->id_sekolah))?>" class="card border-hover-primary">
            <div class="card-body p-9">
                <div class="fs-3 fw-bold text-dark"><?php echo $s->nama_sekolah?></div>
                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">Terakhir : <?php echo TanggalIndo($query->create_add)?> <?php echo date('H:i:s',strtotime($query->create_add))?></p>
                <p class="text-blue-400 fw-semibold fs-5 mt-1 mb-7">Peserta : <?php echo count($total_peserta)?></p>
            </div>
        </a>
    </div>

    <?php 
        }
    ?>

    
</div>