<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maneuver extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        $models = array('selectaction','selectconsign','itemtbl','statustbl','opertbl');
        $helpers = array('url','select','form');
        $libraries = array('form_validation','session','pagination','uri');
        
        $this->load->database();
        
        $this->load->library($libraries);
        $this->load->helper($helpers);
        $this->load->model($models);
        
        //unset the session item_column
        $this->session->unset_userdata('item_column');
        $this->session->unset_userdata('item_row');
        
        if( !$this->session->userdata('login') ){
            redirect('home');
        }
    }
	public function index()
	{
        redirect('home');
	}
    
    public function process() {
        $input = $this->input; $forms = $this->form_validation;
        $data['nos'] = 0;
        $data['errors'] = $this->session->flashdata('errors');
        
        $data['consign'] = $this->selectconsign->get_all();
        $data['action'] = $this->selectaction->get_all();
        $data['string_all'] = $this->selectconsign->string_all();
        
        if( $input->post('nosgo') ){
            $forms->set_rules('action','Action','trim');
            $forms->set_rules('consign','Consign','trim');
            $forms->set_rules('date','Date','trim');
            $forms->set_rules('itemcode[]','Item Code','trim');
            $forms->set_rules('price[]','Price','trim');
            $forms->set_rules('nos','Nos of Item','trim|numeric|required');
            if( $forms->run() ){
                $data['nos'] = $input->post('nos');
            }
        }
        
        if( $input->post('submit') ){
            $trap = TRUE;
            
            $data['nos'] = count($input->post('itemcode'));
            
            $forms->set_rules('action','Action','trim|required');
            $forms->set_rules('consign','Consign','trim|required');
            $forms->set_rules('date','Date','trim|required');
            $forms->set_rules('itemcode[]','Item Code','trim|uppercase|required');
            $forms->set_rules('price[]','Price','trim|numeric');
            
            if( $forms->run() ){
                $post_array = array_count_values($this->changetouppercase($input->post('itemcode')));
                if( count($post_array) < count($input->post('itemcode')) ){
                    $trap = FALSE;
                    $data['errors'] = 'Two or more Item Code!';
                }
                if( !$this->itemcode($input->post('itemcode')) ){
                    $trap = FALSE;
                    $data['errors'] = "Invalid Item Code";
                }
                
                if( $trap ){
                    $action = $input->post('action');
                    $consign = $input->post('consign');
                    $date = $input->post('date');
                    $insert_batch_operation = $insert_batch_status = array();
                    
                    foreach ($input->post('itemcode') as $key => $value) {
                        $insert_batch_operation[$key]['itemcode'] = $insert_batch_status[$key]['itemcode'] = strtoupper($value);
                        $insert_batch_operation[$key]['state'] = $insert_batch_status[$key]['status'] = $action;
                        $insert_batch_operation[$key]['client'] = $insert_batch_status[$key]['client'] = $this->selectconsign->get_consignid($consign) ? $this->selectconsign->get_consignid($consign) : $consign;
                        $insert_batch_operation[$key]['date'] = $insert_batch_status[$key]['date'] = $date;
                        $insert_batch_operation[$key]['price'] = $insert_batch_status[$key]['price'] = $_POST['price'][$key];
                    }
                    
                    $action = $this->selectconsign->get_consignid($consign);
                    
                    if( $action !== "Sold" && $action !== "Stock"  ){
                        $this->db->insert_batch('operation',$insert_batch_operation);
                        $this->session->set_flashdata('errors', $this->db->affected_rows() ? "Saved!" : "");
                    }
                    
                    
                    $this->db->update_batch('status',$insert_batch_status,'itemcode');
                    redirect('maneuver/process');
                }
                
            }
            
        }       
        
        $this->load->view('heading');
        $this->load->view('operation/process_page',$data);
        $this->load->view('footing');
    }
    
    public function changetouppercase($array) {
        $arr = array();
        foreach ($array as $key => $value) {
            $arr[$key] = strtoupper($value);
        }
        return $arr;
    }
    
    private function itemcode($itemcode){
        $trap = TRUE;
        foreach( $itemcode as $value){
            if( !$this->itemtbl->test_itemcode($value) ){
                $trap = FALSE;
            }
        }
        return $trap;
    }
    
    
    public function edit() {
        $input = $this->input; $forms = $this->form_validation;
        $data['string_all'] = $this->selectconsign->string_all();
        $data['message'] = '';
                
        $column = $this->session->userdata('maneuver_edit_column');
        $row = $column === "date" ? $this->session->userdata('maneuver_edit_row') : ($this->selectconsign->get_consignid($this->session->userdata('maneuver_edit_row')) ? $this->selectconsign->get_consignid($this->session->userdata('maneuver_edit_row')) : $this->session->userdata('maneuver_edit_row')) ;
        
        if( $input->post('submit') ){
            $this->session->set_userdata('maneuver_edit_column',$input->post('search'));
            $this->session->set_userdata('maneuver_edit_row',$input->post('searchvalue'));
            
            $forms->set_rules('searchvalue','Value','trim');
            $forms->set_rules('search','Search By','trim');
            
            if( $forms->run() ){
                $column = $input->post('search');
                $row = $column === "date" ? $input->post('searchvalue') : ( $this->selectconsign->get_consignid($input->post('searchvalue')) ? $this->selectconsign->get_consignid($input->post('searchvalue')) : $input->post('searchvalue') ) ;
                if( strlen($row) === 0 ){
                    $data['message'] = "No transaction found!";
                }
            }
        }
        
        if( strlen($column) > 0 && strlen($row) > 0){
            $this->db->where($column, $row);
        }
        
        $config['use_page_numbers'] = TRUE;
        $config['first_link'] = '<i class="icon-fast-backward"></i>';
        $config['last_link'] = '<i class="icon-fast-forward"></i>';
        $config['next_link'] = '<i class="icon-forward"></i>';
        $config['prev_link'] = '<i class="icon-backward"></i>';
        $config['anchor_class'] = ' class="pages_links" ';
        $config['base_url'] = base_url()."maneuver/edit"; //links to be created and insert the pagination 
        $config['per_page'] = $per_page = 6; //number of rows per page
        $show_rows = $this->uri->segment(3); //get the current page number. . 
        
        $this->db->join("item","item.itemcode = operation.itemcode");
        $query = $this->db->get('operation');
        $sql_str = $this->db->last_query()." LIMIT ".($show_rows ? ($show_rows -1) * $config['per_page'].", " : "")." ".$config['per_page'];
        
        $config['total_rows'] = $query->num_rows(); //total rows of the table
        
        $this->pagination->initialize($config); //initialize the config for the links
        $data['links'] = $this->pagination->create_links(); //create a links
        
        //create a pagination for viewing the transactions
         // query to display in the page
        $query = $this->db->query($sql_str);
        $data['datus'] = $query->result_array();
        $array = array();
        foreach ($query->result_array() as $key => $value) {
            $array[$key]['status'] = $this->selectaction->get_description($value['state']);
            $array[$key]['client'] = $this->selectconsign->get_description($value['client']) ? $this->selectconsign->get_description($value['client']) : $value['client'];
        }
        
        $data['stat_client'] = $array;
        
        $this->load->view('heading');
        $this->load->view('operation/edit_page',$data);
        $this->load->view('footing');
        
    }
    
    public function update( $itemcode = '' ){
        $trap = TRUE;
        $data = array();
        $data['consign'] = $this->selectconsign->get_all();
        $data['action'] = $this->selectaction->get_all();
        
        $form = $this->form_validation;
        
        if( strlen($itemcode) === 0 ){
            $trap = FALSE;
        }
        
        if( !$this->opertbl->test_id($itemcode) ){
            $trap = FALSE;
        }
        
        if( $trap ){
            $data['message'] = $this->session->flashdata('message');
            $data['stat_oper'] = $this->opertbl->get_data($itemcode);
            $data['client'] = $consignid = $this->input->post('client') ? $this->input->post('client') : ( $this->selectconsign->get_description($data['stat_oper']['client']) ? $this->selectconsign->get_description($data['stat_oper']['client']) : $data['stat_oper']['client']);
            
            $form->set_rules('action','Action','required');
            $form->set_rules('client','Client','trim|required');
            $form->set_rules('date','Date','trim|required');
            $form->set_rules('price','Price','trim|numeric');
            
            if( $form->run() ){
                $update_operation = array(); 
                $client = $this->selectconsign->get_consignid($consignid) ? $this->selectconsign->get_consignid($consignid) : $consignid;
                $update_operation['state'] = $update_status['status'] = $this->input->post('action');
                $update_operation['client'] = $update_status['client'] = $client;
                $update_operation['date'] = $update_status['date'] = $this->input->post('date');
                $update_operation['price'] = $update_status['price'] = $this->input->post('price');
                
                $this->db->where('itemcode',$this->input->post('itemcode'));
                $query = $this->db->get('status');
                $query = $query->row_array();
               // print_r($query);
                if( strtotime($query['date']) < strtotime($this->input->post('date')) ){
                    $this->db->where('itemcode',$this->input->post('itemcode'));
                    $this->db->update('status',$update_status);
                }
                
                
                $this->db->where('operationid',$itemcode);
                $this->db->update('operation',$update_operation);
                $message_to_display = $this->db->affected_rows() ? "Updated!" : "Cannot Update!";
                
                $this->session->set_flashdata('message',$message_to_display);
                
                redirect( base_url().$this->uri->uri_string() );
            }
        }  else {
            redirect('maneuver/edit');
        }
        
        $data['string_all'] = $this->selectconsign->string_all();
        
        $this->load->view('heading'); 
        $this->load->view('operation/update_page',$data);
        $this->load->view('footing');
        
        
    }
    
    public function delete() {
        $itemcode = $this->input->post('itemcode');
        echo $this->opertbl->delete($itemcode);
    }
}

/* End of file maneuver.php */
/* Location: ./application/controllers/maneuver.php */