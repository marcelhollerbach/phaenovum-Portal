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
						include './components/'.$name.'/Controller.php';
						$classname = $name.'Controller';
						$inst = new $classname();
						$object = new Component($name,$name,$inst);
						self::addComponent($object);
					}
				}
			}
		}
	}
	//Add a Component
	private static function addComponent($inst){
		self::$components[] = $inst;
	}
	public static function getComponent($name){
		foreach (self::$components as $component){
			if($component -> getName() == $name){
				return $component;
			}
		}
		return NULL;
	}
	public static function getComponents(){
		//print_r(self::$components);
		return self::$components;
	}
}
class Component {
	private $data;
	function __construct($name,$permissions,$inst){
		$this ->data = array();
		$this ->data['name'] = $name;
		$this ->data['permission'] = $permissions;
		$this ->data['inst'] = $inst;
	}
	function getName(){
		return $this ->data['name'];
	}
	function getPermission(){
		return $this ->data['permission'];
	}
	function getInstance(){
		return $this ->data['inst'];
	}
}
?>