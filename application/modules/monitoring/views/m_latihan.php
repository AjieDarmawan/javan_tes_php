

<center><h3> Aktivitas Latihan </h3><center>
      <table id="example1" class="display nowrap table-striped table-bordered table" >
              <caption class="text-center"><br>
               </caption>
                <thead>
                   <tr>
                     <th>No </th>
                      <th>Event</th>
                      <th>Materi</th>
                     <th>Nama</th>
                     <th>Email</th>
                     <th>Login</th>
                     <!-- <th>Keycode</th>
                     <th>Device</th> -->

                   </tr>
                 </thead>
                 <tbody>



                 <?php 
                     error_reporting(0);
                    $no = 1;
                    foreach($latihan as $l){

                        $nama = $this->db->query('select * from log_login where email="'.$l->email.'"')->row();

                        $materi = $this->db->query('select * from materi where materi_id="'.$l->materi_id.'"')->row();

                        $event = $this->db->query('select * from event where id_event="'.$l->id_event.'"')->row();
                 ?>
                        <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $event->judul;?></td>
                            <td><?php echo $materi->materi_nama;?></td>
                            <td><?php echo $nama->nama;?></td>
                            <td><?php echo $l->email;?></td>
                            <td><?php echo TanggalIndo($l->create_add). ' ' .date('H:i:s',strtotime($l->create_add))?></td>
                        </tr>
                 <?php 
                    }
                 ?>
                    

                 </tbody>

            </table>

       

