<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Manipulate status table.
 */

class Statustbl extends CI_Model{

	function __construct(){
		parent::__construct();
	}
    
    public function add( $insertstat = array() ) {
        $this->db->insert('status',$insertstat );
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }
    
    public function process( $insertstat = array(),$original = '', $process = 'add' ) {
        $insertstat['itemcode'] = strtoupper($insertstat['itemcode']);
        $insertstat['status'] = ucwords(strtolower($insertstat['status']));
        $insertstat['client'] = ucwords(strtolower($insertstat['client']));
        $insertstat['date'] = ucwords(strtolower($insertstat['date']));
        if( $process === 'add' ){
            if( !$this->test_itemcode($insertstat['itemcode']) ){
                return $this->add($insertstat);
            }
        }
        
        if( $process === 'edit' ){
            $this->db->where('itemcode',$original);
            $this->db->update('status',$insertstat);
            
             if( $this->db->affected_rows() > 0 ) return TRUE;
        }
        
        if( $process === 'delete' ){
            $this->db->where('itemcode',$original );
            $this->db->delete('status');
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function test_itemcode( $itemcode ) {
        $this->db->where('itemcode',$itemcode);
        $query = $this->db->get('status');
        return $query->num_rows() > 0 ? TRUE : FALSE;
    }
    
    public function get_data( $itemcode ) {
        $this->db->where('itemcode',$itemcode);
        $query = $this->db->get('status');
        return $query->row_array();
    }
    
}