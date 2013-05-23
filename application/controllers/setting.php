<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        $models = array('selectaction');
        $helpers = array('url','file');
        $libraries = array('session');
        
        $this->load->database();
        
        $this->load->library($libraries);
        $this->load->helper($helpers);
        $this->load->model($models);
        
        if( !$this->session->userdata('login') ){
            redirect('home');
        }
    }
	public function index()
	{
        redirect('home');
	}
    
    public function clean_photo() {
        $photos = glob("public/images/contents/*");
        foreach ($photos as $key => $value) {
            $image_properties = pathinfo($value);
            $this->db->where('image',$image_properties['basename']);
            $query = $this->db->get('item');
            if( !$query->num_rows() ){
                unlink("public/images/contents/".$image_properties['basename']);
            }
        }
        redirect('item/newitem');
    }
    
    public function clean_table($table = ''){
        $table = strtolower($table);
        if( $table === 'status' || $table === 'operation' ){
            $query = $this->db->get($table);
            foreach ($query->result_array() as $key => $value) {
                $this->db->where('itemcode',$value['itemcode']);
                $quers = $this->db->get('item');
                if( !$quers-> num_rows() ){
                    $this->db->where('itemcode',$value['itemcode']);
                    $this->db->delete($table);
                }
            }
        }
    }
}

/* End of file setting.php */
/* Location: ./application/controllers/setting.php */