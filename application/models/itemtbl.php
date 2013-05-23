<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Manipulate item table.
 */

class Itemtbl extends CI_Model{

	function __construct(){
		parent::__construct();
	}
    
    public function add( $insertItem = array() ) {
        $this->db->insert('item',$insertItem );
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }
    
    public function process( $insertItem = array(),$original = '', $process = 'add' ) {
        $insertItem['itemcode'] = strtoupper($insertItem['itemcode']);
        $insertItem['description'] = ucwords(strtolower($insertItem['description']));
        $insertItem['package'] = ucwords(strtolower($insertItem['package']));
        if( $process === 'add' ){
            if( !$this->test_itemcode($insertItem['itemcode']) ){
                return $this->add($insertItem);
            }
        }
        
        if( $process === 'edit' ){
            $this->db->where('itemcode',$original);
            $this->db->update('item',$insertItem);
            
             if( $this->db->affected_rows() > 0 ) return TRUE;
        }
        
        if( $process === 'delete' ){
            $this->db->where('itemcode',$original );
            $this->db->delete('item');
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function test_itemcode( $itemcode ) {
        $this->db->where('itemcode',$itemcode);
        $query = $this->db->get('item');
        
        return $query->num_rows() ? TRUE : FALSE;
    }
    
    
    public function get_data( $itemcode ) {
        $this->db->where('itemcode',$itemcode);
        $query = $this->db->get('item');
        return $query->row_array();
    }
    
    public function test_itemedit($orig, $new){
        $this->db->where('itemcode !=',  strtoupper($orig));
        $query = $this->db->get('item');
        
        foreach( $query->result_array() as $value ){
            if( $new === $value['itemcode'])
                return TRUE;
        }
        
        return FALSE;
    }
    
    public function get_img($itemcode) {
        $this->db->select('image');
        $this->db->where('itemcode',$itemcode);
        $query = $this->db->get('item');
        if( $query->num_rows() ){
            $QUER = $query->row_array();
            return $QUER['image'];
        }
        return FALSE;
    }
    
    public function get_price($itemcode) {
        $this->db->select('price');
        $this->db->where('itemcode',$itemcode);
        $query = $this->db->get('item');
        if( $query->num_rows() ){
            $QUER = $query->row_array();
            return $QUER['price'];
        }
        return FALSE;
    }
    
    public function count_all() {
        $query = $this->db->get('item');
        return $query->num_rows();
    }
    
    public function delete_item($itemcode, $tables ){
        $this->db->where('itemcode',$itemcode);
        $this->db->delete($tables);
        return $this->db->affected_rows() ? TRUE : FALSE;
    }
    
}