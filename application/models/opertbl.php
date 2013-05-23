<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class Name: name of the class
 * Description: use of the class
 * Content: content of the class
 */
class Opertbl extends CI_Model{

	function __construct(){
		parent::__construct();
	}
    
    public function get_data($itemcode){
        $this->db->where('operationid',$itemcode);
        $query = $this->db->get('operation');
        return $query->num_rows() ? $query->row_array() : FALSE;
    }
    
    public function delete( $operationid){
        $this->db->where('operationid',$operationid);
        $this->db->delete('operation');
        return $this->db->affected_rows() ? TRUE : FALSE;
    }
    
    public function test_id($operation_id){
        $this->db->where('operationid',$operation_id);
        $query = $this->db->get('operation');
        return $query->num_rows() ? TRUE : FALSE;
        
    }
    
}