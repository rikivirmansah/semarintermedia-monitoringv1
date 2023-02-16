<?php 
if ($this->session->flashdata('message')) {
    echo '<div class="alert alert-success">';
    echo $this->session->flashdata('message');
    echo '</div>';
}
 ?>




<p>
     <a href="<?php echo site_url('user/add'); ?>" class="btn btn-success pull-left">
            Tambah User
        </a>
 </p>
 <br>
 <br>

 <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data User (<?php echo $total_results; ?>)</h3>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
       
                  <th>No.</th>
                  <th>Name</th>
                  <th>Group</th>
                  <th>Last Login</th>
                  <th>Disabled</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                if ($total_results > 0){
                $no=1;foreach ($user as $key ) { 
                  ?>
                <tr>
                  <td><?php echo $no ?></td>
                  <td>
                  <?php 
                    if (isset($key['name'])){
                        echo $key['name'];
                        }else{
                         echo  "";
                        }
                  ?>
                  </td>
                 
                  <td>
                  <?php 
                    if (isset($key['group'])){
                        echo $key['group'];
                        }else{
                         echo  "";
                        }
                  ?>
                  </td>
                  <td><?php
                   if (isset($key['last-logged-in'])){
                        echo $key['last-logged-in'];
                        }else{
                         echo  "";
                        }?></td>
                
                     
                  <td><?php echo $key['disabled']?></td>
                 
                  <td><a href="<?php echo site_url('user/edit/'.$key['.id']) ?>" class="btn btn-success btn-xs">Edit</a>
                  <a href="<?php echo site_url('user/remove/'.$key['.id']) ?>" class="btn btn-danger btn-xs">Remove</a>
                  <?php 
                  if ($key['disabled'] == 'false'){?>
                  <a href="<?php echo site_url('user/disable/'.$key['.id']) ?>" class="btn btn-primary btn-xs">Disabled</a>
                  <?php }else{ ?>
                  <a href="<?php echo site_url('user/enable/'.$key['.id']) ?>" class="btn btn-info btn-xs">Enabled</a>
                  
   <?php } ?>
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
