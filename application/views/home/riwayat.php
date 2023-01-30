<div class="modal-header bg-info">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $icon; ?> <?php echo $title; ?></h4>
</div>
<div class="modal-body">
    <div style="overflow-y:auto">
    <table class="table table-striped datatable2" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="10px">No</th>
                <th width="200px">Tanggal</th>
                <th>Kategori</th>
                <th>Issue</th>
                <th>Issue Detail</th>
                <th>Keterangan</th>
                <th>Nilai</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no=0;
        foreach ($riwayat as $key) {
            $nilai = $key->nilai == NULL ? $key->eqv_nilai_invoice : $key->nilai;
        ?>
            <tr>
                <td><?php echo ++$no;?></td>
                <td><?php echo date('d F Y',strtotime($key->date));?></td>
                <td><?php echo $key->status_kategori;?></td>
                <td><?php echo $key->issue;?></td>
                <td><?php echo $key->issue_detail;?></td>
                <td><?php echo $key->keterangan!=""? $key->keterangan :"-" ;?></td>
                <td><?php echo 'Rp '.number_format($nilai,false,false,'.');?></td>
                <td><?php echo $key->nama;?></td>
            </tr>
        <?php
        }
        ?>
            
        </tbody>
    </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
</div>