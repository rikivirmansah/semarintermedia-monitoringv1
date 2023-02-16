<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public function index()
	{		
		if ($this->session->userdata('login') == TRUE)
		{
			redirect('dasbor');
		}else{
			$data['form_action'] = base_url('login/process_login');
			 $data['title'] = 'Login Mikrotik';
			$this->load->view('login/login_form', $data);	
		}				
	}
	
	public function process_login(){
		$this->form_validation->set_rules('hostname', 'hostname', 'required');
		$this->form_validation->set_rules('username', 'username', 'required');		
		
		if ($this->form_validation->run() == TRUE)
		{
			$hostname = $this->input->post('hostname');
			$username = $this->input->post('username');
			$password = $this->input->post('password');								
			
			if ($this->routerosapi->connect($hostname, $username, $password))
			{				
				$data = array('hostname_mikrotik'=> $hostname, 'username_mikrotik' => $username, 'password_mikrotik' => $password, 'login' => TRUE);
				$this->session->set_userdata($data);
				 redirect('dasbor');
				// echo "berhasil";
			}
			else
			{
				$this->session->set_flashdata(array(
					'msg'=> 'Gagal Login',
					'status'=> 'error'
				));
				redirect('login');
			}			
		}
		else
		{
			
			$data['form_action'] = base_url('login/process_login');
			// $this->session->set_flashdata('sukses', $this->routerosapi->connect($hostname, $username, $password));
			redirect('login');
		}
	}
	
		public function logout(){
		$this->session->unset_userdata(array('hostname_mikrotik' => '', 'username_mikrotik'=>'', 'password_mikrotik' => '','login' => FALSE));
		$this->session->sess_destroy();
		$this->session->set_flashdata(array(
			'msg'=> 'User Berhasil di Logout',
			'status'=> 'success'
		));
				redirect('login');
	}
}


