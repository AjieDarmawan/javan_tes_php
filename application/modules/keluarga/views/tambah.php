<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Keluarga</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form action="<?php echo base_url('Keluarga/simpan')?>" method="post">
                        <div class="card-body">
                            <div class="form-group mb-8">
                               
                            </div>
                        
                        
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama </label>
                                <div class="col-10">
                                    <input class="form-control" name="nama" type="text"  required
                                        id="nama" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-10">
                                    <select name="jk" class="form-control">
                                            <option value="">--Pilih--</option>
                                            <option value="1">Laki - Laki</option>
                                            <option value="2">Perempuan</option>
                                    </select>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Status Keluarga</label>
                                <div class="col-10">
                                      <select name="status_keluarga" class="form-control">
                                                <option value="">--Pilih--</option>
                                                <option value="1">Ayah</option>
                                                <option value="2">Anak</option>
                                        </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Dari </label>
                                <div class="col-10">
                                      <select name="id_parent" class="form-control">
                                            <option value="">--Pilih--</option>
                                            <?php 
                                                foreach($keluarga as $k){
                                              ?>
                                                <option value="<?php echo $k->id_keluarga?>"><?php echo $k->nama?></option>
                                              <?php
                                                }
                                            ?>
                                           
                                        </select>
                                </div>
                            </div>
                            
                           
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