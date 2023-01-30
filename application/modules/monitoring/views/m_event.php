<?php 
    // echo "<pre>";
    // print_r($event);
?>

<center><h3> Aktivitas Event </h3><center>
      <table id="example2" class="display nowrap table-striped table-bordered table" style="width:100%;
                        ">
              <caption class="text-center"><br>
               </caption>
                <thead>
                   <tr>
                     <th>No </th>
                       <th>Event</th>
                     <th>Nama</th>
                     <th>Email</th>
                      <th>Wilayah</th>
                     <th>Kampus Impian</th>
                      <th>Asal Sekolah</th>
                     <th>Login</th>
                    

                   </tr>
                 </thead>
                 <tbody>


                 <?php 
                     error_reporting(0);
                    $no = 1;
                    foreach($event as $l){
                         $event = $this->db->query('select * from event where id_event="'.$l->id_event.'"')->row();
                 ?>
                        <tr>
                            <td><?php echo $no++;?></td>
                             <td><?php echo $event->judul;?></td>
                            <td><?php echo $l->nama;?></td>
                            <td><?php echo $l->email;?></td>
                             <td><?php echo $l->wilayah;?></td>
                              <td><?php echo $l->kampus_impian;?></td>
                               <td><?php echo $l->asal_sekolah;?></td>
                            <td><?php echo TanggalIndo($l->create_add). ' ' .date('H:i:s',strtotime($l->create_add))?></td>
                        </tr>
                 <?php 
                    }
                 ?>
                    



                 </tbody>

            </table>