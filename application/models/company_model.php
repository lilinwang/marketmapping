<?php
class company_model extends CI_Model{
   function __construct(){
        parent::__construct();
    }
	function insert_new_music($name,$story,$musician_id){    //上传成功后更新数据库

	     $sql='INSERT INTO music(name,musician_id,story,download_cnt,share_cnt,collect_cnt,view_cnt,randable) values (?,?,?,?,?,?,?,?)';
	     $this->db->query($sql,array($name,$musician_id,$story,0,0,0,0,0));
	     $music_id_query=$this->getid($musician_id,$name);
	     $music_id=$music_id_query['music_id'];
	     $sql='update music SET dir=? WHERE musician_id=? AND name=?';
	     $dir='upload/music/user_'.$musician_id.'/music_'.$music_id.'.mp3';
		 $image_dir='upload/image/user_'.$musician_id.'/music_'.$music_id.'.jpg';
		 $this->db->query($sql,array($dir,$musician_id,$name));
		 $sql='UPDATE music SET image_dir=? where music_id=?';
		 $this->db->query($sql,array($image_dir,$music_id));
		 return $music_id;

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
