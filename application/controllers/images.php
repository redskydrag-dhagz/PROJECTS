<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        $models = array('selectaction','itemtbl');
        $helpers = array('url','form'); 
        $libraries = array('form_validation','session','upload');
        
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
        redirect("images/insert");
	}
    
    public function insert(){
        $forms = $this->form_validation;
        #Configuration for uploading image file
        $config['upload_path'] = 'public/images/contents/'; #image path to be uploaded
        $config['allowed_types'] = 'png|jpeg|jpg'; #type of image to be uploaded
        $config['max_size'] = '1000';#maximum file size
        
        $data['message'] = $this->session->userdata('message');#set the message
        
        $this->upload->initialize($config); #initialize the config upload library
        
        $forms->set_rules("itemcode",'Item Code','trim|required|callback_code');#set_rules for the input "itemcode"
        if( $forms->run() ){ #test if the set_rules is correct
            if( !$this->upload->do_upload('image') ){ #upload the image and return true if uploaded false if not
                $this->session->set_userdata('message',$this->upload->display_errors()); #message value to display errors
            }else{
                $data = $this->upload->data(); #the data been uploaded
                $this->db->where('itemcode',$this->input->post('itemcode')); # WHERE itemcode = "itemcodeinput";
                $this->db->update('item', array('image' => $data['file_name']));#update the table item, column image;
                if( $this->db->affected_rows() ){ #test if the query is successfully updated
                    $this->session->set_userdata('message',"Uploaded!");
                    redirect('images/insert');
                }
            }
        }
        
        $this->load->view('heading');
        $this->load->view('image/insert_page',$data);
        $this->load->view('footing');
    }
    
    public function code($itemcode){ #for above function used in the set_rules() callback.
        $this->form_validation->set_message('code','Invalid Code');
        return $this->itemtbl->test_itemcode($itemcode);
    }
}

/* End of file images.php */
/* Location: ./application/controllers/images.php */