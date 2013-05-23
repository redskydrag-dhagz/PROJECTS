<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class Name: Selectconsign
 * Description: to manipulate the data of table select_consign
 * Content: select tag,
 */
class Selectconsign extends CI_Model{

	function __construct(){
		parent::__construct();
	}
   
    public function get_all(){
        $query = $this->db->get('select_consign');
        return $query->result_array();
    }
    
    public function get_consignid($description) {
        $this->db->select('consignid');
        $this->db->where('description',$description);
        $query = $this->db->get('select_consign');
        
        if( $query->num_rows() > 0 ){
            $result = $query->result_array();
            return $result[0]['consignid'];
        }
        
        return FALSE;
    }
    
    public function get_description($actionid){
        $this->db->select('description');
        $this->db->where('consignid',$actionid);
        $query = $this->db->get('select_consign');
        
        if( $query->num_rows() > 0 ){
            $result = $query->result_array();
            return $result[0]['description'];
        }
        
        return FALSE;
    }
    
    public function add_action($action){
        $action = ucwords(strtolower($action));
        if( !$this->get_actionid($action) ){
            $insertaction = array('description' => $action );
            $this->db->insert('select_consign',$insertaction);
            return $this->db->affected_rows() > 0 ? TRUE : FALSE;
            
        }
        return FALSE;
    }
    
    public function delete_action($actionid) {
        $this->db->where('consignid',$actionid );
        $this->db->delete("select_consign");
        
        return TRUE;
    }
    
    public function edit_action($actionid,$description) {
        $updateaction = array('description' => ucwords(strtolower($description)) );
        $this->db->where('consignid',$actionid );
        $this->db->update('select_consign',$updateaction );
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }
    
    public function string_all(){
        $arr = $this->get_all();
        $temp_array = array();
        foreach ($arr as $key => $value) {
            $temp_array[$key] = '"'.$value['description'].'"';
        }
        
        return implode(",", $temp_array);
    }
    
    
    
}