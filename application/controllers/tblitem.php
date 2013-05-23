<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tblitem extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        $models = array('selectaction','selectconsign');
        $helpers = array('url');
        $libraries = array();
        
        $this->load->database();
        
        $this->load->library($libraries);
        $this->load->helper($helpers);
        $this->load->model($models);
    }
	public function index()
	{
        redirect('home');
	}
    
    public function set_item(){
        $query = $this->db->get('tbl_item');
        $insert_item = array();
        foreach ($query->result_array() as $key => $value) {
            $insert_item['itemcode'] = strtoupper($value['code']);
            $insert_item['description'] = $value['description'];
            $insert_item['price'] = $value['srp'];
            $this->db->insert('item',$insert_item);
        }
    }
    
    public function set_comment(){
        $query = $this->db->get('comment');
        $insert_item = array();
        foreach ($query->result_array() as $key => $value) {
            $insert_comment['itemcode'] = strtoupper($value['item_code']);
            $insert_comment['status'] = $this->selectaction->get_actionid($value['status']);
            $insert_comment['price'] = $value['price'];
            print_r($insert_comment);
            echo "<br />";
            //$this->db->insert('item',$insert_item);
        }
    }
    
    public function test(){
        $query = $this->db->get('item');
        foreach($query->result_array() as $key => $value){
            $this->db->where('item_code',$value['itemcode']);
            $quer = $this->db->get('comment');
            echo $quer->num_rows() === 0 ? $value['itemcode']."<br />" : "";
        }
    }
    
    public function set_operation() {
        $query = $this->db->get('transactions');
        echo $query->num_rows();
        foreach ($query->result_array() as $key => $value) {
            $insert_operation['itemcode'] = $value['item_code'];
            $insert_operation['client'] = $this->selectconsign->get_consignid($value['client']) ? $this->selectconsign->get_consignid($value['client']) : $value['client'];
            $status = $value['status'];
            if( $status === "del_rec" || $status === "pull" ){
                $status = $status === "del_rec" ? "Delivery Receipt" : "Pull-Out";
                $status = $this->selectaction->get_actionid($status);
            }
            $insert_operation['state'] = $status;
            $insert_operation['price'] = $value['price'];
            $insert_operation['date'] = $value['date'];
            //print_r($insert_operation);
            //$this->db->insert('operation',$insert_operation);
        }
    }
    
    public function set_status(){
        $query = $this->db->get('comment');
        echo $query->num_rows();
        foreach ($query->result_array() as $key => $value) {
            $insert_operation['itemcode'] = $value['item_code'];
            $insert_operation['client'] = $this->selectconsign->get_consignid($value['client']) ? $this->selectconsign->get_consignid($value['client']) : $value['client'];
            $status = $this->selectaction->get_actionid($value['status']);
            if( $status === "del_rec" || $status === "pull" ){
                $status = $status === "del_rec" ? "Delivery Receipt" : "Pull-Out";
                $status = $this->selectaction->get_actionid($status);
            }
            $insert_operation['status'] = $status;
            $insert_operation['price'] = $value['price'];
            $insert_operation['date'] = $value['date'];
            //print_r($insert_operation);
            $this->db->insert('status',$insert_operation);
        }
    }
    
    public function set_image(){
        $count = 0;
        $this->db->like('image',".jpg");
        $query = $this->db->get('item');
        echo $this->db->last_query();
        foreach ($query->result_array() as $value) {
            $src['image'] = $value['image'];
            $image = pathinfo($value['image']);
            print_r($image);
            echo $ext = $image['extension'];
            
            
            if( $ext === "jpg" || $ext === "JPG" ){
                $src['image'] = $image['filename'].".png";
                $count++;
            }
            $this->db->where('itemcode',strtoupper($value['itemcode']));
            //$this->db->update('item',$src);
        }
        
        echo $count;
    }
    
    public function test_image(){
        $images = glob("public/images/contents/*");
        foreach ($images as $key => $value) {
            $image = pathinfo($value);
            $this->db->where('image',$image['basename']);
            $query = $this->db->get('item');
            echo $query->num_rows() > 0 ? "" : $image['basename']."<br />";
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */