
    <?php 
        // echo "<pre>";
        // print_r($login);
    ?>

<center><h3> Aktivitas Register </h3><center>
       <table id="" class="display nowrap table-striped table-bordered table" style="width:100%;">
              <caption class="text-center"><br>
               </caption>
                <thead>
                   <tr>
                     <th>No </th>
                     <th>Nama</th>
                     <th>Email</th>
                      <th>No Tlpn</th>
                     <th>No Wa</th>
                     <th>Tgl Regis</th>
                  

                   </tr>
                 </thead>
                 <tbody>

                 <?php 
                 error_reporting(0);
                    $no = 1;
                    foreach($register as $l){
                 ?>
                        <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $l->namalengkap;?></td>
                            <td><?php echo $l->email;?></td>
                            <td><?php echo $l->notlp;?></td>
                            <td><?php echo $l->nowa;?></td>

                            
                            
                            <td><?php echo TanggalIndo($l->crdt). ' ' .date('H:i:s',strtotime($l->crdt))?></td>
                        </tr>
                 <?php 
                    }
                 ?>
                    

                 </tbody>

            </table>

           
           