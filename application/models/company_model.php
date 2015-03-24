<?php
class company_model extends CI_Model{
	function __construct(){
        parent::__construct();
    }
 
	function get_id_by_name($name){
		$name=trim($name);
		$query = $this->db->query(
			'SELECT id FROM company WHERE name LIKE ? LIMIT 1', 
			array($name)
		);
		if ($query->num_rows()>0){
			return $query->row()->id; 
		} else{
			return;
		}
	}
	
	function get_focus_by_id($id){		
		$query = $this->db->query(
			'SELECT category_list FROM company WHERE id LIKE ? LIMIT 1', 
			array($id)
		);
		if ($query->num_rows()>0){
			return $query->row()->category_list; 
		} else{
			return;
		}
	}
	
	function get_metrics($industry){		
		$query = $this->db->query(
			'SELECT metric FROM industry_metric WHERE industry LIKE ? ', 
			array($industry)
		);
		if ($query->num_rows()>0){
			return $query->result_array(); 
		} else{
			return;
		}
	}
	function get_permalink_by_id($id){		
		$query = $this->db->query(
			'SELECT permalink FROM company WHERE id LIKE ? LIMIT 1', 
			array($id)
		);
		if ($query->num_rows()>0){
			return $query->row()->permalink; 
		} else{
			return;
		}
	}    
    
}
?>
