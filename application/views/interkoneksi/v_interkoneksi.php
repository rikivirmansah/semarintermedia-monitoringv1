<p>
	<a href="<?= site_url('perangkat/add'); ?>" class="btn btn-success pull-left">
		Tambah Perangkat
	</a>

	<a href="<?= site_url('interkoneksi/add/'); ?><?= $id; ?>" class="btn btn-success pull-left">
		Tambah Interkoneksi
	</a>
</p>
<br>
<br>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Interkoneksi <?= $id; ?> -> IP (<?= $host; ?>)</h3>
	</div>
<div class="table-responsive">
		<table id="datatable" class="table table-bordered table-striped">
            <thead>
              <tr class="bg-green">
                <th width="5%">No</th>
                <th>Dari</th>
                <th>Ke</th>
                <th>Jenis</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $no=1;
                foreach ($data->result() as $data_interkoneksi) :
                ?>
                <tr>
                <td class="center">
                  <?php echo $no++; ?>
                </td>

                <td>
                  <?php
                  $id_interkoneksi=$id;
                  $id=$data_interkoneksi->id_awal;
                  $id_akhir=$data_interkoneksi->id_akhir;
                    if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
                    			$this->routerosapi->write("/tool/netwatch/print", false);			
                    			$this->routerosapi->write("=.proplist=.id", false);
                    			$this->routerosapi->write("=.proplist=host", false);	
                    			$this->routerosapi->write("=.proplist=comment", false);						
                    			$this->routerosapi->write("?.id=$id");
                    					
                    			$perangkat = $this->routerosapi->read();
                    
                    			foreach ($perangkat as $row)
                    			{
                    				if (isset($row['.id'])){
                    					$id = $row['.id'];
                    				}else{
                    					$id = '';
                    				}
                    				if (isset($row['host'])){
                    					$host = $row['host'];
                    				}else{
                    					$host = '';
                    				}
                    
                    				if (isset($row['comment'])){
                    					$comment = $row['comment'];
                    					$comment = explode("/", $row['comment']);
                    				}else{
                    					$comment = '';
                    				}
                    				                if (isset($row['disabled'])){
                    					$disabled = $row['disabled'];
                    				}else{
                    					$disabled = '';
                    				}
                    				
                    				
                    
                    				if ($disabled == 'true')
                    				{
                    					$disabled='yes';
                    				}else{
                    					$disabled='no';
                    				}
                    			}
                        		}                            
                        		echo $host;
                        		echo " - ";
                        		echo $comment[0];

                  ?>
                </td>
                <td>
                  <?php
                  $id=$id_akhir;
                               if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
                    			$this->routerosapi->write("/tool/netwatch/print", false);			
                    			$this->routerosapi->write("=.proplist=.id", false);
                    			$this->routerosapi->write("=.proplist=host", false);	
                    			$this->routerosapi->write("=.proplist=comment", false);						
                    			$this->routerosapi->write("?.id=$id");
                    					
                    			$perangkat = $this->routerosapi->read();
                    
                    			foreach ($perangkat as $row)
                    			{
                    				if (isset($row['.id'])){
                    					$id = $row['.id'];
                    				}else{
                    					$id = '';
                    				}
                    				if (isset($row['host'])){
                    					$host = $row['host'];
                    				}else{
                    					$host = '';
                    				}
                    
                    				if (isset($row['comment'])){
                    					$comment = $row['comment'];
                    					$comment = explode("/", $row['comment']);
                    				}else{
                    					$comment = '';
                    				}
                    				                if (isset($row['disabled'])){
                    					$disabled = $row['disabled'];
                    				}else{
                    					$disabled = '';
                    				}
                    				
                    				
                    
                    				if ($disabled == 'true')
                    				{
                    					$disabled='yes';
                    				}else{
                    					$disabled='no';
                    				}
                    			}
                        		}                            
                        		echo $host;
                        		echo " - ";
                        		echo $comment[0];

                  ?>
                </td>
                
                <td>
                    <?php echo $data_interkoneksi->jenis_interkoneksi ?>
                </td>


                <td>
                   

                    <a class="btn btn-danger btn-sm" title="Hapus" href="<?php echo base_url() ?>interkoneksi/deleteinterkoneksi/<?php echo $data_interkoneksi->id_interkoneksi; ?>/<?php echo $id_interkoneksi; ?>" onclick="return confirm('Anda Yakin mau di hapus?')">
                      <i class="fa fa-trash-o"></i>
                    </a>

                </td>
              </tr>
              <?php 
              endforeach; ?>
            </tbody>
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
			'paging': true,
			'lengthChange': false,
			'searching': false,
			'ordering': true,
			'info': true,
			'autoWidth': false
			
		})
	})
</script>
