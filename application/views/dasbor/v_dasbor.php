<?php
error_reporting(0);
?>

<section class="content">
    <div id="refresh_maps"></div>      
        <script>
                 $('#refresh_maps').slideDown('normal').load('<?php echo base_url(); ?>interkoneksi/refresh_map');

            setInterval(function () {
                 $('#refresh_maps').slideDown('normal').load('<?php echo base_url(); ?>interkoneksi/refresh_map');
                
            }, 60000);
        </script>      
          
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
<!-- /.content -->
