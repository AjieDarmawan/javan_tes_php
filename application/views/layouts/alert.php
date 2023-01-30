<?php 
if($this->session->flashdata('status') and $this->session->flashdata('message') != null){
?>
<div class="alert alert-<?php echo $this->session->flashdata('status') ?>" id="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo $this->session->flashdata('message') ?>
</div>
<?php
}
?>