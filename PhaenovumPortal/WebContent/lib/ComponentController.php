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
						$showname = $dir;
						$permission = $name;
						if(file_exists('./components/'.$dir.'/detail.ini')){
							$details = parse_ini_file('./components/'.$dir.'/detail.ini');
							$showname = $details['name'];
							$permission = $details['permission'];
						}else{
							//echo "missing";
						}
						include './components/'.$name.'/Controller.php';
						$classname = $name.'Controller';
						$inst = new $classname();
						$object = new Component($showname,$name,$permission,$inst);
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
			//echo $component -> getName();
			//echo $name;
			//echo "===";
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
	function __construct($showname,$name,$permissions,$inst){
		$this ->data = array();
		$this ->data['showname'] = $showname;
		$this ->data['pPermission'] = $name;
		$this ->data['permission'] = $permissions;
		$this ->data['inst'] = $inst;
	}
	function getName(){
		return $this ->data['pPermission'];
	}
	function getShowName(){
		return $this ->data['showname'];		
	}
	function getPermission(){
		return $this ->data['permission'];
	}
	function getPrimaryPermission(){
		return $this ->data['pPermission'];
	}
	function getInstance(){
		return $this ->data['inst'];
	}
}
?>