<?php 
$filename='file-name'.'.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename=report_pendaftaran_event"'.$tanggal_awal.'-'.$tanggal_akhir.'".xls'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no c
?>


                        <table border="1" id="tabledivisi">
                            <thead>
                                <tr class="">
                                    <th>No</th>
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
                                $no=1;
                                foreach ($data as $e) {

                                    if($e->topik==999){
                                        $judul = "SOSHUM";
                                    }elseif($e->topik==998){
                                        $judul = "SAINTEK";
                                    }else{
                                        $judul = "Nyoba aja abaikan ya";
                                    }

                                  ?>

                                  <tr>
                                      <td><?php echo $no++;?></td>
                                      <td><?php echo $judul?></td>
                                      <td><?php echo $e->email?></td>
                                      <td><?php echo $e->nama?></td>
                                      <td><?php echo $e->wilayah?></td>
                                      <td><?php echo $e->no_wa?></td>
                                      <td><?php echo $e->kampus_impian?></td>
                                      <td><?php echo $e->jurusan_diinginkan?></td>
                                      <td><?php echo $e->asal_sekolah?></td>

                                      <td><?php echo $e->provinsi?></td>
                                      <td><?php echo $e->sumber_informasi?></td>
                                      <td><?php echo $e->tingkatan?></td>


                                      <td><?php echo TanggalIndo($e->create_add)?></td>

                                  </tr>
                                  
                                  


                                  <?php


          

                                  
                                 
                                 
                                }
                                ?>
                            </tbody>
                        </table>
                    