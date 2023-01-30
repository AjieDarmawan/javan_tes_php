<?php
if($this->uri->segment(2)=="Sop" OR $this->uri->segment(2)=="Policy"){
    $show_nomor = false;
}
else{
    $show_nomor = true;
}
?>
<!-- Modal -->
<div class="modal fade" id="modal-default"  role="dialog" aria-hidden="true" enctype="multipart/form-data">
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b>Advance Search</b></h4>
            </div>
            <div class="modal-body">
                <form id="formUpdateKategori" method="post" action="<?php //echo site_url('Document/advance_search');?>" class="form-horizontal" enctype="multipart/form-data">
                    <div class="box-body">
                    <?php 
                    if($show_nomor){
                    ?>
                        <div class="form-group">
                            <div class="col-md-3">
                                <label>Nomor</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control input-sm nama" placeholder="Nomor Surat" name="cari_no_surat" id="cari_no_surat" >
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                        <div class="form-group">
                            <div class="col-md-3">
                                <label>Perihal</label>
                            </div>
                            <div class="col-md-9">
                            <input type="text" class="form-control input-sm nama" placeholder="Perihal" name="cari_perihal" id="cari_perihal" >
                            </div>
                        </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Tanggal Surat</label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm datepicker" name="cari_tanggal_mulai" id="cari_tanggal_mulai">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-1">S/d</div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm datepicker" name="cari_tanggal_selesai"  id="cari_tanggal_selesai">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Keyword</label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control input-sm nama" name="cari_keyword" id="cari_keyword" placeholder="Ex : suku bunga, petunjuk pengisian, pedoman" ></textarea>
                            <span class="text-yellow" style="font-size:12px">* Jika lebih dari satu keyword, pisahkan keyword dengan tanda koma (,)</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Tangal Efektif</label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm datepicker" name="cari_tanggal_efektif_mulai" id="cari_tanggal_efektif_mulai" >
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-1">S/d</div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm datepicker" name="cari_tanggal_efektif_selesai" id="cari_tanggal_efektif_selesai" >
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    </div>
                    <div class="box-footer" style="font-size:12px">

                        <b>Note:</b><br>
                        <p>*Pencarian Tidak mengharuskan mengisi semua Field yang disediakan.</p>
                        <p>*Untuk Pencarian "Nomor","Perihal" dan "Keyword" dapat menggunakan tanda <b>koma (,)</b> untuk pencarian lanjutan.</p>
                        <p>Contoh : -Mencari Perihal Surat dengan kata kunci "Penjualan Mobil Kijang".<br>
                                     Dapat Menggunakan "penjualan" atau "mobil" atau "kijang" (tanpa tanda kutip)
                            
                        </p>

                    </div>
                    <div class="box-footer">
                        <div class="col-sm-12 "> 
                            <div class="pull-right">
                                <a  data-dismiss="modal" class="btn btn-default">Batal</a>
                                <button type="button" id="SubmitAdvanceSearch" class="btn btn-info ">Search</button>
                                
                            </div>
                        </div>
                    </div>
                            
                </form>
            </div>

        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->