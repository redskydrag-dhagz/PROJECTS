<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
        $library = array('form_validation','session');
        $helper = array('form','url');
        
        $this->load->library($library);
        $this->load->model('users');
        $this->load->helper($helper);
    }
	public function index()
	{
        $data['message'] = "";
        $this->load->helper('url');
		$this->load->view('home',$data);
	}
    
    public function login(){
        $forms = $this->form_validation;
        $data['message'] = "";
        $forms->set_rules('username','Username','trim|required');
        $forms->set_rules('password','Password','trim|required');
        if( $forms->run() ){
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
           
            if( $this->users->test_user($username,$password) ){
                $this->session->set_userdata('login',TRUE);
                redirect("home/door");
            }else{
                $data['message'] = 'Invalid Username or Password!';
                $this->load->view('home',$data);
            }
        }else{
            $this->load->view('home',$data);
        }
    }
    
    public function logout(){
        $this->session->unset_userdata('login');
        redirect('home');
    }
    
    public function door(){
        $this->load->view('heading');
        $this->load->view('bahay');
        $this->load->view('footing');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */