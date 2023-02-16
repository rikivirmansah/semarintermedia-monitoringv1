<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotspot extends CI_Controller {

	
	public function index()
	{
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/ip/hotspot/user/getall');
			$hotspot_users = $this->routerosapi->read();
			$this->routerosapi->disconnect();			
			$total_results = count($hotspot_users);

			$data1['total_user']=$total_results;

			$data  = array('title' =>'Halaman User Hotspot' ,
							'total_results'=>$total_results,	
							'hotspot_user'=>$hotspot_users,
							'isi' =>'hotspot/v_hotspot');
		$this->load->view('template/wrapper',$data);
	

	}
	}



public function add()
{
	$this->check_login->check();
	$data  = array('title' =>'Tambah Hotspot User' ,
		'form_action' => site_url('hotspot/add'),
				'isi'=>'hotspot/v_hotspot_form'
				);
		$valid=$this->form_validation->set_rules('name', 'Name', 'required');
		$valid=$this->form_validation->set_rules('profile', 'Profile', 'required');		
		$valid=$this->form_validation->set_rules('disabled', 'Disabled', 'required');


	if($valid->run()===TRUE){
			$server = $this->input->post('server');			
			$name = $this->input->post('name');
			$password = $this->input->post('password');
			$mac_address = $this->input->post('mac_address');
			$profile = $this->input->post('profile');
			$comment = $this->input->post('comment');
			$disabled = $this->input->post('disabled');
			
			if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
				$this->routerosapi->write('/ip/hotspot/user/add',false);				
				$this->routerosapi->write('=server='.$server, false);							
				$this->routerosapi->write('=name='.$name, false);
				if (!empty($password)){
					$this->routerosapi->write('=password='.$password, false);     				
				}
				if (!empty($mac_address)){
					$this->routerosapi->write('=mac-address='.$mac_address, false);	
				}				
				$this->routerosapi->write('=profile='.$profile, false);
				if (!empty($comment)){
					$this->routerosapi->write('=comment='.$comment, false);	
				}		
				$this->routerosapi->write('=disabled='.$disabled);				
				$hotspot_users = $this->routerosapi->read();
				$this->routerosapi->disconnect();	
				$this->session->set_flashdata('message','Data user hotspot tersebut berhasil ditambahkan!');
				redirect('hotspot');
			}
		   }else{
			$data['server'] = $this->input->post('server');
			$data['name'] = $this->input->post('name');
			$data['password'] = $this->input->post('password');
			$data['mac_address'] = $this->input->post('mac_address');
			$data['profile'] = $this->input->post('profile');
			$data['comment'] = $this->input->post('comment');
			$data['disabled'] = $this->input->post('disabled');
		}
						

		$this->load->view('template/wrapper',$data);
	
}


	public function edit($id){
		$this->check_login->check();
		$data['title']='Halaman edit User';
		$data['isi'] = 'hotspot/v_hotspot_form';
		$data['form_action'] = site_url('hotspot/process_update');		
		
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write("/ip/hotspot/user/print", false);			
			$this->routerosapi->write("=.proplist=.id", false);
			$this->routerosapi->write("=.proplist=server", false);
			$this->routerosapi->write("=.proplist=name", false);
			$this->routerosapi->write("=.proplist=password", false);		
			$this->routerosapi->write("=.proplist=mac-address", false);
			$this->routerosapi->write("=.proplist=profile", false);
			$this->routerosapi->write("=.proplist=comment", false);		
			$this->routerosapi->write("=.proplist=disabled", false);		
			$this->routerosapi->write("?.id=$id");
					
			$hotspot_user = $this->routerosapi->read();

			foreach ($hotspot_user as $row)
			{
				if (isset($row['server'])){
					$server = $row['server'];
				}else{
					$server = '';
				}
				
				if (isset($row['name'])){
							$name = $row['name'];
				}else{
					$name = '';
				}
					
			
				if (isset($row['password'])){
						$password = $row['password'];
				}else{
					$password = '';
				}
				
				if (isset($row['mac-address'])){
					$mac_address = $row['mac-address'];			
				}else{
					$mac_address = '';
				}
				
				if (isset($row['profile'])){
						$profile = $row['profile'];
				}else{
					$profile = '';
				}
				
				if (isset($row['comment'])){
					$comment = $row['comment'];
				}else{
					$comment = '';
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
			
			$data['tes']['server'] = $server;
			$data['default']['name'] = $name;			
			$data['default']['password'] = $password;
			$data['default']['mac_address'] = $mac_address;
			$data['default']['profile'] = $profile;
			$data['default']['comment'] = $comment;
			$data['default']['disabled'] = $disabled;
		}
		$this->load->view('template/wrapper', $data);
	}
	
	public function process_update(){
$this->check_login->check();
$data['title']='Edit Hotspot';
		$data['isi'] = 'hotspot/v_hotspot_form';
		$data['form_action'] = site_url('hotspot/process_update');	

		$valid=$this->form_validation->set_rules('name', 'Name', 'required');
		$valid=$this->form_validation->set_rules('profile', 'Profile', 'required');		
		$valid=$this->form_validation->set_rules('disabled', 'Disabled', 'required');

		
		if ($valid->run() === TRUE)
		{
			$server = $this->input->post('server');			
			$name = $this->input->post('name');			
			$password = $this->input->post('password');
			if (empty($password)){
				$password = '';
			}			
			$mac_address = $this->input->post('mac_address');
			if (empty($mac_address)){
				$mac_address = '00:00:00:00:00:00';
			}
			$profile = $this->input->post('profile');
			$comment = $this->input->post('comment');
			$disabled = $this->input->post('disabled');
			
			if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
				$this->routerosapi->write('/ip/hotspot/user/set',false);				
				$this->routerosapi->write('=.id='.$this->session->userdata('id'),false);
				$this->routerosapi->write('=server='.$server,false);										
				$this->routerosapi->write('=name='.$name, false);				
				$this->routerosapi->write('=password='.$password, false);    				
				$this->routerosapi->write('=mac-address='.$mac_address, false);								
				$this->routerosapi->write('=profile='.$profile, false);				
				$this->routerosapi->write('=comment='.$comment, false);						
				$this->routerosapi->write('=disabled='.$disabled);				
								
				$hotspot_users = $this->routerosapi->read();
				$this->routerosapi->disconnect();	
				$this->session->unset_userdata('id');
				$this->session->set_flashdata('message','Data user hotspot tersebut berhasil diubah!');
				redirect('hotspot');				
			}	
		}else{
			$data['default']['server'] = $this->input->post('server');
			$data['default']['name'] = $this->input->post('name');
			$data['default']['password'] = $this->input->post('password');
			$data['default']['mac_address'] = $this->input->post('mac_address');
			$data['default']['profile'] = $this->input->post('profile');
			$data['default']['comment'] = $this->input->post('comment');
			$data['default']['disabled'] = $this->input->post('disabled');
		}
		$this->load->view('template/wrapper', $data);		
	}


	public function remove($id){
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/ip/hotspot/user/remove',false);
			$this->routerosapi->write('=.id='.$id);
			$hotspot_users = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata('message','Data user tersebut berhasil dihapus!');
			redirect('hotspot');
		}	
	}
		
public function disable($id){
$this->check_login->check();		
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/ip/hotspot/user/disable',false);
			$this->routerosapi->write('=.id='.$id);
			$hotspot_users = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata('message','Data user tersebut berhasil dinonaktifkan!');
			redirect('hotspot');
		}
	}
	
	public function enable($id){
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/ip/hotspot/user/enable',false);
			$this->routerosapi->write('=.id='.$id);
			$hotspot_users = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata('message','Data user tersebut berhasil diaktifkan!');
			redirect('hotspot');
		}
	}
}
