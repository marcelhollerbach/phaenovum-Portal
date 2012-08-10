<?php
class ExternalTools {
	static $error;
	public static function createIcon($name){
		
		if(file_exists('../../icon_settings/default.ini')){
			//copy('../icon_settings/default.ini', '../icon_settings/'.$name.'.ini');
			return 1;
		}else{
			return -1;
			self::$error = "File allready exists";
		}
	}
	public static function deleteIcon($name){
		
	}
	public static function editIcon($icon,$name,$in_network,$out_network,$popup){
		
	}
	public static function getError(){
		return self::$error;
	}
}

?>