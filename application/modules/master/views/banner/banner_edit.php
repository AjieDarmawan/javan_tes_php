<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Edit Banner</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                   
                    <form action="<?php echo base_url('master/banner/update_simpan') ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group mb-8">
                                <input type="hidden" name="id_banner" value="<?php echo $banner->id_banner?>"/>

                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Gambar</label>
                                <div class="col-10">

                                    <input type="file" name="img">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Kategori</label>

                            <div class="col-3">
                                    <select name="kategori" class="form-control" required>
                                         <option value="mobile" <?php  if($banner->kategori=="mobile"){echo "selected";}else{echo "";}  ?>>Mobile</option>
                                         <option value="web" <?php  if($banner->kategori=="web"){echo "selected";}else{echo "";}  ?>>Web</option>
                                           <option value="spescreen" <?php  if($banner->kategori=="spescreen"){echo "selected";}else{echo "";}  ?>>Spalschcreen</option>
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


<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>