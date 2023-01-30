<!-- Main content -->
<section class="content">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view('layouts/alert'); ?>
            <?php // echo '<pre>'; print_r($this->session->userdata()); ?>
            <div class="nav-tabs-custom-aqua">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="<?php echo site_url('home/index'); ?>">
                            <i class="fa fa-paper-plane-o"></i> Tab 1
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url('home/index'); ?>">
                            <i class="fa fa-paper-plane-o"></i> Tab 2
                        </a>
                    </li>
                    
                    <li class="pull-right">
                        <a href="<?php echo site_url('home/index'); ?>" class="btn btn-default btn-flat">
                            <i class="glyphicon glyphicon-plus"></i> Tambah Data
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div class="tab-pane active">
                        <table  class="table table-striped" id="myTable" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="10">No</th>
                                    <th width="30">Kolom 1</th>
                                    <th width="60">Kolom 2</th>
                                    <th width="170">Kolom 3</th>
                                    <th width="100">Kolom 4</th>
                                    <th width="70">Kolom 5</th>
                                    <th width="50">Riwayat</th>
                                    <th width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>
                                        <a data-target="#myModal" href="<?php echo site_url('home/riwayat/1'); ?>" class="btn btn-info btn-sm btn-flat" data-toggle="modal"><i class="fa fa-search-plus"></i></a>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle" data-toggle="dropdown" style="width: 80px;" aria-expanded="false">Action  <span class="caret"></span></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="<?php echo site_url('home/view/1'); ?>"><span class="glyphicon glyphicon-zoom-in"></span> Details</a>
                                                    </li>
                                                    <li><a href="<?php echo base_url('home/edit/1'); ?>"><span class="glyphicon glyphicon-pencil"></span> Ubah</a>
                                                    </li>
                                                    <li><a href="<?php echo base_url('home/update/'); ?>'+full.id+'"><span class="glyphicon glyphicon-pencil"></span> Update</a>
                                                    </li>
                                                    <li><a onclick="return confirm('Anda Yakin akan menghapus?')" href="<?php echo base_url('home/delete/1'); ?>"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                                                    </li>
                                                </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->
<script>
$(document).ready(function () {
    $('#myTable').DataTable({
        "processing": true, // for show progress bar
        // "serverSide": true, // for process server side
        "orderMulti": false, // for disable multiple column at once
        "dom": '<"top"i>rt<"bottom"lp><"clear">',
        // "ajax": {
        //     "url": "<?php echo site_url('home/ajax_load_data'); ?>",
        //     "type": "POST",
        //     "datatype": "json"
        // },
        // "oLanguage" : {sProcessing: "<div id='loader'><img src='<?php echo base_url('assets/img/loading-exasoft.gif'); ?>'> Loading Data</div>"},
        // "columns": [
        //     { "data": "nomor" },
        //     { "data":"kolom_1" },
        //     { "data":"kolom_2" },
        //     { "data":"kolom_3" },
        //     { "data":"kolom_4" },
        //     { "data":"kolom_5" },
        //     { 
        //         "data": "id",
        //         "render": function(data,type,full,meta){
        //             return '<a data-target="#myModal" href="<?php echo site_url('home/riwayat'); ?>'+full.id+'" class="btn btn-info btn-sm btn-flat" data-toggle="modal"><i class="fa fa-search-plus"></i></a>';
        //         }
        //     },
        //     {
        //         "data": "id",
        //         "render": function(data, type, full, meta){
        //             return '<div class="btn-group">'+
        //                         '<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle" data-toggle="dropdown" style="width: 80px;" aria-expanded="false">'+
        //                             'Action  <span class="caret"></span>'+
        //                         '</button>'+
        //                         '<ul class="dropdown-menu" role="menu">'+
        //                             '<li><a href="<?php echo site_url('home/view/'); ?>'+full.id+'">'+
        //                                 '<span class="glyphicon glyphicon-zoom-in"></span> Details'+
        //                             '</a></li>'+
        //                             '<li>'+
        //                             '<a href="<?php echo base_url('home/edit/'); ?>'+full.id+'">'+
        //                                 '<span class="glyphicon glyphicon-pencil"></span> Ubah'+
        //                             '</a>'+
        //                             '</li>'+
        //                             '<li>'+
        //                             '<a href="<?php echo base_url('home/update/'); ?>'+full.id+'">'+
        //                                 '<span class="glyphicon glyphicon-pencil"></span> Update'+
        //                             '</a>'+
        //                             '</li>'+
        //                             '<li>'+
        //                                 '<a onclick="return confirm(\'Anda Yakin akan menghapus?\')" href="<?php echo base_url('home/delete/'); ?>'+full.id+'">'+
        //                                     '<i class="glyphicon glyphicon-trash"></i> Hapus</a>'+
        //                             '</li>'+
        //                         '</ul>'+
        //                     '</div>';
        //         }
        //     }
        // ]
    });
});
</script>