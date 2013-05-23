<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        $models = array('selectaction','itemtbl','statustbl','selectconsign');
        $helpers = array('url','form',);
        $libraries = array('form_validation','session','pagination','uri');
        
        $this->load->database();
        
        $this->load->library($libraries);
        $this->load->helper($helpers);
        $this->load->model($models);
        
        if( !$this->session->userdata('login') ){ #test if the session variable login is true then accessing this controller is true
            redirect('home');
        }
    }
	public function index()
	{
        redirect('item/newitem');
	}
    
    public function newitem(){
        
        $form = $this->form_validation;
        
        #trap funciton for the forms
        $form->set_rules('itemcode','Item Code','trim|required|callback_code');
        $form->set_rules('description','Description','trim|required');
        $form->set_rules('package','Package','trim');
        $form->set_rules('price','Price','trim|numeric');
        
        if( $form->run() ){ #run the form and test the rules
            array_pop($_POST);#remove the submit value for directly inserting to the item table
            $this->itemtbl->process($_POST);#insert the item
            #this for the status of the item. DEFAULT: is stock of SNL
            $status['itemcode'] = $_POST['itemcode'];
            $status['status'] = $this->selectaction->get_actionid('Stock');
            $status['client'] = 'SNL';
            $status['date'] = date('Y-m-d');
            $this->statustbl->process($status); #insert into status table
            
        }
        
        $this->load->view('heading');
        $this->load->view('item/newitem_page');
        $this->load->view('footing');
    }
    
    #use for the trapping the itemcode at newitem function
    public function code($itemcode){
        $this->form_validation->set_message('code','Already Exist!');
        return !$this->itemtbl->test_itemcode($itemcode);
        
    }
    
    public function updateitem() {
        $form = $this->form_validation;
        
        $message['success'] = $this->session->flashdata('success'); #set the message
        $message['itemcode'] = $this->input->post('itemcodehid') ? $this->input->post('itemcodehid') : $this->uri->segment(3); #set the itemcode
        
        $form->set_rules('itemcodehid','Item Code','trim|required');
        $form->set_rules('itemcode','Item Code','trim|required');
        $form->set_rules('description','Description','trim|required');
        $form->set_rules('package','Package','trim');
        $form->set_rules('price','Price','trim|numeric'); 
        
        if( $form->run() ){
            array_pop($_POST);
            $itemcodehid = $_POST['itemcodehid'];
            array_pop($_POST);
            if( !$this->itemtbl->test_itemedit($itemcodehid,$_POST['itemcode']) ){
                $this->itemtbl->process($_POST,$itemcodehid,'edit');
                $status['itemcode'] = $_POST['itemcode'];
                $status['status'] = $this->selectaction->get_actionid('Stock');
                $status['client'] = "Snl";
                $status['date'] = date('Y-m-d');
                $this->statustbl->process($status,$itemcodehid,'edit');
                $this->session->set_flashdata('success','Updated');
                redirect(base_url().uri_string());
            }else{
                echo "dhagz";
            }
        }
        
        $this->load->view('heading');
        $this->load->view('item/updateitem_page',$message);
        $this->load->view('footing');
    }
    
    public function viewitem() {
        $form = $this->form_validation;
        $trap_total_rows = TRUE; //trap if the searching is equal to zero
        if( $this->input->post('submitsearch') ){
            $form->set_rules('searchvalue','Search Value','trim|required');
            if( $form->run() ){
                if( $this->input->post('search') === "itemcode" ){
                    $this->db->where("item.".$this->input->post('search'),$this->input->post('searchvalue'));
                }else{
                    $this->db->like("item.".$this->input->post('search'),$this->input->post('searchvalue'));
                }
                
                $this->session->set_userdata("item_column",$this->input->post('search'));
                $this->session->set_userdata("item_row",$this->input->post('searchvalue'));
            }else{
                $this->session->unset_userdata("item_column");
                $this->session->unset_userdata("item_row");
            }
        }
        if( $this->session->userdata('item_column') && $this->session->userdata('item_row')){
            if( $this->session->userdata('item_column') === "itemcode" ){
                $this->db->where("item.".$this->session->userdata('item_column'),$this->session->userdata('item_row'));
            }else{
                $this->db->like("item.".$this->session->userdata('item_column'),$this->session->userdata('item_row'));
            }
        }
        $config['base_url'] = base_url()."item/viewitem";
        $config['uri_segment'] = 3;
        $config['num_links'] = 5;
        $segment = $this->uri->segment(3);
        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;
        $config['first_link'] = '<i class="icon-fast-backward"></i>';
        $config['last_link'] = '<i class="icon-fast-forward"></i>';
        $config['next_link'] = '<i class="icon-forward"></i>';
        $config['prev_link'] = '<i class="icon-backward"></i>';
        
        $this->db->select("item.itemcode,item.price,item.image, status.status,status.client, status.date, item.description");
        $this->db->join('status','status.itemcode = item.itemcode',"left");
        $query = $this->db->get('item');
        $sql_str = $this->db->last_query()." LIMIT ".($segment ? ($segment-1) * $config['per_page'].", " : "").$config['per_page'];
        
        $config['total_rows'] = $query->num_rows();
       
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
       
        $query = $this->db->query($sql_str);
        $array = array();
        
        $data['datus']  = $query->result_array();
        foreach ($query->result_array() as $key => $value) {
            $array[$key]['status'] = $this->selectaction->get_description($value['status']);
            $array[$key]['client'] = $this->selectconsign->get_description($value['client']) ? $this->selectconsign->get_description($value['client']) : $value['client'];
        }
        
        $data['stat_client'] = $array;
        
        $this->load->view('heading');
        $this->load->view('item/viewitem_page',$data);
        $this->load->view('footing'); 
    }
    
    public function delete() {
        $itemcode = $this->input->post('itemcode');
        
        if( $this->itemtbl->test_itemcode($itemcode) ){
            $tables = array('item','status','operation');
            echo $this->itemtbl->delete_item($itemcode,$tables);
            echo $this->db->last_query();
        }else{
            echo "Invalid Item Code";
        }
    }
}

/* End of file item.php */
/* Location: ./application/controllers/item.php */