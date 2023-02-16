<?php
error_reporting(0);
?>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <br /><br />
      <div class="box">
        <div class="box-body">
          <div class="table-responsive">
               
        <div id="refresh_maps"></div>      
        <script>
                 $('#refresh_maps').slideDown('normal').load('<?php echo base_url(); ?>interkoneksi/refresh_map');

            setInterval(function () {
                 $('#refresh_maps').slideDown('normal').load('<?php echo base_url(); ?>interkoneksi/refresh_map');
                
            }, 10000);
        </script>      
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
<!-- /.content -->
