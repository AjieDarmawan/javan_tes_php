<?php 
$filename='file-name'.'.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename=report_hasil_irt'.$judul.'".xls'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no c

?>
<html>

<body>


    <center><h3><?php echo $judul;?></h3></center>



    <!-- HIDDEN -->

    <?php
    foreach ($irt->data_array_rata_rata as $d) {
    ?>
        <!-- <td><?php echo (1 - ($d->jumlah / $irt->jumlah_peserta)) * 100 ?></td> -->
    <?php

        $data_array_bobot[$d->soal_id] = array(
            'soal_id' => $d->soal_id,
            'bobot' => (1 - ($d->jumlah / $irt->jumlah_peserta)) * 100,
        );
    }
    ?>

    <?php


    // echo "<pre>";
    // print_r($data_array_bobot);
    ?>








   <?php


            foreach ($irt->data_ as $d) {

                foreach ($d->data_array_jawaban as $j) {


                    //    echo "<pre>";
                    //    print_r($j);

                        if ($j->hasil_pilihan == 1) {
                            $color = 'style="color:blue"';
                            $hasil_benar[$d->email][]  = $j->hasil_pilihan;
                        }

                        else if ($j->hasil_pilihan == 2) {
                            $color = 'style="color:red"';
                            $hasil_salah[$d->email][]  = $j->hasil_pilihan;
                        }
                        
                        
                        else if ($j->hasil_pilihan == 0) {
                            $color = 'style="color:black"';
                            $hasil_kosong[$d->email][]  = $j->hasil_pilihan;
                        }
                    ?>


                  

                    <?php
                    }
            ?>

               

            <?php
                     error_reporting(0);
                        $data_desc[] = array(
                            'email'=>$d->email,
                            'waktu'=>$d->waktu,
                            'skor_benar'=>     count($hasil_benar[$d->email]),
                            'skor_salah'=>   count($hasil_salah[$d->email]),
                            'skor_kosong'=>    count($hasil_kosong[$d->email]),
                           'jawaban'=> $d->data_array_jawaban,
                            
                        );

     
                      
            }

           $data_hasil =  sortAssociativeArrayByKey($data_desc, 'skor_benar', 'DESC');


         echo "total_peserta ".   $total_peserta = count($data_hasil);

            // echo "total_peserta ".   $total_peserta = 16;

         echo "<br>";

         echo "kelompok_atas ".   $kelompok_atas = floor(0.27 * $total_peserta);
         echo "<br>";
         echo "kelompok_bawah ".  $kelompok_bawah = floor(0.27 * $total_peserta);
         echo "<br>";
         echo "kelompok_tengah ". $kelompok_tengah = $total_peserta - $kelompok_atas - $kelompok_bawah;

         echo "<br>";




         //array perkelompok;
                $a_benar = array();
                $a_salah =  array();
                $b_benar =  array();
                $b_salah =  array();
                $a_ga_salah = array();
                $b_ga_salah =  array();
                $tot_ga_salah =  array();
              foreach($data_hasil as $d_no =>$key){
                  //kelompok atas

                  if($d_no < $kelompok_atas){
                      $data_k_atas[] = $key;

                     foreach($key['jawaban'] as $id_soal=>$soal){
                        if($soal->hasil_pilihan!=2){
                                if($soal->hasil_pilihan==1){
                                    $a_benar[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                    $a_benar[$id_soal]['total'] += 1;

                                }

              
                                $a_ga_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                $a_ga_salah[$id_soal]['total'] += 1;
                       
                                $tot_ga_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                $tot_ga_salah[$id_soal]['total'] += 1;
                       
                            
                        }
                        
                       elseif($soal->hasil_pilihan==2){

                            $a_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                            $a_salah[$id_soal]['total'] += 1;


                        }

                        

                       


                     }


                  }


                  else if($d_no >= $kelompok_atas+$kelompok_tengah){
                     $data_k_bawah[] = $key;


                     foreach($key['jawaban'] as $id_soal=>$soal){
                        if($soal->hasil_pilihan!=2){
                                if($soal->hasil_pilihan==1){
                                    $b_benar[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                    $b_benar[$id_soal]['total'] += 1;

                                }
                                    $b_ga_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                    $b_ga_salah[$id_soal]['total'] += 1;


                                    $tot_ga_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                    $tot_ga_salah[$id_soal]['total'] += 1;
                           
                            
                        }
                        
                       elseif($soal->hasil_pilihan==2){

                            $b_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                            $b_salah[$id_soal]['total'] += 1;


                        }

                
                     }




                  }

                  else{
                    $data_k_tengah[] = $key;


                    foreach($key['jawaban'] as $id_soal=>$soal){
                        if($soal->hasil_pilihan!=2){
                              

                                    $tot_ga_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                    $tot_ga_salah[$id_soal]['total'] += 1;
                           
                            
                        }
                        
                       

                
                     }


                    

                  }

                
                 // die;


                  foreach($key['jawaban'] as $id_soal=>$soal){

                    if($a_salah[$id_soal]['total']){
                        $a_salah_tot = $a_salah[$id_soal]['total'];
                    }else{
                        $a_salah_tot = 0;
                    }


                    if($a_ga_salah[$id_soal]['total']){
                        $a_ga_salah_tot = $a_ga_salah[$id_soal]['total'];
                    }else{
                        $a_ga_salah_tot = 0;
                    }


                    if($b_salah[$id_soal]['total']){
                        $b_salah_tot = $b_salah[$id_soal]['total'];
                    }else{
                        $b_salah_tot = 0;
                    }

                    if($b_ga_salah[$id_soal]['total']){
                        $b_ga_salah_tot = $b_ga_salah[$id_soal]['total'];
                    }else{
                        $b_ga_salah_tot = 0;
                    }


                    if($tot_ga_salah[$id_soal]['total']){
                        $tot_ga_salah_tot = $tot_ga_salah[$id_soal]['total'];
                    }else{
                        $tot_ga_salah_tot = 0;
                    }





                   //tingsul Tingkat kesulitan = (asalah+bsalah)/(agasalah+bgasalah) 
                    $tingsul[$id_soal] = ($a_salah_tot +  $b_salah_tot)/($kelompok_atas +  $kelompok_bawah);

                   
                   
                    //tingsulmax Tingkat kesulitan max = (agasalah+bgasalah)/(agasalah+bgasalah)
                   // $tingsul_max[$id_soal] = ($a_ga_salah_tot +  $b_ga_salah_tot)/($a_ga_salah_tot +  $b_ga_salah_tot);
                   $tingsul_max[$id_soal] = 1;  

                    //ptingsul Point tingkat kesulitan = (tingsul / tingsulmax) * 100
                    $ptingsul[$id_soal] = ($tingsul[$id_soal] / $tingsul_max[$id_soal]) * 100;



                        //dayabeda Daya Beda = (bsalah-asalah)/totgasalah
                        // $dayabeda[$id_soal] = ($b_salah_tot -  $a_salah_tot)/$tot_ga_salah_tot;
                        $dayabeda[$id_soal] = ($b_salah_tot -  $a_salah_tot)/($kelompok_atas +  $kelompok_bawah);


                      
                        // dayabedamax = agasalah/totgasalah
                       // $dayabedamax[$id_soal] = $a_ga_salah_tot/$tot_ga_salah_tot;
                       $dayabedamax[$id_soal] = $kelompok_bawah/($kelompok_atas +  $kelompok_bawah);


                        // pdayabeda point dayabeda = dayabeda/(2*dayabedamax)*100
                        $pdayabeda[$id_soal] = $dayabeda[$id_soal]/(2*$dayabedamax[$id_soal])*100;





                        //Bobot soal = (ptingsul+pdayabeda)/2

                        $bobotsoal[$id_soal] = array('id_soal'=>$id_soal,
                    'bobot'=>($ptingsul[$id_soal]+$pdayabeda[$id_soal])/2);


                  }
               







              }  




                    // echo "<pre>a_salah";
                    // print_r($data_hasil);
                    // echo "<pre>b_salah";
                    // print_r($b_salah);



                    //echo ($a_salah['2956']['total'] +  $b_salah['2956']['total'])/($a_ga_salah['2956']['total'] +  $b_ga_salah['2956']['total']);


            //         echo "a_salah".$a_salah['2956']['total']; 
            //         echo "<br>";
            //         echo "b_salah".$b_salah['2956']['total'];
            //         echo "<br>";
            //         echo "a_ga_salah".$a_ga_salah['2956']['total']; 
            //         echo "<br>";
                    
            //         echo "b_ga_salah".$b_ga_salah['2956']['total'];
            
            //   echo "<pre>tingsul";
            //   print_r($tingsul);
            //   echo "<pre>tingsul_max";
            //   print_r($tingsul_max);
            //   echo "dayabeda<pre>";
            //   print_r($dayabeda);
            //   echo "<pre>dayabedamax";
            //   print_r($dayabedamax);
            //   echo "<pre>ptingsul";
            //   print_r($ptingsul);
            //   echo "<pre>pdayabeda";
            //   print_r($pdayabeda);
            //   echo "<pre>bobotsoal";
            //   print_r($bobotsoal);
            

            

          //  echo count($tot_ga_salah);


            //   foreach($data_k_atas as $key => $k ){
            //       echo "<pre>";
            //        print_r($k['jawaban']);
            //    // print_r($key);
            
            
            
            //     }

            // echo "<pre>data_k_atas";
            //         print_r($data_k_atas);
            //         echo "<pre>data_k_bawah";
            //         print_r($data_k_bawah);

            
        

          


            ?>

<table border="1">

<thead>
    <td>Email</td>

    <?php
    foreach ($irt->data_array_rata_rata as $d) {
    ?>

        <td><?php echo $d->soal_id ?></td>

    <?php
    }
    ?>
    <td>Benar</td>
    <td>Salah</td>
    <td>Kosong</td>
  
    <td>Point </td>

</thead>

<tbody>
    <?php
    $rata_rata = 0;



                //    echo "<pre>";
                //    print_r($data_hasil['jawaban']);

    foreach ($data_hasil as $d) {
        ?>

            <tr>
                <td style="color:#2f6b10"><?php echo $d['email'] ?></td>

                <?php


                //    echo "<pre>";
                //    print_r($d);

              
                foreach ($d['jawaban'] as $j) {


               

                    if ($j->hasil_pilihan == 1) {
                        $color = 'style="color:blue"';
                        $hasil_benar[$d->email][]  = $j->hasil_pilihan;
                    }

                    else if ($j->hasil_pilihan == 2) {
                        $color = 'style="color:red"';
                        $hasil_salah[$d->email][]  = $j->hasil_pilihan;
                    }
                    
                    
                    else if ($j->hasil_pilihan == 0) {
                        $color = 'style="color:black"';
                        $hasil_kosong[$d->email][]  = $j->hasil_pilihan;
                    }
                ?>


                    <td <?php echo $color; ?>><?php echo $j->hasil_pilihan ?></td>

                <?php
                }
                ?>
               <td>
                   <?php  
                   error_reporting(0);
                    if($hasil_benar){
                        echo $d['skor_benar'];
                        // echo "<pre>";
                        // print_r($hasil_benar[$d->email]);
                    }else{
                        echo 0;
                    }
                  
                   
                   
                   ?> 
            
            
            
                </td>
                <td><?php echo $d['skor_salah'];?> </td>
                <td><?php echo $d['skor_kosong'];?> </td>

               

                <td>

                
                    <?php

                    $hitung_skor_kali = 0;
                    foreach ($d['jawaban'] as $j) {

                        // echo "<pre>";
                        // print_r($j);


                        if ($d['jawaban']->{$j->soal_id}->soal_id == $j->soal_id) {

                            if ($j->hasil_pilihan == 1) {


                               $hitung_skor_kali += $bobotsoal[$j->soal_id]['bobot'] * 1;

                               //echo $bobotsoal[$j->soal_id]['bobot'],'<br>';
                            }
                        }

                   

                       


                        
                    }

                    $rata_rata += $hitung_skor_kali;

                       echo $hitung_skor_kali;

                       $arr[] = $hitung_skor_kali;


                   

                        
                    
                    ?>


                </td>


                




            </tr>

        
                  

                
<?php

                  
        }

    

        ?>


            
    




        </tbody>



        <tfoot>
           

            <tr>
                <td style="background-color: #72889b;">Tingkat Kesulitan</td>

                <?php
                foreach ($tingsul as $t) {
                ?>

                    <td><?php echo $t ?></td>

                <?php
                }
                ?>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td style="background-color: #72889b;">Tingkat Kesulitan MAX</td>

                <?php
                foreach ($tingsul_max as $t) {
                ?>

                    <td><?php echo $t ?></td>

                <?php
                }
                ?>
                <td></td>
                <td></td>
            </tr>



            <tr>
                <td style="background-color: #72889b;">Daya Beda</td>
                <?php
                foreach ($dayabeda as $t) {
                ?>

                    <td><?php echo $t ?></td>

                <?php
                }
                ?>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td style="background-color: #72889b;">Daya Beda MAX</td>
                <?php
                foreach ($dayabedamax as $t) {
                ?>

                    <td><?php echo $t ?></td>

                <?php
                }
                ?>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td style="background-color: #72889b;">ptingsul</td>
                <?php
                foreach ($ptingsul as $t) {
                ?>

                    <td><?php echo $t ?></td>

                <?php
                }
                ?>
                <td></td>
                <td></td>
            </tr>


            <tr>
                <td style="background-color: #72889b;">pdayabeda</td>
                <?php
                foreach ($pdayabeda as $t) {
                ?>

                    <td><?php echo $t ?></td>

                <?php
                }
                ?>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td style="background-color: #72889b;">Bobotsoal</td>
                <?php
                foreach ($bobotsoal as $t) {
                ?>

                    <td><?php echo $t['bobot'] ?></td>

                <?php
                }
                ?>
                <td></td>
                <td></td>
            </tr>


            
            <tr>
                <td style="background-color: #72889b;">Rata - Rata</td>
                <td><?php echo $rata_rata / $total_peserta; ?></td>
            </tr>

            <tr>
                <td style="background-color: #72889b;">Deviasi</td>
                <td>

                    <?php echo sd($arr); ?>
                </td>

            </tr>
        </tfoot>


        </table>

    <br>

    <table border="1">
        <thead>
            <td>Z - Score</td>

            <td>CEEB</td>
        </thead>
        <tbody>
            <?php
            foreach ($arr as $a) {
                $z_score = ($a - ($rata_rata / $total_peserta)) / sd($arr);
            ?>
                <tr>
                    <td><?php echo $z_score;; ?></td>

                    <td><?php  $hasil_ =  round(500 + (200 * $z_score),2); ?>

                        <?php 
                            if($hasil_ > 1000){
                                // echo 1000;
                                echo $hasil_;
                            }
                            // else if($hasil_ < 0){
                            //     echo 0;
                            // }
                            else{
                                echo $hasil_;
                            }
                        ?>
                        

                    </td>

                    <?php $z_score_hasil[] =  500 + (200 * $z_score);; ?>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>

    <?php
    // echo "<pre>";
    // print_r($arr);

    ?>


</html>