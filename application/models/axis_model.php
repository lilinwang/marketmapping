<?php
class axis_model extends CI_Model{
   function __construct(){
        parent::__construct();
    }
	function get_matched_axis($keyword){    

	     $query = $this->db->query(
			'SELECT * FROM axis WHERE axis_name LIKE ? ORDER BY axis_count ASC LIMIT 10',
			array($keyword)
		 );
		if ($query->num_rows()>0){
			return $query->result_array();
		} else{
			return;
		}				
	} 	
    function save($data){    
		foreach ($data as $value) {
			$query = $this->db->query(
				'SELECT * FROM `axis` WHERE `axis_name`=?',
				array($value)
			);
			if ($query->num_rows()>0){
				$query = $this->db->query(
					'UPDATE `axis` SET `axis_count`=`axis_count`+1 WHERE `axis_name`=?',
					array($value)
				);
			} else{
				$query = $this->db->query(
					'INSERT INTO `axis`(`axis_name`) VALUES (?)',
					array($value)
				);
			}
		}	    
	} 	
}
?>
