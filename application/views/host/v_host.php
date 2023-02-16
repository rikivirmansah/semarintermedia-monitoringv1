<?php
if ($this->session->flashdata('message')) {
    echo '<div class="alert alert-success">';
    echo $this->session->flashdata('message');
    echo '</div>';
}

 ?>
<p>
    <!--  <a href="<?php echo site_url('ipbinding/add'); ?>" class="btn btn-success pull-left">
            Tambah Data Ip Binding
        </a> -->
 </p>

 <div class="box">
            <div class="box-header">
              <h3 class="box-title">Host hotspot Active (<?php echo $total_results; ?>)</h3>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead style="border: 3px solid #222d32; background: #f39c12;"  class=thead-green>
                <tr>
                  <th>No.</th>
                  <th>MAC Address</th>
                  <th>Address</th>
                  <th>To Address</th>
                  <th>Server</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($total_results > 0){
                $no=1;foreach ($hotspot_host as $key ) {
                  ?>
                <tr>
                  <td><?php echo $no ?></td>
                  <td>
                  <?php
                    if (isset($key['mac-address'])){
                        echo $key['mac-address'];
                        }else{
                         echo  "";
                        }
                  ?>
                  </td>
                  <td>
                  <?php

                        echo $key['address']

                  ?>
                  </td>

                  <td>
                  <?php
                    if (isset($key['to-address'])){
                        echo $key['to-address'];
                        }else{
                         echo  "";
                        }
                  ?>
                  </td>
                  <td>
                    <?php
                      if (isset($key['server'])){
                          echo $key['server'];
                          }else{
                           echo  "";
                          }
                    ?>
                  </td>



                 <td><a href="<?php echo site_url('host/binding/'.$key['.id']) ?>" class="btn btn-success btn-xs">Make-Binding</a>
                  <a href="<?php echo site_url('host/remove/'.$key['.id']) ?>" class="btn btn-danger btn-xs">Remove</a>
                  </td>
                  </tr>
                <?php $no++;}} ?>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <script>
    $(function () {
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })
    })
  </script>
