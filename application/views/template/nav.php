 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section  class="sidebar">
       <div  class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url('assets/avatar.png') ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('username_mikrotik') ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        <li  class="header">MAIN NAVIGATION</li>

        <!-- Dasbor -->
        <li><a href="<?php echo base_url('dasbor') ?>"><i class="fa fa-dashboard"></i><span> DASHBOARD</span></a></li>
        <li><a href="<?php echo base_url('perangkat') ?>"><i class="fa fa-users"></i><span> PERANGKAT</span></a></li>
         <!-- menu berita -->

        
        


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div  class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <!--  <div class="box-header">
              <h3 class="box-title"> <?php echo $title ?></h3>
            </div> -->
            <!-- /.box-header -->
            <div class="box-body">
