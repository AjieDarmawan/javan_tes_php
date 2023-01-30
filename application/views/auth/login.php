<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login | E-Filling</title>
  <!-- Tell the browser to be responsive to screen width -->
  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/img/icon_telkomsat.png" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome-4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/ionicons-2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/AdminLTE.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<style>
#login {
  /*padding-top: 90px; */
  padding-bottom: 200px;  
  background: #0000; 
  background-image: url(<?php echo base_url('assets/img/'); ?>background_patrakom.png); 
  -webkit-background-size: cover; 
  -moz-background-size: cover; -o-background-size: cover; background-size: cover; 
  width:100%; 
  position: relative; 
  background-repeat: no-repeat;
  background-attachment: fixed;
}
</style>
<body class="hold-transition login-page">
<div id="login">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="login-box-body">
      <!-- <img src="<?php echo base_url('assets/img/'); ?>logo_telkomsat.png" class="img-responsive center-block" style="margin-top:20px"> -->
      <img src="<?php echo base_url('assets/img/'); ?>logo_telkomsat.png" style="width:35%;">
      <br>
      <center><h4><b>Easy Filling Application</b></h4></center>
      <br>
      <?php if (!empty($message)) {
    ?>
        <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
          <div id="infoMessage"><?php echo $message; ?></div>
        </div>
      <?php
} ?>
      <form action="<?php echo site_url('auth/login'); ?>" method="post">
        <div class="form-group has-feedback">
          <input type="text" name="username" class="form-control">
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="password" class="form-control">
        </div>
        <!--<div class="form-group has-feeds">
        <?php // echo $this->recaptcha->render(); ?>
        </div>-->
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-4 col-md-offset-8">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
      <!--<a href="forgot_password">I forgot my password</a><br>-->
    </div>
  <!-- /.login-box-body -->
  </div>
<!-- /.login-box -->
</div>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.js"></script>
</body>
</html>
