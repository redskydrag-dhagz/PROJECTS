<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Do_job extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        $models = array('selectaction');
        $helpers = array('url');
        $libraries = array();
        
        $this->load->database();
        
        $this->load->library($libraries);
        $this->load->helper($helpers);
        $this->load->model($models);
    }
    
	public function index()
	{
        
        $this->load->view('heading');
        
        $this->load->view('footing');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */