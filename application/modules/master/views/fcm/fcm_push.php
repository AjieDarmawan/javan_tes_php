<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Soal</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->

                   
                    <form action="<?php echo base_url('master/fcm/blast') ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group mb-8">

                            </div>


                          
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Title</label>
                                <div class="col-8">
                                    <input class="form-control" rows="4" name="title" type="text" id="jawaban_a"> 
                                </div>
                              
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Body</label>
                                <div class="col-10">
                                    <textarea class="form-control" name="body" type="text" id="body" rows="14" cols="50"></textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Link Img</label>
                                <div class="col-8">
                                    <input class="form-control" rows="4" name="img" type="text" id="jawaban_a"> 
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
                                    <button type="submit" class="btn btn-success mr-2">Kirim</button>
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