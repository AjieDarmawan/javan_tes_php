<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Event</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form action="<?php echo base_url('master/event/simpan')?>" method="post"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group mb-8">

                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama Event</label>
                                <div class="col-10">
                                    <input class="form-control" name="judul" type="text" id="event" />
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Model Event</label>
                                <div class="col-10">
                                    <select onchange="pilih_paket(this)" name="model_event" class="form-control">
                                        <option value="">--Pilih--</option>
                                        <option value="0">Umum</option>
                                        <option value="1">Kedinasan</option>
                                        <option value="2">Mandiri</option>
                                        <option value="3">Sekolah</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Paket </label>
                                <div class="col-10">
                                    <select class="form-control"  id="id_paket" name="id_paket">
                                        <option value="0">--PILIH--</option>
                                        <?php 
                                            foreach($paket as $p){
                                                ?>
                                        <option value="<?php echo $p->id_paket?>">
                                            <?php echo $p->nama_paket?>
                                        </option>
                                        <?php     
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">No Urut Paket</label>
                                <div class="col-10">
                                    <select  name="no_urut_paket" id="no_urut_paket" class="form-control">
                                        <option value="0">--Pilih--</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>

                                    </select>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Kategori Nama</label>
                                <div class="col-10">
                                    <select name="id_kategori" class="form-control">
                                        <?php 
                                                foreach($kategori as $j) {
                                                    ?>
                                        <option value="<?php echo $j->id_kategori?>"><?php echo $j->kategori_nama?>
                                        </option>

                                        <?php       
                                                }
                                            ?>

                                    </select>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Tanggal Mulai</label>
                                <div class="col-10">
                                    <input class="form-control" name="tgl_mulai" type="date" id="event" />
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Tanggal Selesai</label>
                                <div class="col-10">
                                    <input class="form-control" name="tgl_selesai" type="date" id="event" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Deskripsi</label>
                                <div class="col-10">
                                    <textarea class="form-control" name="desc" type="text" id="event"></textarea>
                                </div>
                            </div>


                            <!-- <div class="form-group row">
                                <label class="col-2 col-form-label">Gambar</label>
                                <div class="col-10">
                                    <input class="form-control" name="file" type="file" 
                                        id="event" />
                                </div>
                            </div> -->


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Mode</label>
                                <div class="col-10">
                                    <select class="form-control" name="status">
                                        <option value="">--PILIH--</option>
                                        <option value="event">Event</option>
                                        <option value="latihan">Latihan</option>
                                    </select>
                                </div>
                            </div>



                            <!--begin: Code-->
                            <div class="example-code mt-10">
                                <div class="example-highlight">
                                    <pre style="height:400px">


                                </div>
                            </div>
                            <!--end: Code-->
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-10">
                                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--end::Card-->

            </div>
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

<script>
    function pilih_paket(e){
        var id_paket = e.value;
        //alert(id_paket);

        if(id_paket==3){
            $('#id_paket').show();
            $('#no_urut_paket').show();
        }else{
            $('#id_paket').hide();
            $('#no_urut_paket').hide();
        }
    }
</script>