<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oops extends CI_Controller {
	// Main page - Homepage
	public function index()
	{
		$data['title'] = 'Oops ' ;
		
				
		$this->load->view('v_oops',$data,FALSE);
	}
}
