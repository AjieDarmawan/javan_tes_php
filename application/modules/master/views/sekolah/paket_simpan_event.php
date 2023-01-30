<div class="container pt-5">
    <h3><?= $title ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a>Rencana Event Paket</a></li>
            <li class="breadcrumb-item active" aria-current="page">List Data</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">

            <div mb-2>
                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->

                <?php $this->load->view('layouts/alert'); ?>

                <?php 

                        // echo "<pre>";
                        // print_r($paket);
                    ?>


            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <form action="<?php echo base_url('master/sekolah/paket_simpan_event_simpan')?>" method="post">

                        <input type="hidden" name="id_paket" value="<?php echo $id_paket?>">
                        <input type="hidden" name="id_sekolah" value="<?php echo $id_sekolah?>">
                        <table class="table table-striped table-bordered table-hover" id="tabledivisi">
                            <thead>
                                <tr class="table-success">
                                    <th></th>

                                    <th>Nama Event </th>
                                    <th>Tgl Mulai  </th>
                                    <th>Tgl Selesai</th>
                                    <th>Keterangan</th>
                                    <th>No Urut</th>
                                    <th>Status</th>




                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                        $no=1;
                                        foreach($paket as $p){
                                    ?>
                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td><?php echo $p->judul?>  <input type="hidden" name="id_event[]" value="<?php echo $p->id_event?>" >  </td>
                                    <td><input type="date" name="tgl_mulai_sekolah[]" value="<?php echo $p->tgl_mulai;?>"></td>
                                    <td><input type="date"name="tgl_selesai_sekolah[]" value="<?php echo $p->tgl_selesai;?>"></td>
                                    <td><?php echo $p->desc?></td>
                                    <td><?php echo $p->no_urut_paket?> <input type="hidden" name="no_urut_paket[]" value="<?php echo $p->no_urut_paket?>" </td>
                                    <td>
                                            <select class="form-control" name="publish[]" required >
                                                <option value="">--Pilih--</option>
                                                <option value="0">Belum Publish</option>
                                                <option value="1">Publish</option>
                                            </select>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    ?>
                            </tbody>

                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>