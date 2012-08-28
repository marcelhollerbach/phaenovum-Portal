<?php
class ComponentController {
	private static $components;
	/**
	 * Load all Components from the ./components directory
	 */
	public static function init(){
		self::$components = array();
		$componentdirs = array();
		if (is_dir('./components/')) {
			$dirs = scandir('./components/');
			foreach ($dirs as $dir) {
				if ($dir != '.' && $dir != '..') {
					if (is_dir('./components/'.$dir)) {
						$name = $dir;
						require './components/'.$name.'/Controller.php';
						$classname = $name.'Controller';
						$inst = new $classname();
						self::addComponent($name,$inst);
					}
				}
			}
		}
	}
	//Add a Component
	private static function addComponent($name, $inst){
		self::$components[$name] = $inst;
	}
	public static function getComponent($name){
		return self::$components[$name];
	}
	public static function getComponents(){
		//print_r(self::$components);
		return self::$components;
	}
}

?>