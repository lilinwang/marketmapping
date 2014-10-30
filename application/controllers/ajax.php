<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function index()
    {
        exit('Access denied');
    }
	function get_img(){	
			$data=file_get_contents($_POST['url']);
			//$data = eval("(" + data + ")");
			$array=json_decode($data,true);
			
			//$picture = imagecreatefrompng($array['metadata']['image_path_prefix'].$array['data']['relationships']['primary_image']['items'][0]['path']);
			$picture = imagecreatefrompng('F:\wamp\www\marketmapping\like_button2.png');
			echo $array['data']['relationships']['primary_image']['items'][0]['path'];
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

			imagepng($newPicture,'F:\wamp\www\marketmapping\image.png');
			imagedestroy($newPicture);
			imagedestroy($picture);
			//echo $data;
		
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
