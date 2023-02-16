<?php
error_reporting(0);
?>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYpiHUf60SqPq5qY62CiIUWhOvdkb3W1U&callback=initMap"
      defer
    ></script>
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map_me {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
<div id="map_me" style="height:800px; width:100%;"></div>
        <br/><br/>
        Keterangan :
        <table>
            <tr>
                <td><div style="background:#0000FF; width:80px; height:3px;"></div></td>
                <td style="padding-left:10px;">FO</td>
            </tr>
            <tr>
                <td><div style="background:#00FF00; width:80px; height:3px;"></div></td>
                <td style="padding-left:10px;">LAN</td>
            </tr>
            <tr>
                <td><div style="background:#FF00FF; width:80px; height:3px;"></div></td>
                <td style="padding-left:10px;">Wireless</td>
            </tr>
        </table>
<script>

      var map_me;

      function initMap() {
        map_me = new google.maps.Map(document.getElementById("map_me"), {
        <?php
        if ($this->session->userdata('center_lat')==""){
        ?>
          center: new google.maps.LatLng(-7.357607477470394, 108.93656090939191),
          zoom: 13,
          mapTypeId: 'satellite',
        <?php
        }else{
            ?>
          center: new google.maps.LatLng(<?php echo $this->session->userdata('center_lat') ?>, <?php echo $this->session->userdata('center_lng') ?>),
          zoom: <?php echo $this->session->userdata('zoom') ?>,
          mapTypeId: 'satellite',
            <?php
        }
        ?>
        });
        google.maps.event.addListener(map_me, 'bounds_changed', function() {
            // Get the new center of the map
            var center = map_me.getCenter();
        
            // Get the new zoom level of the map
            var zoom = map_me.getZoom();
        
            // Log the center and zoom level to the console
            console.log("Map center: " + center.lat() + ", " + center.lng());
            console.log("Map zoom: " + zoom);
            
            // Make an AJAX request to save the values in the PHP session
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "<?php echo base_url("interkoneksi/save_session") ?>", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        console.log("Map state saved in PHP session");
      }
    };
    xhr.send("center_lat=" + center.lat() + "&center_lng=" + center.lng() + "&zoom=" + zoom);
    
    
          });
          
        const iconBase =
          "https://developers.google.com/maps/documentation/javascript/examples/full/images/";
        const icons = {
          parking: {
            icon: iconBase + "parking_lot_maps.png",
          },
          library: {
            icon: iconBase + "library_maps.png",
          },
          info: {
          //  icon: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=28|FE6256|ffffff",
          },
        };
        const features = [
            
          <?php
          
          foreach ($perangkat as $index => $key){
              		$id = $key['.id'];
              	
					$host = $key['host'];
						if (isset($key['comment'])){
                            $comment = explode("/", $key['comment']);
                            $nama=$comment[0];
                            $lokasi=$comment[1];
                            $no_hp=$comment[2];
                            $lat=$comment[3]+0;
                            $long=$comment[4]+0;
                        }
                        
                        $status = $key['status'];
    if ($status == "up" && $no_hp == "modem") {
        $label = "M";
        $color = "0A29F3";
    } elseif ($status == "up" && $no_hp == "router") {
        $label = "R";
        $color = "46E71F";
      } elseif ($status == "up" && $no_hp == "odp") {
        $label = "O";
        $color = "650993";
      } elseif ($status == "up" && $no_hp == "switch") {
        $label = "S";
        $color = "650993";
      } elseif ($status="down" && $no_hp == "router") {
        $label = "D";
        $color = "F80404";
      } elseif ($status="down" && $no_hp == "modem") {
        $label = "D";
        $color = "F80404";
      } elseif ($status="down" && $no_hp == "odp") {
        $label = "D";
        $color = "F80404";  
    }
                        
                        

    

             if (!($lat=="0") and !($long=="0")){
              ?>
                  {
                    position: new google.maps.LatLng(<?php echo $lat ?>,<?php echo $long ?>),
                    type: "info",
                    icon: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=<?php echo $label ?>|<?php echo $color ?>|ffffff",
                    contentString : "<?php echo $nama ?><br/> "+
                    "<?php echo $host ?><br/> "+
                    "<?php echo $lokasi ?><br/> "+
                    "<?php echo $no_hp ?><br/><br/>"
                  },
              <?php
                }
          }
          
          
          ?>
          
          
          

        ];
        
        
        <?php
        
        foreach ($perangkat as $index => $key){
            $jenis_interkoneksi="";
            $uniq=uniqid();
            $id = $key['.id'];

					$host = $key['host'];
						if (isset($key['comment'])){
                            $comment = explode("/", $key['comment']);
                            $nama=$comment[0];
                            $lokasi=$comment[1];
                            $no_hp=$comment[2];
                            $lat=$comment[3]+0;
                            $long=$comment[4]+0;

                        }
                        
                        $status = $key['status'];

                        
             if (!($lat=="0") and !($long=="0")){
                 $cek_interkoneksi = $this->db->query("SELECT * from interkoneksi where hostname_mikrotik='".$this->session->userdata('hostname_mikrotik')."' and (id_awal='$id' or id_akhir='$id')");
                 if (!(empty($cek_interkoneksi))){
                   $jenis_interkoneksi=$cek_interkoneksi->row()->jenis_interkoneksi;
                   $id_awal=$cek_interkoneksi->row()->id_awal;
                   $id_akhir=$cek_interkoneksi->row()->id_akhir;
                   if($id_awal==$id){
                       $lat_awal=$lat;
                       $long_awal=$long;
                       
                       
                       if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
                			$this->routerosapi->write("/tool/netwatch/print", false);			
                			$this->routerosapi->write("=.proplist=.id", false);
                			$this->routerosapi->write("=.proplist=host", false);	
                			$this->routerosapi->write("=.proplist=comment", false);						
                			$this->routerosapi->write("?.id=$id_akhir");

                			$perangkat2 = $this->routerosapi->read();
                
                			foreach ($perangkat2 as $row2)
                			{
                				if (isset($row2['comment'])){
                					$comment2 = explode("/", $row2['comment']);
                					
                					$lat_akhir=$comment2[3];
                                    $long_akhir=$comment2[4];
                				}else{
                					$lat_akhir = 0;
                					$long_akhir=0;
                					
                				}
                				
                				
                			}
                    		}
                       
                       
                   }else{
                       $lat_akhir=$lat;
                       $long_akhir=$long;
                       
                       if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
                			$this->routerosapi->write("/tool/netwatch/print", false);			
                			$this->routerosapi->write("=.proplist=.id", false);
                			$this->routerosapi->write("=.proplist=host", false);	
                			$this->routerosapi->write("=.proplist=comment", false);						
                			$this->routerosapi->write("?.id=$id_awal");
                					
                			$perangkat2 = $this->routerosapi->read();
                
                			foreach ($perangkat2 as $row2)
                			{
                				if (isset($row2['comment'])){
                					$comment2 = explode("/", $row2['comment']);
                					
                					$lat_awal=$comment2[3];
                                    $long_awal=$comment2[4];
                				}else{
                					$lat_awal = 0;
                					$long_awal=0;
                					
                				}
                				
                				
                			}
                    		}
                       
                       
                   }
                   
                   
                 if ($jenis_interkoneksi=="fo"){
                         ?>
                            var line1 = [
                                { lat: <?php echo $lat_awal ?>, lng: <?php echo $long_awal ?> },
                                { lat: <?php echo $lat_akhir ?>, lng: <?php echo $long_akhir ?> },
                              ];
                              var linePath1 = new google.maps.Polyline({
                                path: line1,
                                geodesic: true,
                                <?php 
                                if ((!($status=="up")) and $id_awal==$id){
                                    ?>
                                strokeColor: "#F80404", ///FO Down
                                    <?php
                                }else{
                                    ?>
                                strokeColor: "#0000FF", ///FO
                                    <?php
                                }
                                ?>
                                strokeOpacity: 1.0,
                                strokeWeight: 2,
                              });
                            
                              linePath1.setMap(map_me);                         
                         <?php
                }elseif($jenis_interkoneksi=="lan"){
                    ?>
                            var line1 = [
                                { lat: <?php echo $lat_awal ?>, lng: <?php echo $long_awal ?> },
                                { lat: <?php echo $lat_akhir ?>, lng: <?php echo $long_akhir ?> },
                              ];
                              var linePath1 = new google.maps.Polyline({
                                path: line1,
                                geodesic: true,
                                <?php 
                                if ((!($status=="up")) and $id_awal==$id){
                                    ?>
                                strokeColor: "#F80404", ///LAN Down
                                    <?php
                                }else{
                                    ?>
                                strokeColor: "#47B92A", ///LAN
                                    <?php
                                }
                                ?>
                                
                                strokeOpacity: 1.0,
                                strokeWeight: 2,
                              });
                            
                              linePath1.setMap(map_me);                         
                    <?php
                }elseif($jenis_interkoneksi=="wireless"){
                    ?>
                            var line1 = [
                                { lat: <?php echo $lat_awal ?>, lng: <?php echo $long_awal ?> },
                                { lat: <?php echo $lat_akhir ?>, lng: <?php echo $long_akhir ?> },
                              ];
                              var linePath1 = new google.maps.Polyline({
                                path: line1,
                                geodesic: true,
                                <?php 
                                if ((!($status=="up")) and $id_awal==$id){
                                    ?>
                                strokeColor: "#F80404", ///Wireless Down
                                    <?php
                                }else{
                                    ?>
                                strokeColor: "#FF00FF", ///Wireless
                                    <?php
                                }
                                ?>
                                strokeOpacity: 1.0,
                                strokeWeight: 2,
                              });
                            
                              linePath1.setMap(map_me);                         
                    
                    <?php
                }
                     
                   
                 }
             }
              		
        }
        
        ?>

        // Create markers.
        for (let i = 0; i < features.length; i++) {
          
          const infowindow = new google.maps.InfoWindow({
            content: features[i].contentString,
          });

          const marker = new google.maps.Marker({
            position: features[i].position,
            icon: features[i].icon,
            map: map_me,
          });
          marker.addListener("click", () => {
            infowindow.open(map_me, marker);
          });

        }
      }
    </script>