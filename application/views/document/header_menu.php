    <?php 
        //$header_menu = $this->uri->segment(2);
        $header_menu = base64_decode($this->uri->segment(3));
        $showMenu = $this->session->userdata('showMenu');
        
    ?>
    
    <div style="margin-bottom:10px;margin-top:10px;">
           <div class="col-md-8">
                <?php
                if($showMenu['all_menu']=="show"){
                ?>
                <a href="<?php echo base_url('document/');?>" class="btn btn-app <?php echo$header_menu==''?"bg-aqua":'';?>">
                    <i style="width:60px;" class="fa fa-files-o"></i> All
                </a>
                <?php
                }

                if($showMenu['policy']=="show"){
                ?>
                <a href="<?php echo base_url('document/Policy/').base64_encode('policy');?>" class="btn btn-app <?php echo$header_menu=='policy'?"bg-aqua":'';?>">
                    <i style="width:60px;" class="fa fa-files-o"></i> Policy
                </a>
                <?php
                }

                if($showMenu['sop']=="show"){
                ?>
                <a href="<?php echo base_url('document/Sop/').base64_encode('sop');?>" class="btn btn-app <?php echo$header_menu=='sop'?"bg-aqua":'';?>">
                    <i style="width:60px;" class="fa  fa-file-text"></i> SCRUM
                </a>
                <?php
                }

                if($showMenu['sk']=="show"){
                ?>
                <a href="<?php echo base_url('document/SK/').base64_encode('sk');?>" class="btn btn-app <?php echo$header_menu=='sk'?"bg-aqua":'';?> ">
                    <i style="width:60px;" class="fa fa-paste"></i> BAST
                </a>
                <?php
                }

                if($showMenu['se']=="show"){
                ?>
                <a  href="<?php echo base_url('document/SE/').base64_encode('se');?>" class="btn btn-app  <?php echo$header_menu=='se'?"bg-aqua":'';?> ">
                    <i style="width:60px;" class="fa fa-file">
                    </i> Pertanggungan
                </a>
                <?php
                }

                if($showMenu['memo']=="show"){
                ?>
                <a  href="<?php echo base_url('document/Memo/').base64_encode('memo');?>" class="btn btn-app <?php echo$header_menu=='memo'?"bg-aqua":'';?> ">
                    <i style="width:60px;" class="fa fa-save"></i> NDA
                </a>
                <?php
                }
                ?>
           </div>

           <div class="col-md-4" style="">
              <?php 
              if($search_box==true){
               ?>
              <form action="<?php echo $action;?>" method="post">
                  <div class="input-group add-on">

                      <input type="text" name="search" id="srch-term"  class="form-control" placeholder="Search" value="<?php echo$search;?>"  >
                      <div class="input-group-btn">
                          <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div>
                  </div>
              </form>
              <a style="cursor:pointer" data-toggle="modal" data-target="#modal-default">Advanced Search</a>
             <?php
              }
              ?>
           </div>
      </div>
      <script type="text/javascript">
      $(document).ready(function() {
            $('.datepicker').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd"
            })
        }); 
    </script>