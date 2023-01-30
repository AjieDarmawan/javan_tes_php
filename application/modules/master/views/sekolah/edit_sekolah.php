<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Edit Sekolah</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form action="<?php echo base_url('master/sekolah/edit_sekolah_simpan')?>" method="post"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group mb-8">

                            </div>

                            <input name="id_sekolah" type="hidden" value="<?php echo $data_sekolah->id_m_sekolah?>" type="" >
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama Sekolah</label>
                                <div class="col-10">
                                    <input class="form-control" disabled value="<?php echo $data_sekolah->nama_sekolah?>" name="judul" type="text" id="event" />
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Email </label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $data_sekolah->email?>" name="email" type="email" id="event" />
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama </label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $data_sekolah->nama_pendaftar?>" name="nama" type="text" id="event" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jumlah Siswa </label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $data_sekolah->jumlah_siswa?>" name="jumlah_siswa" type="text" id="event" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">No Wa</label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $data_sekolah->no_wa?>" name="no_wa" type="text" id="event" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Password</label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $data_sekolah->password?>"  disabled name="no_wa" type="text" id="event" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Upload Foto Sekolah</label>
                                <div class="col-10">
                                    <input class="form-control"  name="img" type="file" id="event" />
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