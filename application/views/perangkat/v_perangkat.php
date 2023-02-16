<p>
	<a href="<?= site_url('perangkat/add'); ?>" class="btn btn-success pull-left">
		Tambah Perangkat
	</a>
</p>
<br>
<br>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Jumlah Perangkat (<?= count($perangkat); ?>)</h3>
	</div>
<div class="table-responsive">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>

					<th>No.</th>
					<th>Pelanggan</th>
					<th>Lokasi</th>
					<th>Jenis</th>
					<th>IP Perangkat</th>
					<th>Interval</th>
					<th>Timeout</th>
					<th>Waktu</th>
					<th>Status</th>
					<th>Disabled</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php

                if ($total_results > 0){
                $no=1;foreach ($perangkat as $key ) {
					$id = $key['.id'];
					$host = $key['host'];

					if (isset($key['comment'])){
                        $comment = explode("/", $key['comment']);
                        }

                  ?>
				<tr>
					<td><?= $no ?></td>
					<td>
						<?php if (isset($key['comment'])){echo $comment[0];}else{echo "";}; ?>
					</td>
					<td>
						<?php if (isset($key['comment'])){echo $comment[1];}else{echo "";}; ?>
					</td>
					<td>
						<?php if (isset($key['comment'])){echo $comment[2];}else{echo "";}; ?>
					</td>
					<td>
						<?php
                    if (isset($key['host'])){
                        echo $key['host'];
                        }else{
                         echo  "";
                        }
                  ?>
					</td>
					<td>
						<?php
                    if (isset($key['interval'])){
                        echo $key['interval'];
                        }else{
                         echo  "";
                        }
                  ?>
					</td>
					<td>
						<?php
                    if (isset($key['timeout'])){
                        echo $key['timeout'];
                        }else{
                         echo  "";
                        }
                  ?>
					</td>
					<td>
						<?php
                    if (isset($key['since'])){
                        echo $key['since'];
                        }else{
                         echo  "";
                        }
                  ?>
					</td>
					<td>
						<?php
				  $status = $key['status'];
                    if (isset($status)){?>
						<span id="<?= kata($host) ?>"
							class="label <?= $status=="up"? "label-success":"label-danger" ?>"><?=$status?></span>
						<?php   }else{
                         echo  "";
                        }
                  ?>
					</td>
					<td><?= $key['disabled']?></td>
					<td><a href="<?= site_url('interkoneksi/list/'.$id) ?>" class="btn btn-success btn-xs">Interkoneksi</a>
						<a href="<?= site_url('perangkat/edit/'.$id) ?>" class="btn btn-warning btn-xs">Edit</a>
						<a href="<?= site_url('perangkat/remove/'.$id) ?>" onclick="return confirm('Yakin Dihapus?')"
							class="btn btn-danger btn-xs">Hapus</a>
						<?php
                  if ($key['disabled'] == 'false'){?>
						<a href="<?= site_url('perangkat/disable/'.$id) ?>" class="btn btn-primary btn-xs">Disabled</a>
						<?php }else{ ?>
						<a href="<?= site_url('perangkat/enable/'.$id) ?>" class="btn btn-info btn-xs">Enabled</a>

						<?php } ?>
					</td>
				</tr>
				<?php $no++;}} ?>

			</tbody>
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
			'paging': true,
			'lengthChange': false,
			'searching': false,
			'ordering': true,
			'info': true,
			'autoWidth': false
			
		})
	})
</script>
