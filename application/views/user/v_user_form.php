<div class="page-header">
<h1>User<br><small>MikroTik</small></h1>
<hr>
<p>
<form class="form-horizontal" name="frmtambah" method="post" action="<?php echo $form_action; ?>">
	
	<div class="form-group">
		<label class="col-md-2 control-label"  for="name">Name</label>
		<div class="col-md-4">
			<input class="form-control" type="text" name="name" id="name" placeholder="Name" value="<?php if (isset($default['name'])) { echo $default['name']; } ?>">
			<?php echo form_error('name', '<label class="control-label" for="name">', '</label>'); ?>	
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label"  for="group">Group</label>
		<div class="col-md-4">
			<select name="group" id="group" class="form-control">								
				<option value="full" <?php if (isset($default['group']) && ($default['group'] == 'full'|| $default['group'] == ' ')) { echo "selected"; } ?>>Full</option>
				<option value="read" <?php if (isset($default['group']) && $default['group'] == 'read') { echo "selected"; } ?>>Read</option>
				<option value="write" <?php if (isset($default['group']) && $default['group'] == 'write' ) { echo "selected"; } ?>>Write</option>
			</select>
		</div>
	</div>
		<div class="form-group">
		<label class="col-md-2 control-label"  for="password">password</label>
		<div class="col-md-4">
			<input class="form-control" type="password" name="password" id="password" placeholder="Password" value="<?php if (isset($default['password'])) { echo $default['password']; } ?>">
			<?php echo form_error('password', '<label class="control-label" for="password">', '</label>'); ?>	
		</div>
	</div>
		<!-- <div class="form-group">
		<label class="col-md-2 control-label"  for="passwordlagi">Confirm password</label>
		<div class="col-md-4">
			<input class="form-control" type="text" name="passwordlagi" id="passwordlagi" placeholder="Confirm Password" value="<?php if (isset($default['password'])) { echo $default['password']; } ?>">
			<?php echo form_error('password', '<label class="control-label" for="password">', '</label>'); ?>	
		</div>

</div> -->
	
	
	<div class="form-group">
		<label class="col-md-2 control-label" for="disabled">Disabled</label>
		<div class="col-md-3">			
			<label class="radio-inline"><input id="disabled" name="disabled" type="radio" value="yes" <?php if (isset($default['disabled']) && $default['disabled'] == 'yes') { echo "checked"; } ?>>Yes </label><label class="radio-inline"><input id="disabled" name="disabled" type="radio" value="no" <?php if (isset($default['disabled']) && $default['disabled'] == 'no') { echo "checked"; } ?>>no</label>
			</label>	
			<?php echo form_error('disabled', '<label class="control-label" for="disabled">', '</label>'); ?>			
		</div>
	</div>	
	
	<div class="form-group">
		<div class="col-md-offset-2 col-md-10">
			<button class="btn btn-primary" type="submit" name="btnsimpan">Simpan</button>
			<a class="btn btn-default" href="<?php echo base_url().'user'; ?>">Batal</a>
		</div>
	</div>
</form>
</p>
</div>