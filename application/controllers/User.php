<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	
	public function index()
	{
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/user/getall');
			$user = $this->routerosapi->read();
			$this->routerosapi->disconnect();		
						
				
			$total_results = count($user);

			$data  = array('title' =>'Halaman User' ,
							'total_results'=>$total_results,	
							'user'=>$user,
							'isi' =>'user/v_user');
		$this->load->view('template/wrapper',$data);
	}
	}



public function add()
{
	
	$this->check_login->check();
	$data  = array('title' =>'Tambah User' ,
		'form_action' => site_url('user/add'),
	
				'isi'=>'user/v_user_form'
				);

		$valid=$this->form_validation->set_rules('name', 'Name', 'required');	
			$valid=$this->form_validation->set_rules('group', 'Group', 'required');
			$valid=$this->form_validation->set_rules('password', 'Password', 'required');
		$valid=$this->form_validation->set_rules('disabled', 'Disabled', 'required');


	if($valid->run()===TRUE){
			$name = $this->input->post('name');			
			// $network = $this->input->post('network');
			$group = $this->input->post('group');
			$password = $this->input->post('password');
			$passwordlagi = $this->input->post('passwordlagi');
			$disabled = $this->input->post('disabled');
				// if ($password == $passwordlagi) {			
					if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
						$this->routerosapi->write('/user/add',false);				
						$this->routerosapi->write('=name='.$name, false);							
						$this->routerosapi->write('=group='.$group, false);
						$this->routerosapi->write('=password='.$password, false);
						$this->routerosapi->write('=disabled='.$disabled);				
						$ip_user = $this->routerosapi->read();
						$this->routerosapi->disconnect();	
						$this->session->set_flashdata(array(
							'msg'=> 'User Berhasil di Tambah',
							'status'=> 'success'
						));
						redirect('user');
					}}else{
					$data['name'] = $this->input->post('name');
					$data['group'] = $this->input->post('group');
					$data['password'] = $this->input->post('password');

					$data['disabled'] = $this->input->post('disabled');

				}
										
				// } else {
				// 	echo "Password dan confirm password harus sama";
				// }
	
		$this->load->view('template/wrapper',$data);
	
}


	public function edit($id){
		$this->check_login->check();
		$data['title']='Halaman edit  User';
		$data['isi'] = 'user/v_user_form';
		$data['form_action'] = site_url('user/process_update');		
		
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write("/user/print", false);			
			$this->routerosapi->write("=.proplist=.id", false);
			$this->routerosapi->write("=.proplist=name", false);
			$this->routerosapi->write("=.proplist=group", false);	
			$this->routerosapi->write("=.proplist=password", false);	
			$this->routerosapi->write("=.proplist=disabled", false);		
			$this->routerosapi->write("?.id=$id");
					
			$user = $this->routerosapi->read();
			

			foreach ($user as $row)
			{
				if (isset($row['name'])){
					$name = $row['name'];
				}else{
					$name = '';
				}
				
				
				if (isset($row['group'])){
					$group = $row['group'];			
				}else{
					$group = '';
				}
				if (isset($row['password'])){
					$password = $row['password'];			
				}else{
					$password = '';
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
			
			$data['default']['name'] = $name;
			$data['default']['group'] = $group;			
			$data['default']['password'] = $password;	
			$data['default']['passwordlagi'] = $password;			
			$data['default']['disabled'] = $disabled;
		}
		$this->load->view('template/wrapper', $data);
	}
	
	public function process_update(){
		$this->check_login->check();
		$data['title']='Edit User';
		$data['isi'] = 'user/v_user_form';
		$data['form_action'] = site_url('user/process_update');	

		$valid=$this->form_validation->set_rules('name', 'Name', 'required');
		$valid=$this->form_validation->set_rules('group', 'Group', 'required');		
		$valid=$this->form_validation->set_rules('password', 'Password', 'required');		
		// $valid=$this->form_validation->set_rules('passwordlagi', 'Confirm Password', 'required');		
		$valid=$this->form_validation->set_rules('disabled', 'Disabled', 'required');
		
		if ($valid->run() == TRUE)
		{
		$name = $this->input->post('name');			
			$group = $this->input->post('group');
			$password = $this->input->post('password');
			// $passwordlagi = $this->input->post('passwordlagi');
			$comment = $this->input->post('comment');
			$disabled = $this->input->post('disabled');
			
			if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
				$this->routerosapi->write('/user/set',false);				
				$this->routerosapi->write('=.id='.$this->session->userdata('id'),false);
				$this->routerosapi->write('=name='.$name,false);										
				$this->routerosapi->write('=group='.$group, false);				
				$this->routerosapi->write('=password='.$password, false);							
					
				$this->routerosapi->write('=disabled='.$disabled);				
								
				$user_users = $this->routerosapi->read();
				$this->routerosapi->disconnect();	
				$this->session->unset_userdata('id');
				$this->session->set_flashdata('message',' user tersebut berhasil diubah!');
				redirect('user');				
			}	
		}else{
			$data['default']['name'] = $this->input->post('name');
			$data['default']['group'] = $this->input->post('group');
			$data['default']['password'] = $this->input->post('password');
			$data['default']['disabled'] = $this->input->post('disabled');
		}
		$this->load->view('template/wrapper', $data);		
	}


	public function remove($id){
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/user/remove',false);
			$this->routerosapi->write('=.id='.$id);
			$user_users = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata('message','User tersebut berhasil dihapus!');
			redirect('user');
		}	
	}
		
public function disable($id){
$this->check_login->check();		
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/user/disable',false);
			$this->routerosapi->write('=.id='.$id);
			$user_users = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata('message','User tersebut berhasil dinonaktifkan!');
			redirect('user');
		}
	}
	
	public function enable($id){
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/user/enable',false);
			$this->routerosapi->write('=.id='.$id);
			$this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata(array(
				'msg'=> 'User Berhasil di Aktifkan',
				'status'=> 'success'
			));
			redirect('user');
		}
	}
}
