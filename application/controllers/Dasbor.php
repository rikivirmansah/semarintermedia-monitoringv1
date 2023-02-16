<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dasbor extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->check_login->check();
    }

	public function index()
	{
		if ($this->routerosapi->connect($this->session->userdata('hostname_mikrotik'), $this->session->userdata('username_mikrotik'), $this->session->userdata('password_mikrotik'))){
			$this->routerosapi->write("/tool/netwatch/print", false);			
			$this->routerosapi->write("=.proplist=.id", false);
			$this->routerosapi->write("=.proplist=host", false);	
			$this->routerosapi->write("=.proplist=comment", false);			
			$this->routerosapi->write("=.proplist=interval", false);			
			$this->routerosapi->write("=.proplist=timeout", false);			
			$this->routerosapi->write("=.proplist=status", false);			
			$this->routerosapi->write("=.proplist=since", false);			
			$this->routerosapi->write("?status=down");
			$perangkat= $this->routerosapi->read();
			$this->routerosapi->disconnect();  			
			$total_results = count($perangkat);

			$data  = array('title' =>'Halaman Dashboard' ,
							'total_results'=>$total_results,	
							'perangkat'=>$perangkat,	
							'isi' =>'dasbor/v_dasbor');
		$this->load->view('template/wrapper',$data);
	}
	}
	


}
