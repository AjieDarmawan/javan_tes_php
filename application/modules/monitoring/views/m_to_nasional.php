
    <?php 
        // echo "<pre>";
        // print_r($login);
    ?>

<center><h3> Aktivitas </h3><center>
      <table id="" class="display nowrap table-striped table-bordered table" style="width:100%;
                        overflow-y:scroll;
                        overflow-x:scroll;
                        height:700px;
                        ">
              <caption class="text-center"><br>
               </caption>
               <thead>
                   <tr>
                                    <th></th>
                                    <th>Topik</th>
                                    <th>email</th>
                                    <th>nama</th>
                                    <th>wilayah</th>
                                    <th>no_wa</th>
                                    <th>kampus_impian</th>
                                    <th>jurusan_diinginkan</th>
                                    <th>asal_sekolah</th>
                                   

                                    <th>Provinsi</th>
                                    <th>Sumber Informasi</th>
                                    <th>Tingkatan</th>
                                    <th>Waktu Daftar</th>

                   </tr>
                 </thead>
                 <tbody>

                 <?php 
                    $no = 1;
                    foreach($to_nasional as $l){

                        if($l->topik==999){
                            $judul = "SOSHUM";
                        }elseif($l->topik==998){
                            $judul = "SAINTEK";
                        }else{
                            $judul ="";
                        }
                 ?>
                        <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $judul;?></td>
                            <td><?php echo $l->email;?></td>

                            <td><?php echo $l->nama;?></td>
                            <td><?php echo $l->wilayah;?></td>
                            <td><?php echo $l->no_wa;?></td>
                            <td><?php echo $l->kampus_impian;?></td>
                            <td><?php echo $l->jurusan_diinginkan;?></td>
                            <td><?php echo $l->asal_sekolah;?></td>
                            <td><?php echo $l->provinsi;?></td>

                            <td><?php echo $l->sumber_informasi;?></td>

                            <td><?php echo $l->tingkatan;?></td>
                            <td><?php echo  TanggalIndo($l->create_add)?></td>


                           
                        </tr>
                 <?php 
                    }
                 ?>
                    

                 </tbody>


            </table>

