<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class Name: name of the class
 * Description: use of the class
 * Content: content of the class
 */
class Users extends CI_Model{

	function __construct(){
		parent::__construct();
	}
    
    public function test_user($username,$password){
        $this->db->where('username',$username);
        $this->db->where('password',$password);
        $query = $this->db->get('users');
        return $query->num_rows() ? TRUE : FALSE;
    }
    
    public function insert($username, $password){
        $insert = array('username' => $username, 'password' => $password );
        $this->db->insert('users',$insert);
        return $this->db->affected_rows() ? TRUE : FALSE;
    }
    
    public function test_username($username){
        $this->db->where('username',$username);
        $query = $this->db->get('users');
        return $query->num_rows() ? TRUE : FALSE;
    }
    
}