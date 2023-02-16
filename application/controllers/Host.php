<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Host extends CI_Controller {

	
	public function index()
	{
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/ip/hotspot/host/getall');
			$hotspot_host = $this->routerosapi->read();
			$this->routerosapi->disconnect();			
			$total_results = count($hotspot_host);

			$data  = array('title' =>'Halaman Host Active' ,
							'total_results'=>$total_results,	
							'hotspot_host'=>$hotspot_host,
							'isi' =>'host/v_host');
		$this->load->view('template/wrapper',$data);
	}
	}

	
	
	public function binding($id){
		$this->check_login->check();
		$tag=1;
		$data['title']='Halaman make binding';
		
		$data['isi'] = 'ipbinding/v_ipbinding_form';
		$data['form_action'] = site_url('ipbinding/add');		
		
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write("/ip/hotspot/host/print", false);			
			$this->routerosapi->write("=.proplist=.id", false);		
			$this->routerosapi->write("=.proplist=mac-address", false);
			$this->routerosapi->write("=.proplist=address", false);
			$this->routerosapi->write("=.proplist=to-address", false);		
			$this->routerosapi->write("=.proplist=server", false);
			$this->routerosapi->write("?.id=$id");
					
			$host = $this->routerosapi->read();
			

			foreach ($host as $row)
			{
				foreach ($host as $row)
			{
				if (isset($row['mac-address'])){
					$mac_address = $row['mac-address'];
				}else{
					$mac_address = '';
				}
				if (isset($row['address'])){
					$address = $row['address'];
				}else{
					$address = '';
				}
				
				if (isset($row['to-address'])){
					$to_address = $row['to-address'];			
				}else{
					$to_address = '';
				}
				
				if (isset($row['server'])){
					$server = $row['server'];
				}else{
					$server = '';
				}
				
			}
			$this->routerosapi->disconnect();
			
		
			$this->session->set_userdata('tag',$tag);
		
			
			$data['default']['mac_address'] = $mac_address;
			$data['default']['address'] = $address;			
			$data['default']['to_address'] = $to_address;
			$data['default']['server'] = $server;
		
			
		}
		$this->load->view('template/wrapper', $data);
	}
	}
	
	public function remove($id){
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/ip/hotspot/host/remove',false);
			$this->routerosapi->write('=.id='.$id);
			$hotspot_host = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata('message','Data host tersebut berhasil dihapus!');
			redirect('host');
		}	
	}
		

}
