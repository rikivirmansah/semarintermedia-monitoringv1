<?php
        date_default_timezone_set("Asia/jakarta");
    ?>
    <p>Jam Digital: <b><span id="jam" style="font-size:24"></span></b></p>
    
    <script type="text/javascript">
        window.onload = function() { jam(); }
       
        function jam() {
            var e = document.getElementById('jam'),
            d = new Date(), h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());
       
            e.innerHTML = h +':'+ m +':'+ s;
       
            setTimeout('jam()', 1000);
        }
       
        function set(e) {
            e = e < 10 ? '0'+ e : e;
            return e;
        }
    </script>


      <section  class="content">

      	<!-- Small boxes (Stat box) -->
        <div style="background: #ecf0f5;"  class="row">
          <div class="col-md-15" style="margin-bottom: -4px">
            <br>

          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua">
                <i style="font-size:45px;color:white" class="ion-android-wifi"></i></span>
                <div style="border-top: 3px solid #00c0ef;" class="info-box-content">
                  <span class="info-box-text">hotspot online</span>
                  <span style="margin-left:-1.5px;font-size:17px" class="info-box-number daily"><p><?php
                if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
        $this->routerosapi->write('/ip/hotspot/active/getall');
        $hotspot_users = $this->routerosapi->read();
        $this->routerosapi->disconnect();
        $total_user = count($hotspot_users);
         echo $total_user;} ?></p>
                </span>
                <hr style="margin-top:5px;margin-bottom:5px">
                <span style="font-size:12px;font-weight:normal" class="info-box-number">
                  <a href="#report-daily" data-toggle="modal" data-target="#report-daily"> </a></span>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box"><span class="info-box-icon bg-red">
                <i style="font-size:45px;color:white"  class="ion-arrow-down-c"></i>
              </span>
              <div style="border-top: 3px solid #dd4b39;" class="info-box-content">
                <span class="info-box-text">DEVICE OFFLINE</span>
                <span style="margin-left:-1.5px;font-size:17px" class="info-box-number unpaid">

            <p id="offline"></P>
            </span>
            <hr style="margin-top:5px;margin-bottom:5px">
            <span style="font-size:12px;font-weight:normal" class="info-box-number">
              <a href="#unpaid-invoice" data-toggle="modal" data-target="#unpaid-invoice"> </a>
            </span>
          </div>
          </div>
          </div>

      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green">
            <i style="font-size:45px;color:white" class="ion-person-stalker" ></i></span>
            <div style="border-top: 3px solid #00a65a;" class="info-box-content">
              <span class="info-box-text">PPoE ONLINE</span>
              <span id="pppoe_online" style="margin-left:-1.5px;font-size:17px" class="info-box-number ppponline">
                <P><?php
if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
$this->routerosapi->write('/ppp/active/getall');
$hotspot_users = $this->routerosapi->read();
$this->routerosapi->disconnect();
$total_user = count($hotspot_users);
echo $total_user;} ?></P>

            </span>
            <hr style="margin-top:5px;margin-bottom:5px">
            <span style="font-size:12px;font-weight:normal" class="info-box-number">
              <a href="#"> </a></span>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12"><div class="info-box">
          <span class="info-box-icon bg-yellow">
            <i style="font-size:45px;color:white" class="ion ion-stats-bars"></i>
          </span>
          <div style="border-top: 3px solid #f39c12;" class="info-box-content">
            <span class="info-box-text">DEVICE ONLINE</span>
            <span id="hotspot_online" style="margin-left:-1.5px;font-size:17px" class="info-box-number hotspotonline">
                  <p id="online"></P>
                </span>
                <hr style="margin-top:5px;margin-bottom:5px">
                <span style="font-size:12px;font-weight:normal" class="info-box-number">
                  <a href="#"> </a>
                </span>
              </div>
            </div>
          </div>
  </div>


      	<br>
      	<br>

        <div style="border-top: 3px solid #dd4b39;"  class="box">
            <br>
      		<div class="table-responsive">
      			<table  id="example1" class="table table-bordered table-striped">
      			<thead style="border: 3px solid #222d32; background:;"  class=thead-green>
      					<tr>

      						<th width=5%>No.</th>
      						<th>Nama</th>
      						<th>Area</th>
      						
                  <th>Address</th>
      						<th>Last Downtime</th>
      						<th>Status</th>
      					</tr>
      				</thead>
      				<tbody>
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
      	function statusup() {
      		$.ajax({
      			url: "<?= base_url(); ?>perangkat/status/up",
      			type: "post",
      			dataType: "json",
      			success: function (data) {
      				online.innerText = Object.keys(data).length;
      			}
      		})
      	}

      	function statusdown() {
      		var jumlahawal = document.getElementById("offline").innerText;
      		$.ajax({
      			url: "<?= base_url(); ?>perangkat/status/down",
      			type: "post",
      			dataType: "json",
      			success: function (data) {
      				var jumlah = Object.keys(data).length;
      				offline.innerText = jumlah;
      				if (jumlahawal != "") {
      					if (jumlah != jumlahawal) {
      						$('#example1').DataTable().destroy();
      						listdata();
      					}
      				}
      			}
      		})
      	}

      	function perangkat() {
      		$.ajax({
      			url: "<?= base_url(); ?>perangkat/total",
      			type: "post",
      			dataType: "json",
      			success: function (data) {
      				device.innerText = Object.keys(data).length;
      			}
      		})
      	}

      	function listdata() {
      		$.ajax({
      			url: "<?= base_url(); ?>perangkat/status/down",
      			type: "post",
      			dataType: "json",
      			success: function (data) {
      				var i = "1";
      				$('#example1').DataTable({
      					"data": data,
      					 'ordering': true,
            'searching': true,
            'info': true,
           
            "lengthMenu": [[20, 50, 100 - 1], [20, 50, 100, "All"]],
            "pageLength": 20,
      					"columns": [{
      							"render": function () {
      								return a = i++;
      							}
      						},  						{
      							"render": function (data, type, row, meta) {
      								if (typeof (row.comment) !== 'undefined') {
      									var mystr = row.comment;
      									var myarr = mystr.split("/");
      									return a = myarr[0];
      								} else {
      									return a = "";
      								}
      							}
      						},
      						{
      							"render": function (data, type, row, meta) {
      								if (typeof (row.comment) !== 'undefined') {
      									var mystr = row.comment;
      									var myarr = mystr.split("/");
      									return a = myarr[1];

      								} else {
      									return a = "";
      								}

      							}
      						},
                  
      						{
      							"data": "host"
      						},
      						
      						{
      							"data": "since"
      						},
      						{
      							"render": function (data, type, row, meta) {
      								var color = "info";
      								if (row.status === "up") {
      									color = "success";
      								} else if (row.status === "down") {
      									color = "danger";
      								}
      								var a = `
                    <span class="label label-${color}" >${row.status}</span>
                    `;
      								return a;
      							}
      						},
      					]
      				})
      			}
      		})
      	}
      	$(document).ready(function () {
      		setInterval(statusup, 5000);
      		setInterval(statusdown, 5000);
      		setInterval(perangkat, 5000);
      	});
      	listdata();

   
  
      </script>
