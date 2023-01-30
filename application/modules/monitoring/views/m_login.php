
    <?php 
        // echo "<pre>";
        // print_r($login);
    ?>

<center><h3> Aktivitas Login Harian </h3><center>
      <table id="example" class="display nowrap table-striped table-bordered table" style="width:100%;">
              <caption class="text-center"><br>
               </caption>
                <thead>
                   <tr>
                     <th>No </th>
                     <th>Nama</th>
                     <th>Email</th>
                     <th>Login</th>
                     <!-- <th>Keycode</th>  -->
                     <th>Device</th>

                   </tr>
                 </thead>
                 <tbody>

                 <?php 
                    $no = 1;
                    foreach($login as $l){
                 
                        if($l->device_id){
                             $device =  $l->device_id;    
                        }else{
                             $device =  "Web";    
                        }
                   
                 ?>
                        <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $l->nama;?></td>
                            <td><?php echo $l->email;?></td>
                            <td><?php echo TanggalIndo($l->last_login). ' ' .date('H:i:s',strtotime($l->last_login))?></td>
                             <td><?php echo $device;?></td>
                        </tr>
                 <?php 
                    }
                 ?>
                    

                 </tbody>

            </table>

           
           