<section class="content">
  <div class="row">
    <div class="col-xs-12">

<form class="form-horizontal" method="post" action="<?= $form_action; ?>">
<input type="hidden" name="id" value="<?php if (isset($default['.id'])) { echo $default['.id']; } ?>">
<div class="form-group ">
             <label for="lokasi" class="control-label col-lg-2">Koordinat</label>
                <div class="col-lg-10">
          <div id="petaku_edit" style="width:100%; height:400px"></div>
      </div>
    </div>
	<div class="form-group">	
	<label  class="col-sm-2 control-label">IP Device</label>
		<div class="col-lg-10">
			<input class="form-control" type="text" name="ip_perangkat" id="ip_perangkat" placeholder="IP address" value="<?php if (isset($default['host'])) { echo $default['host']; } ?>" required>
			<?php echo form_error('ip_perangkat', '<label class="control-label" for="ip_perangkat">', '</label>'); ?>	
		</div>
	</div>
	<?php
	if (isset($default['comment'])) {
	    $comment = explode("/", $default['comment']);
	    $nama=$comment[0];
	    $lokasi=$comment[1];
	    $no_hp=$comment[2];
	    $latitude=$comment[3];
	    $longitude=$comment[4];
	}else{
	    $nama="";
	    $lokasi="";
	    $no_hp="";
	    $latitude="";
	    $longitude="";
	    
	}
	?>
    <div class="form-group">	
	<label  class="col-sm-2 control-label">Nama</label>
		<div class="col-lg-10">
			<input class="form-control" type="text" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama ?>" required>
			<?php echo form_error('nama', '<label class="control-label" for="nama">', '</label>'); ?>		
		</div>
	</div>
    <div class="form-group">	
	<label  class="col-sm-2 control-label">Alamat</label>
		<div class="col-lg-10">
			<input class="form-control" type="text" name="lokasi" id="lokasi" placeholder="Lokasi" value="<?php echo $lokasi ?>" required>
			<?php echo form_error('lokasi', '<label class="control-label" for="lokasi">', '</label>'); ?>		
		</div>
	</div>

	
	<div class="form-group">
	<label class="col-sm-2 control-label" for="no_hp">Jenis Perangkat</label>
	<div class="col-lg-10">
		<select class="form-control" name="no_hp" id="no_hp" required>
			<option value=""> -- Pilih Jenis Perangkat -- </option>
			<option value="modem" <?php if($no_hp == "modem") echo "selected"; ?>>Modem</option>
			<option value="router" <?php if($no_hp == "router") echo "selected"; ?>>Router</option>
			<option value="odp" <?php if($no_hp == "odp") echo "selected"; ?>>ODP</option>
			<option value="switch" <?php if($no_hp == "switch") echo "selected"; ?>>Switch/Hub</option>
		</select>
		<?php echo form_error('no_hp', '<label class="control-label" for="no_hp">', '</label>'); ?>
	</div>
</div>

	
	<div class="form-group">
      <label class="col-sm-2 control-label">Koordinat (Lat)</label>
      <div class="col-sm-2">
          <input type="text" name="latitude" id="latitude" class="form-control" value="<?php echo $latitude ?>" required>
      </div>
      <label class="col-sm-2 control-label">(Long)</label>
      <div class="col-sm-2">
          <input type="text" name="longitude" id="longitude" class="form-control" value="<?php echo $longitude ?>" required>
      </div>
    </div>
	
	

	<div class="form-group">
		<div class="col-md-offset-5 col-md-10">
			<button class="btn btn-primary" type="submit" >Simpan</button>
			<a class="btn btn-default" href="<?php echo base_url().'perangkat'; ?>">Batal</a>
		</div>
	</div>
</form>
</p>
</div>

<script>
  function maxLengthCheck(object)
  {
    if (object.value.length > object.maxLength)
      object.value = object.value.slice(0, object.maxLength)
  }
</script>

<script src="<?php echo base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script 
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYpiHUf60SqPq5qY62CiIUWhOvdkb3W1U&callback=initMap">
</script>

<script type="text/javascript">
//google maps GIS 1.1.b by desrizal
//dibuat tanggal 8 Jan 2011
var peta;
var pertama = 0;
var jenis = "kantor";
var judulx = new Array();
var desx = new Array();
var id_infox = new Array();

var tglx = new Array();

var koorx = new Array();
var koory = new Array();

var i;
var url;
var gambar_tanda;
function peta_awal(){
    <?php
	if ($latitude!=""){
	?>
        var here = new google.maps.LatLng(<?php echo $latitude;?>, <?php echo $longitude;?>);
	<?php
	}else{
	    ?>
	            var here = new google.maps.LatLng(-7.403660812723338, 108.8954690573948);
	    <?php
	}
	?>
    var petaoption = {
        zoom: 30,
        center: here,
        mapTypeId: 'satellite',
        };
    peta = new google.maps.Map(document.getElementById("petaku_edit"),petaoption);
    google.maps.event.addListener(peta,'click',function(event){
        kasihtanda(event.latLng);
    });
    //ambildatabase('awal');
    <?php
	if ($latitude!=""){
	?>
        	var point = new google.maps.LatLng(<?php echo $latitude;?>, <?php echo $longitude;?>);
	<?php
	}else{
	    ?>
        	//var point = new google.maps.LatLng(-7.403660812723338, 108.8954690573948);
	    <?php
	}
	?>
	
    var marker = new google.maps.Marker({
            position: point,
            map: peta
    });
	
	<?php
	if ($latitude!=""){
	?>
    	markers.push(marker);
	<?php
	}
	?>
	
}
function kasihtanda(lokasi){
	clearMarkers();
	markers = [];
    //set_icon(jenis);
    var marker = new google.maps.Marker({
            position: lokasi,
            map: peta
    });
	
    //$("#lat_kantor").val(lokasi.lat());
    //$("#long_kantor").val(lokasi.lng());
    
    $("#latitude").val(lokasi.lat());
    $("#longitude").val(lokasi.lng());
    
	markers.push(marker);
}



function setjenis(jns){
    jenis = jns;
}

var markers = [];
function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }
function clearMarkers() {
        setMapOnAll(null);
      }
function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

peta_awal();

</script>  