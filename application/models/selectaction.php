<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class Name: Selectaction
 * Description: Use to manipulate the table select_action
 * Content: select tag composed of the action inserted in the table
 *          get, update,delete,add action.
 */
class Selectaction extends CI_Model{

	function __construct(){
		parent::__construct();
	}
    
    public function get_all(){
        $query = $this->db->get('select_action');
        return $query->result_array();
    }
    
    public function get_actionid($description) {
        $this->db->select('actionid');
        $this->db->where('description',$description);
        $query = $this->db->get('select_action');
        
        if( $query->num_rows() > 0 ){
            $result = $query->result_array();
            return $result[0]['actionid'];
        }
        
        return FALSE;
    }
    
    public function get_description($actionid){
        $this->db->select('description');
        $this->db->where('actionid',$actionid);
        $query = $this->db->get('select_action');
        
        if( $query->num_rows() > 0 ){
            $result = $query->row_array();
            return $result['description'];
        }
        
        return FALSE;
    }
    
    public function add_action($action){
        $action = ucwords(strtolower($action));
        if( !$this->get_actionid($action) ){
            $insertaction = array('description' => $action );
            $this->db->insert('select_action',$insertaction);
            return $this->db->affected_rows() > 0 ? TRUE : FALSE;
            
        }
        return FALSE;
    }
    
    public function delete_action($actionid) {
        $this->db->where('actionid',$actionid );
        $this->db->delete("select_action");
        return TRUE;
    }
    
    public function edit_action($actionid,$description) {
        $updateaction = array('description' => ucwords(strtolower($description)) );
        $this->db->where('actionid',$actionid );
        $this->db->update('select_action',$updateaction );
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }
    
    
}