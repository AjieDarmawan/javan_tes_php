<?php 
$filename='file-name'.'.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename=report_hasil_irt'.$nama_judul.'".xls'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no c

    
?>

<h2><?php echo $data_api[0]['nama_judul']?></h2>
<table border="1">
    <thead>
        <tr>
            <th>Rangking</th>


            <th>Nama</th>
            <th>Email</th>
            <th>Asal Sekolah</th>
            <th>Skor</th>

            <?php 

            if($kedinasan==1){

                  error_reporting(0);
                $mat = $this->db->query("select m.materi_nama,j.*  from jawaban as j
                join materi as m on j.materi_id = m.materi_id
                where  j.id_event = '".$id_event."' and j.mode = '1'  limit 3 ")->result();

                foreach($mat as $m){
                    ?>


                    <th><?php echo $m->materi_nama?></th>

            <?php 
                }

                 }
            ?>

           


          
           


        </tr>
    </thead>

    <tbody>
        <?php 
        $no=1;
         error_reporting(0);
            foreach($data_api as $a){

                
         ?>
            <tr>
                <td><?php echo $no++;?></td>
                <td><?php echo $a['nama']?></td>
                <td><?php echo $a['email']?></td>
                <td><?php echo $a['asal_sekolah']?></td>
                <td><?php echo $a['skor']?></td>
                <?php 
                  if($kedinasan==1){
                $mat = $this->db->query("select m.materi_nama,j.*  from jawaban as j
                join materi as m on j.materi_id = m.materi_id
                where  j.id_event = '".$id_event."' and j.mode = '1' and j.email = '".$a['email']."' ")->result();

                foreach($mat as $m){
                    ?>


                    <th><?php echo $m->skor?></th>

            <?php 
                }
            }
            ?>
               
            </tr>
         
         <?php
            }
        ?>
        <tr>
            
        </tr>
    </tbody>
</table>