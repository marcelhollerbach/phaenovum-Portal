<?php
/**
 * 
 */
class Component {
	protected $_name;
	function __construct($name) {
		$this -> _name = $name;
	}
	protected function render(){
		echo "render dummy".$_name;
	}
}

?>