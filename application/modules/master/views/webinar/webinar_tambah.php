<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Webinar</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->


                    <form action="<?php echo base_url('master/Webinar/simpan') ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group mb-8">

                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Gambar </label>

                                <div class="col-10">

                                    <input required="" type="file" name="img">
                                    <p style="color:red">Ukuran Gambar 370 X 525</p>
                                </div>
                            </div>








                            <div class="form-group row">
                                <label class="col-2 col-form-label">Topik</label>
                                <div class="col-10">
                                    <textarea class="form-control" name="topik" type="text" id="topik" rows="14" cols="50"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Tanggal</label>
                                <div class="col-10">
                                    <input class="form-control" name="tanggal" type="date" id="tanggal" rows="14" cols="50" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Waktu Mulai</label>
                                <div class="col-3">
                                    <select name="waktu_mulai_jam" class="form-control" required>
                                        <?php
                                        for ($x = 00; $x <= 24; $x++) {
                                            $number = str_pad($x, 2, '0', STR_PAD_LEFT);
                                        ?>
                                            <option value="<?php echo $number; ?>"><?php echo $number; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-3">
                                    <select name="waktu_mulai_menit" class="form-control" required>
                                        <option value="00">00</option>
                                        <?php
                                        for ($x = 01; $x <= 60; $x++) {
                                            $number = str_pad($x, 2, '0', STR_PAD_LEFT);
                                        ?>
                                            <option value="<?php echo $number; ?>"><?php echo $number; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Waktu Selesai</label>
                                <div class="col-3">
                                    <select name="waktu_selesai_jam" class="form-control" required>

                                        <?php
                                        for ($x = 00; $x <= 24; $x++) {
                                            $number = str_pad($x, 2, '0', STR_PAD_LEFT);
                                        ?>
                                            <option value="<?php echo $number; ?>"><?php echo $number; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-3">
                                    <select name="waktu_selesai_menit" class="form-control" required>
                                        <option value="00">00</option>
                                        <?php
                                        for ($x = 01; $x <= 60; $x++) {
                                            $number = str_pad($x, 2, '0', STR_PAD_LEFT);
                                        ?>
                                            <option value="<?php echo $number; ?>"><?php echo $number; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>




                            <div class="form-group row">
                                <label class="col-2 col-form-label">Pembicara</label>
                                <div class="col-8">
                                    <textarea class="form-control" rows="4" name="pembicara" type="text" id="pembicara"> </textarea>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jabatan Pembicara</label>
                                <div class="col-8">
                                    <textarea class="form-control" rows="4" name="jabatan_pembicara" type="text" id="jawaban_b"></textarea>
                                </div>

                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Moderator</label>
                                <div class="col-8">
                                    <textarea class="form-control" name="moderator" type="text" id="moderator"></textarea>
                                </div>

                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jabatan Moderator</label>
                                <div class="col-8">
                                    <textarea class="form-control" name="jabatan_moderator" type="text" id="jabatan_moderator"></textarea>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Link </label>
                                <div class="col-8">
                                    <textarea class="form-control" name="link" type="text" id="link"></textarea>
                                </div>

                            </div>


                             <div class="form-group row">
                                <label class="col-2 col-form-label">Link Group Wa</label>
                                <div class="col-8">
                                    <textarea class="form-control" name="share_link" type="text" id="share_link"></textarea>
                                </div>

                            </div>





                            <div class="form-group row">
                                <label class="col-2 col-form-label">Deskripsi</label>
                                <div class="col-8">
                                    <textarea class="form-control" rows="14" cols="50" name="desc" type="text" id="pembahasan"></textarea>
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


<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>