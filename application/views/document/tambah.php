<section class="content">
    <!-- Main row -->
    <div class="row">
        <?php $this->load->view('document/header_menu');?>
  
        <div class="col-md-12">
            <?php $this->load->view('layouts/alert'); ?>
            <?php // echo '<pre>'; print_r($this->session->userdata()); ?>
            <div class="nav-tabs-custom-aqua">
                <div class="tab-content">
               

         <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Tambah</h3>
            </div>
                        <div class="box-body">
                         <form id="form" action="<?php echo base_url('document/document_simpan')?>" method="post" enctype="multipart/form-data">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Kategori</label>
                                     <input type="" value="<?php echo $hasil?>" readonly class="form-control" name="kategori"/>
                              </div>
                          </div>

                          <?php 
                          if($setNomor=="text"){
                          ?>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor</label>
                                    <input type="<?php echo$setNomor;?>"  class="form-control nomor" id="nomor" placeholder="Nomor Surat" name="nomor" value="" >
                            </div>
                          </div>
                          <?php
                          }
                          ?>

                          <div class="col-md-12">
                              <div class="form-group">
                                  <label>Perihal</label>
                                      <input type="text" class="form-control nama" placeholder="Perihal" name="perihal" >
                              </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Terbit</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control datepicker" name="tanggal" value="<?php echo date('d-m-Y');?>">
                                    </div>
                            <!-- /.input group -->
                            </div>
                          </div>

                        <div class="col-md-6">
                                <div class="form-group">
                                <label>Tanggal Efektif</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control datepicker" name="tanggal_efektif"  >
                                    </div>
                                <!-- /.input group -->
                                </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Keyword</label>
                                    <textarea name="keyword" id="keyword" class="form-control"></textarea>
                            </div>
                        </div>

                      <div class="col-md-6">
                            <div class="form-group">
                                <label>Upload File</label>
                                    <input type="file" accept="application/pdf" class="form-control berkas" id="berkas"  name="berkas" >
                            </div>
                      </div>

                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label>Replace Dokumen</label>
                                    <input type="file" class="form-control nama" placeholder="nama kategori" name="replace" >
                            </div>
                        </div> -->
                            

                            
                            </div>
                            <div class="box-footer">
                                <div class="col-sm-6"> 
                                </div>
                                <div class="col-sm-6"> 
                                    <a  onclick="goBack()" class="btn btn-danger btn-sm">Kembali</a>
                                    <button type="submit" class="btn btn-success btn-sm tambah">Simpan</button>
                                </div>
                            </div>
                         </form>
                            <!-- /.box-body -->
                        </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
</section>


<script>
function goBack() {
  window.history.back();
}
</script>


<script>
  $(function () {
    //Initialize Select2 Elements
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format: "dd-mm-yyyy"
    })
  })
</script>

<script>
$(function()
{
    $("#form").validate(
      {
        rules:
        {
            nomor:
          {
            required: true
          },
          tanggal:
          {
            required: true
          },
          perihal:
          {
            required: true
          },
          tanggal_efektif:
          {
            required: true
          },
          berkas:
          {
            required: true
          },
          keyword:
          {
            required: true
          },
          kategori:
          {
            required: true
          },

        },
        messages:
        {
          nomor:
          {
            required: '<b><p style="color:red">X Harus diisi</p></b>',
          },
          tanggal:
          {
            required: '<b><p style="color:red">X Harus diisi</p></b>',
          },
          perihal:
          {
            required: '<b><p style="color:red">X Harus diisi</p></b>',
          },
          tanggal_efektif:
          {
            required: '<b><p style="color:red">X Harus diisi</p></b>',
          },
          keyword:
          {
            required: '<b><p style="color:red">X Harus diisi</p></b>',
          },
          berkas:
          {
            required: '<b><p style="color:red">X Harus diisi</p></b>',
          },
          kategori:
          {
            required: '<b><p style="color:red">X Harus diisi</p></b>',
          },

        }
      });
});
</script>
