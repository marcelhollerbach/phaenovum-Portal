<?php
/**
 * 
 */
class Component {
	private $_name;
	function __construct($name) {
		$this -> _name = $name;
	}
	public function render(){
		echo "render dummy".$this -> _name;
	}
}

?>