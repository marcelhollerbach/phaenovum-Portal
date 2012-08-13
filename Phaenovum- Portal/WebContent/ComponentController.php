<?php
class ComponentController {
	private static $components;
	public static function init(){
		self::$components = array();
	}
	public static function addComponent($name, $inst){
		self::$components[$name] = $inst;
		//print_r(self::$components);
	}
	public static function getComponent($name){
		return self::$components[$name];
	}
	public static function getComponents(){
		print_r(self::$components);
		return self::$components;
	}	
}

?>