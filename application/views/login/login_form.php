
<!DOCTYPE >
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MONITORING [SEMAR INTERMEDIA]</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/css/sweetalert2.min.css">


  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">

  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
        <h3><center><b>APLIKASI<br>[ MONITORING PELANGGAN ]</b></center></h3>
        
        <center>
  <p style="color: green;">
   SEMAR INTERMEDIA
  </p>
</center>

        
        <br>
    <form name="frmlogin" method="post" action="<?= $form_action ?>">
        
        
      <div class="form-group has-feedback">
      <div class="form-group has-feedback">
      <input type="username" class="form-control" placeholder="192.168.0.1:8728" id="hostname" name="hostname">
        
      </div>
     
      
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username Mikrotik" id="username" name="username" >
       
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password Mikrotik" id="password" name="password">
        
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-info pull-right">Sign In</button>
      </div>
        <center>
              <p style="color: magenta; animation: blink 3s linear infinite;">
                SUPPORT KAMI YA !<br>BANK BRI - 678701031728538
              </p>
        </center>

        <style>
          @keyframes blink {
            0% {
              opacity: 1;
            }
            50% {
              opacity: 0;
            }
            100% {
              opacity: 1;
            }
          }
        </style>

    </form>


  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?= base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= base_url()?>assets/js/sweetalert2.min.js"></script>
<script>
 var status = "<?= $this->session->flashdata('status')?>";
  if (status == "success") {
 Swal.fire({
              icon: 'success',
              title: '<?= $this->session->flashdata('msg')?>',
              showConfirmButton: false,
              timer: 2500
            })

  }else if(status == "error"){
    Swal.fire({
              icon: 'error',
              title: '<?= $this->session->flashdata('msg')?>',
              showConfirmButton: false,
              timer: 2500
            })}

</script>
</body>
</html>
