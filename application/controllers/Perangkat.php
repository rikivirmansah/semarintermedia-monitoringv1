	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perangkat extends CI_Controller {
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

			$data  = array('title' =>'Halaman Perangkat' ,
							'total_results'=>$total_results,	
							'perangkat'=>$perangkat,	
							'isi' =>'perangkat/v_perangkat');
		$this->load->view('template/wrapper',$data);
	}
	}

    public function perangkat()
	{
		
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/tool/netwatch/getall');
			$perangkat = $this->routerosapi->read();
			$this->routerosapi->disconnect();	
            $total_results = count($perangkat);

	}
	}

    public function add()
{
	
	$this->check_login->check();
	$data  = array('title' =>'Tambah Perangkat' ,
		'form_action' => site_url('perangkat/add'),
	
				'isi'=>'perangkat/form_perangkat'
				);

		$valid=$this->form_validation->set_rules('ip_perangkat', 'Ip Perangkat', 'required');	


	if($valid->run()===TRUE){
			$host = $this->input->post('ip_perangkat');	
			$comment = $this->input->post('nama')."/".$this->input->post('lokasi')."/".$this->input->post('no_hp')."/".$this->input->post('latitude')."/".$this->input->post('longitude');
				// if ($password == $passwordlagi) {			
					if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
						$this->routerosapi->write('/tool/netwatch/add',false);				
						$this->routerosapi->write('=host='.$host, false);														
						$this->routerosapi->write('=comment='.$comment );				
						$ip_user = $this->routerosapi->read();
						$this->routerosapi->disconnect();	
						$this->session->set_flashdata(array(
							'msg'=> 'Perangkat Berhasil di Tambah',
							'status'=> 'success'
						));
												if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
            			$this->routerosapi->write("/tool/netwatch/print", false);			
            			$this->routerosapi->write("=.proplist=.id", false);
            			$this->routerosapi->write("=.proplist=host", false);	
            			$this->routerosapi->write("=.proplist=comment", false);						
            			$this->routerosapi->write("?host=$host");
            					
            			$perangkat = $this->routerosapi->read();
            
            			foreach ($perangkat as $row)
            			{
            				if (isset($row['.id'])){
            					$id = $row['.id'];
                    			$this->routerosapi->disconnect();
        						redirect('interkoneksi/list/'.$id);
            				}else{
            					$id = '';
        						redirect('perangkat');
            				}
            				
            			}
					}

						redirect('perangkat');
					}}else{
					$data['ip_perangkat'] = $this->input->post('ip_perangkat');
					$data['comment'] = $this->input->post('nama')."/".$this->input->post('lokasi')."/".$this->input->post('no_hp')."/".$this->input->post('latitude')."/".$this->input->post('longitude');

				}
										
		$this->load->view('template/wrapper',$data);
	
}


	public function edit($id){
		
		$data['title']='Halaman edit Perangkat';
		$data['isi'] = 'perangkat/form_perangkat';
		$data['form_action'] = site_url('perangkat/process_update');		
		
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
			
	

			$data['default']['host'] = $host;			
			$data['default']['comment'] = $comment;					
			$data['default']['disabled'] = $disabled;
			$data['default']['.id'] = $id;
		}
		$this->load->view('template/wrapper', $data);
	}
	
	public function process_update(){

		$data['title'] = 'Edit Perangkat';
		$data['isi'] = 'perangkat/form_perangkat';
		$data['form_action'] = site_url('perangkat/process_update');	
				
			$id = $this->input->post('id');
			$host = $this->input->post('ip_perangkat');
			$comment = $this->input->post('nama')."/".$this->input->post('lokasi')."/".$this->input->post('no_hp')."/".$this->input->post('latitude')."/".$this->input->post('longitude');
			
			if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
				$this->routerosapi->write('/tool/netwatch/set',false);				
				$this->routerosapi->write('=.id='.$id,false);							
				$this->routerosapi->write('=host='.$host, false);													
				$this->routerosapi->write('=comment='.$comment);					
								
				$perangkats = $this->routerosapi->read();
				$this->routerosapi->disconnect();
                $this->session->set_flashdata(array(
                    'msg'=> 'Data berhasil Diupdate',
                    'status'=> 'success'
                ));
                redirect('perangkat');				
			}	

		$this->load->view('template/wrapper', $data);		
	}

    public function disable($id){
        $this->check_login->check();		
                if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
                    $this->routerosapi->write('/tool/netwatch/disable',false);
                    $this->routerosapi->write('=.id='.$id);
                    $this->routerosapi->read();
                    $this->routerosapi->disconnect();	
                    $this->session->set_flashdata(array(
                        'msg'=> 'Data berhasil Dinonaktifkan',
                        'status'=> 'success'
                    ));
                    redirect('perangkat');
                }
            }
            
            public function enable($id){
                $this->check_login->check();
                if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
                    $this->routerosapi->write('/tool/netwatch/enable',false);
                    $this->routerosapi->write('=.id='.$id);
                    $this->routerosapi->read();
                    $this->routerosapi->disconnect();	
                    $this->session->set_flashdata(array(
                        'msg'=> 'Data berhasil Diaktifkan',
                        'status'=> 'success'
                    ));
                    redirect('perangkat');
                }
            }
	
		
public function remove($id){
	
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write('/tool/netwatch/remove',false);
			$this->routerosapi->write('=.id='.$id);
			$this->routerosapi->read();
			$this->routerosapi->disconnect();	
            $this->session->set_flashdata(array(
                'msg'=> 'Data berhasil Dihapus',
                'status'=> 'success'
            ));
            redirect('perangkat');
		}
	}

	
	public function status($status)
	{
		// if ($this->input->is_ajax_request()) {
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write("/tool/netwatch/print", false);			
			$this->routerosapi->write("=.proplist=.id", false);
			$this->routerosapi->write("=.proplist=host", false);	
			$this->routerosapi->write("=.proplist=comment", false);			
			$this->routerosapi->write("=.proplist=interval", false);			
			$this->routerosapi->write("=.proplist=timeout", false);			
			$this->routerosapi->write("=.proplist=status", false);			
			$this->routerosapi->write("=.proplist=since", false);			
			$this->routerosapi->write("?status=$status");
			$status= $this->routerosapi->read();
			$this->routerosapi->disconnect();     
			$total_results = count($status);
			echo json_encode($status);
// } 
} 
 
	}
	public function total()
	{
		if ($this->input->is_ajax_request()) {
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write("/tool/netwatch/getall");			
			$status= $this->routerosapi->read();
			$this->routerosapi->disconnect();     
			$total_results = count($status);
			echo json_encode($status);
		}
} 
 
	}


}
