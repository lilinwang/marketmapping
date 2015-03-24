<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function index()
    {
        exit('Access denied');
    }
	function auto_complete(){
		$keyword = '%'.$_POST['keyword'].'%';
		$this->load->model('axis_model');				
		
		$list = $this->axis_model->get_matched_axis($keyword);
		if (count($list)>0){					
		foreach ($list as $rs) {
			// put in bold the written text
			$country_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['axis_name']);
			// add new option
			echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['axis_name']).'\',\''.$_POST['input'].'\')">'.$country_name.'</li>';
		}
		}
	}
	function save_axis(){
		$data=array($_POST['axis_top'],$_POST['axis_bottom'],$_POST['axis_left'],$_POST['axis_right']);
		$this->load->model('axis_model');				
		
		$result = $this->axis_model->save($data);
		if ($result==1){							
			echo 'success';
		}else{
			echo 'fail';
		}
	}
	function upload(){	
		//$data=file_get_contents($_POST['url']);$_FILES['f_file']['name']
		if ( 0 < $_FILES['file']['error'] ) {
			echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		else {
			$dest='uploads/'.$_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'],$dest);							
		}
								
		$name=$_FILES['file']['name'];
		$source='http://localhost/marketmapping/timthumb?src=http://localhost/marketmapping/'.$dest;
		$source=$source."&h=100&w=100&zc=2";
		$newdest='./image/'.$name;
							
		copy($source, $newdest); 
		echo $newdest;
	}
	function get_img(){	
			//get the image from Crunchbase
			$data=@file_get_contents("http://api.crunchbase.com/v/2/organization/".$_POST['company']."?user_key=7ac52c190afddbbdc5a9227779b7064c");
			$array=json_decode($data,true);
			if (isset($array['data']['error'])){				
				$response[0]=0;
				//echo json_encode($response);
				//return;
			}else{				
				$name=$array['data']['properties']['name']."_crunchbase";
				if (isset($array['data']['relationships']['primary_image']['items'][0]['path']) && isset($array['metadata']['image_path_prefix'])){
					$originalimg=$array['metadata']['image_path_prefix'].$array['data']['relationships']['primary_image']['items'][0]['path'];
						
					$source='http://localhost/marketmapping/timthumb?src='.$array['metadata']['image_path_prefix'].$array['data']['relationships']['primary_image']['items'][0]['path'];
					$source=$source."&h=100&w=100&zc=2";
					
					$metasource=getimagesize($source);
					switch ($metasource[2]){
						case 2:
							$dest='./image/'.$name.'.jpg';
							break;
						case 3:
							$dest='./image/'.$name.'.png';
							break;
					}									
					copy($source, $dest); 
					$response[0]=$dest;
				}else {
					$response[0]=0;
				}
			}
			
			//get the image from Anglelist	
			$site="http://api.angel.co/1/search/slugs?query=".$_POST['company'];
			$data=@file_get_contents($site);
			//echo $data;
			if ($data===FALSE){										
				$data=@file_get_contents("http://api.angel.co/1/search?query=".$_POST['company']."&type=Startup");
				
				if ($data===FALSE || $data=="[]"){
					$response[1]=0;
					echo json_encode($response);
					return;
				}
				else{													
					$array=json_decode($data,true);						
					if (isset($array[0]['pic'])){
						$originalimg=substr($array[0]['pic'],5);										
					}else{
						$response[1]=0;
						echo json_encode($response);
						return;
					}
				}
			}
			else{
				
				$array=json_decode($data,true);						
				$id=$array['id'];			
				$data=@file_get_contents("http://api.angel.co/1/startups/".$id);
				
				$array=json_decode($data,true);						
				if (isset($array['logo_url'])){
					$originalimg=substr($array['logo_url'],5);			
				}else{
					$response[1]=0;
					echo json_encode($response);
					return;
				}
			}								
			
			//echo $originalimg;			
			$name=$_POST['company']."_anglelist";
			$source='http://localhost/marketmapping/timthumb?src=http'.$originalimg;
			//echo $source;
			$source=$source."&h=100&w=100&zc=2";						
			
			$metasource=getimagesize($source);
			switch ($metasource[2]){
				case 2:
					$dest='./image/'.$name.'.jpg';
					break;
				case 3:
					$dest='./image/'.$name.'.png';
					break;
			}									
			copy($source, $dest); 
			$response[1]=$dest;
			echo json_encode($response);	
						
			/*$meta=getimagesize($dest);
			switch ($meta[2]){
				case 2:
					$picture = imagecreatefromjpeg($dest);
					break;
				case 3:
					$picture = imagecreatefrompng($dest);
					break;
			}
			
			$img_w = imagesx($picture);
			$img_h = imagesy($picture);

			$newPicture = imagecreatetruecolor( $img_w, $img_h );
			imagesavealpha( $newPicture, true );
			$rgb = imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 );
			imagefill( $newPicture, 0, 0, $rgb );

			$color = imagecolorat( $picture, $img_w-1, 1);

			for( $x = 0; $x < $img_w; $x++ ) {
				for( $y = 0; $y < $img_h; $y++ ) {
					$c = imagecolorat( $picture, $x, $y );
					if($color!=$c){         
						imagesetpixel( $newPicture, $x, $y,    $c);             
					}           
				}
			}

			imagepng($newPicture,$dest);
			imagedestroy($newPicture);
			imagedestroy($picture);*/					
	}
    function get_focus()
	{
		$this->load->model('company_model');
		$data['company_id']=$this->company_model->get_id_by_name($_POST['company_name']);
		$list= $this->company_model->get_focus_by_id($data['company_id']);
		
		$data['focus_list']=explode('|',substr($list,1,strlen($list)-2));
		echo json_encode($data);
	}
	
	function get_metrics()
	{
		$this->load->model('company_model');
		$data['metrics']=null;//$this->company_model->get_metrics($_POST['industry']);		
		echo json_encode($data);
	}	
}
