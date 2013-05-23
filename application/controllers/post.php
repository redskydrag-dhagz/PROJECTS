<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        $models = array('selectaction','itemtbl','statustbl');
        $helpers = array('url','form');
        $libraries = array('form_validation','session');
        
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
        redirect('item/newitem');
	}
    
    public function search(){
        
        $return = $this->itemtbl->get_data($this->input->post('itemcode'));
        echo json_encode($return);
    }
    
    public function deleted() {
        if( $this->input->post('itemcode') ){
            $this->db->where('itemcode',$this->input->post('itemcode'));
            $this->db->delete('item');
            $this->db->where('itemcode',$this->input->post('itemcode'));
            $this->db->delete('status');
            echo $this->db->affected_rows() ? "Deleted" : "Failed!";
        }
    }
    
    public function check_code() {
        $input = $this->input;
        $itemcode = strtoupper($input->post('itemcode'));
        $price = $this->itemtbl->get_price($itemcode);
        $array = array('itemcode' => $this->itemtbl->test_itemcode($itemcode),'price' => $price);
        echo json_encode($array);
    }
    
    public function get_img(){
        $itemcode = $this->input->post('itemcode');
        echo $this->itemtbl->get_img($itemcode);
    }
}