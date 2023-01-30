<style>
    a.disabled {
        pointer-Webinars: none;
        cursor: default;
    }
</style>

<div class="container pt-5">
    <h3><?= $title ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a>Pendaftar Event</a></li>
            <li class="breadcrumb-item active" aria-current="page">List Data</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
         
            <div mb-2>
                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                <br>


                <form>
                    <label>Tgl Mulai</label>
                    <input type="date" name="mulai" value="<?php echo $tanggal_awal; ?>">

                    <label>Tgl Akhir</label>
                    <input type="date" name="selesai" value="<?php echo $tanggal_akhir; ?>">

                    <button type="submit" class="btn btn-primary btn-sm">Cari ..</button>


                    <a class="btn btn-success btn-sm" href="<?= base_url('report/pendaftar_event/print/' . $tanggal_awal . '/' . $tanggal_akhir); ?>"  >Print</a>
                </form>
                <?php $this->load->view('layouts/alert'); ?>


            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tabledivisi">
                            <thead>
                                <tr class="table-success">




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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/template/assets/plugins/global/plugins.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/template/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/template/assets/js/scripts.bundle.js"></script>



<!--begin::Page Vendors(used by this page)-->
<script src="<?php echo base_url(); ?>assets/template/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->


<script>
    //setting datatables
    $('#tabledivisi').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            //panggil method ajax list dengan ajax
            "url": '<?php echo base_url('report/Pendaftar_event/ajax_list/'.$tanggal_awal.'/'.$tanggal_akhir) ?>',
            "type": "POST"
        }
    });
</script>