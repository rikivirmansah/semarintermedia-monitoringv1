	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interkoneksi extends CI_Controller {
    function __construct(){
		parent::__construct();
		$this->check_login->check();
    }
	
	public function index()
	{
		
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/tool/netwatch/getall');
			$perangkat = $this->routerosapi->read();
			$this->routerosapi->disconnect();			
			$total_results = count($perangkat);

			$data  = array('title' =>'Halaman Interkoneksi' ,
							'total_results'=>$total_results,	
							'perangkat'=>$perangkat,	
							'isi' =>'perangkat/v_perangkat');
		$this->load->view('template/wrapper',$data);
	}
	}
	
   public function list($id) {
        $data['id']=$id;
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
			$this->routerosapi->disconnect();
        		}
            $interkoneksi = $this->db->query("SELECT * FROM interkoneksi WHERE hostname_mikrotik='". $this->session->userdata('hostname_mikrotik')."' and (id_awal='".$id."') or (id_akhir='".$id."')");


		    $data  = array('title' =>'Halaman Interkoneksi', 
							'isi' =>'interkoneksi/v_interkoneksi',
							'host' =>$host,
							'data' =>$interkoneksi,
							'id' =>$id,
							);
			$this->load->view('template/wrapper', $data);
    }
    
    public function add($id) {
        $data['id']=$id;
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
    		
			if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/tool/netwatch/getall');
			$perangkat = $this->routerosapi->read();
			$this->routerosapi->disconnect();			
			$total_results = count($perangkat);


        	}

			
			$data  = array('title' =>'Tambah Interkoneksi', 
							'isi' =>'interkoneksi/add_interkoneksi',
							'host' =>$host,
							'id' =>$id,
							'perangkat'=>$perangkat,
							);
		$this->load->view('template/wrapper', $data);
    }
    public function proses_tambahinterkoneksi() {
        $id_awal = $this->input->post('id_awal');
        $id_akhir = $this->input->post('id_akhir');
        $jenis_interkoneksi = $this->input->post('jenis_interkoneksi');
        

        $data = array('id_awal' => $id_awal, 'jenis_interkoneksi' => $jenis_interkoneksi, 'id_akhir' => $id_akhir, 'hostname_mikrotik' => $this->session->userdata('hostname_mikrotik'));
        $this->db->insert('interkoneksi', $data);
        redirect('interkoneksi/list/'.$id_awal);
    }
    public function editinterkoneksi($id_interkoneksi) {
        $data['data'] = $this->db->query("SELECT * from interkoneksi where id_interkoneksi=$id_interkoneksi ");
        $data['content'] = 'frontend/edit_interkoneksi';
        $data['teknisi'] = $this->db->query("SELECT * FROM tbl_admin WHERE level = '3'")->result();
        $this->load->view('frontend/index', $data);
    }
    public function proses_editinterkoneksi($id_interkoneksi) {
        $namainterkoneksi = $this->input->post('nama_interkoneksi');
        $ip = $this->input->post('ip');
        $port = $this->input->post('port');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $idTeknisi = json_encode($this->input->post('teknisi'));
        $createddate = date('Y-m-d H:i:s');
        $modifieddate = date('Y-m-d H:i:s');
        $createdby = addslashes($this->session->userdata('username'));
        $modifiedby = addslashes($this->session->userdata('username'));
        $status = 1;
        $data = array('nama_interkoneksi' => $namainterkoneksi, 'username' => $username, 'password' => $password, 'ip_public' => $ip, 'port' => $port, 'teknisi_id' => $idTeknisi, 'modifieddate' => $modifieddate, 'modifiedby' => $modifiedby, 'status' => $status);
        $this->db->where('id_interkoneksi', $id_interkoneksi);
        $this->db->update('interkoneksi', $data);
        redirect('interkoneksi');
    }
    public function deleteinterkoneksi($id_interkoneksi, $id) {
        $this->db->where('id_interkoneksi', $id_interkoneksi);
        $this->db->delete('interkoneksi');
        redirect('interkoneksi/list/'.$id);
    }
    
    
  public function maps_pelanggan()
  {
      if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/tool/netwatch/getall');
			$perangkat = $this->routerosapi->read();
			$this->routerosapi->disconnect();			
			$total_results = count($perangkat);
	}

            $interkoneksi = $this->db->query("SELECT * from interkoneksi");

			$data  = array('title' =>'Maps Pelanggan' ,
							'isi' =>'interkoneksi/maps_pelanggan',
							'perangkat' =>$perangkat,
							'interkoneksi' =>$interkoneksi
							);
		$this->load->view('template/wrapper',$data);
  }
  
  public function refresh_map()
  {
      if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/tool/netwatch/getall');
			$perangkat = $this->routerosapi->read();
			$this->routerosapi->disconnect();			
			$total_results = count($perangkat);
	}

            $interkoneksi = $this->db->query("SELECT * from interkoneksi");

			$data  = array('title' =>'Maps Pelanggan' ,
							'perangkat' =>$perangkat,
							'interkoneksi' =>$interkoneksi
							);
		$this->load->view('interkoneksi/refresh_map',$data);
      
  }
  
    public function save_session()
  {
      // Get the values from the AJAX request
        $center_lat = $_POST['center_lat'];
        $center_lng = $_POST['center_lng'];
        $zoom = $_POST['zoom'];
        
        
        $data = array('center_lat'=> $center_lat, 'center_lng' => $center_lng, 'zoom' => $zoom);
				$this->session->set_userdata($data);
				
				
  }

    
}