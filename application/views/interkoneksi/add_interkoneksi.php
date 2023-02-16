<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Tambah Interkoneksi
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Data Interkoneksi</li>
    <li class="active">Tambah Interkoneksi</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">

      <br /><br />
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Form Tambah Interkoneksi <?= $id; ?> -> IP (<?= $host; ?>)</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="<?php echo base_url() ?>interkoneksi/proses_tambahinterkoneksi" method="post">
          <div class="box-body">
           <input type="hidden" name="id_awal" value="<?php echo "$id" ?>">

                <div class="form-group">
                  <label for="switchbts" class="col-sm-2 control-label">Jenis</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="jenis_interkoneksi" id="jenis_interkoneksi">
                      <option value="fo">FO</option>
                      <option value="lan">LAN</option>
                      <option value="wireless">Wireless</option>
                    </select>
                  </div>
                  </div>
                  
                    <div class="form-group">
                      <label for="bts" class="col-sm-2 control-label">Interkoneksi Tujuan</label>
                      <div class="col-sm-10">
                        <select class="form-control select" name="id_akhir" id="id_akhir" required>
                          <option value=""> -- Pilih Interkoneksi -- </option>
                          <?php foreach ($perangkat as $key ) { 
                          if (isset($key['comment'])){
                            $comment = explode("/", $key['comment']);
                            }
                          ?>
                          <?php
                          if (!($key['.id']==$id)){
                          ?>
                          <option value="<?php echo $key['.id'] ?>"><?php echo $key['.id'] ?> | <?php echo $key['host'] ?> | <?php if (isset($key['comment'])){echo $comment[0];}else{echo "";}; ?></option>
                          <?php  } ?>
                          <?php  } ?>
                        </select>
                      </div>
                    </div>                    
                    
                </div>

          

            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <div class="col-md-6 col-md-offset-4">
              <a href="interkoneksi" class="btn btn-warning btn-flat"><i class="fa fa-mail-reply"></i> Kembali</a>&nbsp;
              <button type="reset" class="btn btn-default btn-flat"><i class="fa fa-refresh"></i> Reset</button>&nbsp;
              <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </div>
          <!-- /.box-footer -->
        </form>
      </div>
    </div>
  </div>
</section>
<!-- /.content -->
<script src="assets/bower_components/jquery/dist/jquery.min.js"></script>

