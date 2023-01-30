
   <?php 
  // Function to calculate square of value - mean
function sd_square($x, $mean) { return pow($x - $mean,2); }
// Function to calculate standard deviation (uses sd_square)    
function sd($array) {
    // square root of sum of squares devided by N-1
    return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );
}
   ?>
    <?php
                foreach ($irt->data_array_rata_rata as $d) {
                ?>
                <?php
                        $data_array_bobot[$d->soal_id] = array(
                            'soal_id'=>$d->soal_id,
                            'bobot'=> (1 - ($d->jumlah / $irt->jumlah_peserta)) * 100,
                        );

                }
                ?>

    <?php
    $rata_rata = 0;
    foreach ($irt->data_ as $d) {
    ?>

            <?php
            foreach ($d->data_array_jawaban as $j) {
            ?>
               <?php  $j->hasil_pilihan ?>

            <?php
            }
            ?>
           <?php  $d->benar ?>
           
          
                <?php 
                        $hitung_skor_kali = 0;
                      foreach ($d->data_array_jawaban as $j) {

                        if($data_array_bobot[$j->soal_id]['soal_id'] ==$j->soal_id){

                                if($j->hasil_pilihan==1){

                               
                                    $hitung_skor_kali += $data_array_bobot[$j->soal_id]['bobot'] * 1;
                                }


                        }
                  ?>

                  
                  <?php
                      }

                      $rata_rata += $hitung_skor_kali;
                       $hitung_skor_kali;
                      $arr[] = $hitung_skor_kali;
                ?>

    <?php
    }
    ?>
        <?php
        foreach ($irt->data_array_rata_rata as $d) {
        ?>

           <?php  $d->jumlah ?>

        <?php
        }
        ?>
        <?php
        foreach ($irt->data_array_rata_rata as $d) {
        ?>

           <?php  1 - ($d->jumlah / $irt->jumlah_peserta) ?>

        <?php
        }
        ?>

        <?php
        foreach ($irt->data_array_rata_rata as $d) {
        ?>
           <?php   (1 - ($d->jumlah / $irt->jumlah_peserta)) * 100 ?>
        <?php
        }
        ?>
       
       <?php  $rata_rata/$irt->jumlah_peserta;?>
           <?php  sd($arr);?>
       <?php 
        foreach($arr as $key => $a){
           $z_score = ($a - ($rata_rata/$irt->jumlah_peserta)) / sd($arr);
            ?>
            
               <?php  $z_score; ;?>
                <?php   500 + (100 * $z_score);  ;?>
                 <?php $z_score_hasil[$irt->data_[$key]->email] =  500 + (100 * $z_score);  ;?>
        
         <?php   
        }
       ?>

<?php 
   
        echo json_encode($z_score_hasil);

        // echo "<pre>";
        // print_r($z_score_hasil);
?>




