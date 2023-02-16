<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ipbinding extends CI_Controller {


	public function index()
	{
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/ip/hotspot/ip-binding/getall');
			$ipbinding = $this->routerosapi->read();
			$this->routerosapi->disconnect();			
			$total_results = count($ipbinding);
			

			$data  = array('title' =>'Halaman Ip Binding' ,
							'total_results'=>$total_results,
							'ipbinding'=>$ipbinding,
							'isi' =>'ipbinding/v_ipbinding');
		$this->load->view('template/wrapper',$data);
	}
	}



public function add()
{
	$this->check_login->check();
	$data  = array('title' =>'Tambah Ip Binding User' ,
		'form_action' => site_url('ipbinding/add'),
				'isi'=>'ipbinding/v_ipbinding_form'
				);
		
		$valid=$this->form_validation->set_rules('address', 'Address', 'required');			
		$valid=$this->form_validation->set_rules('disabled', 'Disabled', 'required');			
			


	if($valid->run() === TRUE ){
			$mac_address = $this->input->post('mac_address');			
			$address = $this->input->post('address');
			$to_address = $this->input->post('to_address');
			$server = $this->input->post('server');
			$type = $this->input->post('type');
			$disabled = $this->input->post('disabled');
			
			if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
				$this->routerosapi->write('/ip/hotspot/ip-binding/add',false);					
				if (!empty($mac_address)){
					$this->routerosapi->write('=mac-address='.$mac_address, false);     				
				}						
				
					$this->routerosapi->write('=address='.$address, false);     				
				
				 
				if (!empty($to_address)){
					$this->routerosapi->write('=to-address='.$to_address, false);     				
				}   				
				
				if (!empty($server)){
					$this->routerosapi->write('=server='.$server, false);     				
				}			 		
				if (!empty($type)){
					$this->routerosapi->write('=type='.$type, false);     				
				}	
				$this->routerosapi->write('=disabled='.$disabled);				
				$this->routerosapi->read();
				$this->routerosapi->disconnect();	
				if ($this->session->userdata('tag')==1) {
						$this->session->set_flashdata('message','Data  host tersebut berhasil di binding!');
				} else {
				$this->session->set_flashdata('message','Data  ip binding tersebut berhasil ditambahkan!');
			}
			$this->session->unset_userdata('tag');
							redirect('ipbinding');
			}
		   }else{
			$data['mac_address'] = $this->input->post('mac_address');
			$data['address'] = $this->input->post('address');
			$data['to_address'] = $this->input->post('to_address');
			$data['server'] = $this->input->post('server');
			$data['type'] = $this->input->post('type');
			$data['disabled'] = $this->input->post('disabled');
		}
						

		$this->load->view('template/wrapper',$data);
	
}


	public function edit($id){
		$this->check_login->check();
		$data['title']='Halaman edit Ip Binding';
		$data['isi'] = 'ipbinding/v_ipbinding_form';
		$data['form_action'] = site_url('ipbinding/process_update');		
		
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write("/ip/hotspot/ip-binding/print", false);			
			$this->routerosapi->write("=.proplist=.id", false);
			$this->routerosapi->write("=.proplist=mac-address", false);
			$this->routerosapi->write("=.proplist=address", false);
			$this->routerosapi->write("=.proplist=to-address", false);		
			$this->routerosapi->write("=.proplist=server", false);
			$this->routerosapi->write("=.proplist=type", false);		
			$this->routerosapi->write("=.proplist=disabled", false);		
			$this->routerosapi->write("?.id=$id");
					
			$ipbinding_user = $this->routerosapi->read();

			foreach ($ipbinding_user as $row)
			{
				if (isset($row['mac-address'])){
					$mac_address = $row['mac-address'];
				}else{
					$mac_address = '00:00:00:00:00:00';
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
				if (isset($row['type'])){
					$type = $row['type'];
				}else{
					$type = '';
				}
				$disabled = $row['disabled'];

				if ($disabled == 'true')
				{
					$disabled='yes';
				}else{
					$disabled='no';
				}
			}
			$this->routerosapi->disconnect();
			
			$this->session->set_userdata('id',$id);
			
			$data['default']['mac_address'] = $mac_address;
			$data['default']['address'] = $address;			
			$data['default']['to_address'] = $to_address;
			$data['default']['server'] = $server;
			$data['default']['type'] = $type;
			$data['default']['disabled'] = $disabled;
		}
		$this->load->view('template/wrapper', $data);
	}

public function process_update()
{
	$this->check_login->check();
	$data  = array('title' =>'Tambah Ip Binding User' ,
		'form_action' => site_url('ipbinding/add'),
				'isi'=>'ipbinding/v_ipbinding_form'
				);
		
		$valid=$this->form_validation->set_rules('address', 'Address', 'required');			
		$valid=$this->form_validation->set_rules('disabled', 'Disabled', 'required');			
			


	if($valid->run() === TRUE ){
			$mac_address = $this->input->post('mac_address');			
			$address = $this->input->post('address');
			$to_address = $this->input->post('to_address');
			$server = $this->input->post('server');
			$type = $this->input->post('type');
			$disabled = $this->input->post('disabled');
			
			if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
				$this->routerosapi->write('/ip/hotspot/ip-binding/set',false);	
				$this->routerosapi->write('=.id='.$this->session->userdata('id'),false);				
				if (!empty($mac_address)){
					$this->routerosapi->write('=mac-address='.$mac_address, false);     				
				}						
				
					$this->routerosapi->write('=address='.$address, false);     				
				
				 
				if (!empty($to_address)){
					$this->routerosapi->write('=to-address='.$to_address, false);     				
				}   				
				
				if (!empty($server)){
					$this->routerosapi->write('=server='.$server, false);     				
				}			 		
				if (!empty($type)){
					$this->routerosapi->write('=type='.$type, false);     				
				}	
				$this->routerosapi->write('=disabled='.$disabled);				
				$this->routerosapi->read();
				$this->routerosapi->disconnect();	
				$this->session->unset_userdata('id');
			
				
				$this->session->set_flashdata('message','Data  ip binding tersebut berhasil ditambahkan!');
					# code...
				
				
				redirect('ipbinding');
			}
		   }else{
			$data['mac_address'] = $this->input->post('mac_address');
			$data['address'] = $this->input->post('address');
			$data['to_address'] = $this->input->post('to_address');
			$data['server'] = $this->input->post('server');
			$data['type'] = $this->input->post('type');
			$data['disabled'] = $this->input->post('disabled');
		}
						

		$this->load->view('template/wrapper',$data);
	
}


	public function remove($id){
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/ip/hotspot/ip-binding/remove',false);
			$this->routerosapi->write('=.id='.$id);
			$ipbinding_users = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata('message','Data  Ip Binding tersebut berhasil dihapus!');
			redirect('ipbinding');
		}	
	}
		
public function disable($id){	
$this->check_login->check();	
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/ip/hotspot/ip-binding/disable',false);
			$this->routerosapi->write('=.id='.$id);
			$ipbinding_users = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata('message','Data Ip Binding  tersebut berhasil dinonaktifkan!');
			redirect('ipbinding');
		}
	}
	
	public function enable($id){
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/ip/hotspot/ip-binding/enable',false);
			$this->routerosapi->write('=.id='.$id);
			$ipbinding_users = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata('message','Data Ip Binding tersebut berhasil diaktifkan!');
			redirect('ipbinding');
		}
	}
}
	
	