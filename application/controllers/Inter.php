	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inter extends CI_Controller {

	
	public function index()
	{
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/interface/getall');
			$interface = $this->routerosapi->read();
			$this->routerosapi->disconnect();			
			$total_results = count($interface);

			$data  = array('title' =>'Halaman inteface' ,
							'total_results'=>$total_results,	
							'interface'=>$interface,
							'isi' =>'interface/v_interface');
		$this->load->view('template/wrapper',$data);
	}
	}

	public function edit($id){
		$this->check_login->check();
		$data['title']='Halaman edit Interface';
		$data['isi'] = 'interface/v_interface_form';
		$data['form_action'] = site_url('inter/process_update');		
		
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write("/interface/print", false);			
			$this->routerosapi->write("=.proplist=.id", false);
			$this->routerosapi->write("=.proplist=name", false);	
			$this->routerosapi->write("=.proplist=comment", false);	
			$this->routerosapi->write("=.proplist=disabled", false);		
			$this->routerosapi->write("?.id=$id");
					
			$inter_user = $this->routerosapi->read();

			foreach ($inter_user as $row)
			{
				if (isset($row['name'])){
					$name = $row['name'];
				}else{
					$name = '';
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
			

			$data['default']['name'] = $name;			
			$data['default']['comment'] = $comment;			
			$data['default']['disabled'] = $disabled;
		}
		$this->load->view('template/wrapper', $data);
	}
	
	public function process_update(){
$this->check_login->check();
		$data['isi'] = 'interface/v_interface_form';
		$data['form_action'] = site_url('inter/process_update');	

		$valid=$this->form_validation->set_rules('name', 'Name', 'required');	
		$valid=$this->form_validation->set_rules('disabled', 'Disabled', 'required');

		
		if ($valid->run() === TRUE)
		{
				
			$name = $this->input->post('name');
			$comment = $this->input->post('comment');
			$disabled = $this->input->post('disabled');
			
			if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
				$this->routerosapi->write('/interface/set',false);				
				$this->routerosapi->write('=.id='.$this->session->userdata('id'),false);							
				$this->routerosapi->write('=name='.$name, false);							
				$this->routerosapi->write('=comment='.$comment, false);						
				$this->routerosapi->write('=disabled='.$disabled);				
								
				$inter_users = $this->routerosapi->read();
				$this->routerosapi->disconnect();	
				$this->session->unset_userdata('id');
				$this->session->set_flashdata('message','Data interface tersebut berhasil diubah!');
				redirect('inter');				
			}	
		}else{
			$data['default']['name'] = $this->input->post('name');
			$data['default']['comment'] = $this->input->post('comment');
			$data['default']['disabled'] = $this->input->post('disabled');
		}
		$this->load->view('template/wrapper', $data);		
	}


	
		
public function disable($id){
$this->check_login->check();		
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/interface/disable',false);
			$this->routerosapi->write('=.id='.$id);
			$inter_users = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata('message','Data interface tersebut berhasil dinonaktifkan!');
			redirect('inter');
		}
	}
	
	public function enable($id){
		$this->check_login->check();
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/interface/enable',false);
			$this->routerosapi->write('=.id='.$id);
			$inter_users = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
			$this->session->set_flashdata('message','Data interface tersebut berhasil diaktifkan!');
			redirect('inter');
		}
	}
}
