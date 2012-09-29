<?php 
class FormBuilder {
	static function renderTextField($_name,$_value,$_allInOne = TRUE,$_txt_value = ""){
		if($_allInOne == TRUE){
			echo "<div id=\"field\">";
			echo "<label id=\"label_".$_name."\"> ".$_value." </label>";
			echo "<input onmouseover=\"unvisible('label_".$_name."',this,0)\" onkeydown=\"unvisible('label_".$_name."',this,1)\" onmouseleave=\"unvisible('label_".$_name."',this,-1)\" id=\"pw\"type=\"text\" name=\"$_name\"/> <br>";
			echo "</div>";
		}else{
			echo $_value;
			echo "<div id=\"field\">";
			echo "<input value=\"$_txt_value\" type=\"text\" name=\"$_name\"/> <br>";
			echo "</div>";
		}
	}
	static function renderPasswordfield($_name,$_schirft,$_allInOne = TRUE){
		if($_allInOne == TRUE){
			echo "<div id=\"field\">";
			echo "<label id=\"label_".$_name."\"> ".$_schirft." </label>";
			echo "<input onmouseover=\"unvisible('label_".$_name."',this,0)\" onkeydown=\"unvisible('label_".$_name."',this,1)\" onmouseleave=\"unvisible('label_".$_name."',this,-1)\" id=\"pw\"type=\"password\" name=\"$_name\"/> <br>";
			echo "</div>";
		}else{
			echo $_schirft;
			echo "<div id=\"field\">";
			echo "<input id=\"pw\"type=\"password\" name=\"$_name\"/> <br>";
			echo "</div>";
		}

	}
	static function renderHidden($_value,$_name){
		echo "<input type=\"hidden\" value=\"$_value\" name=\"$_name\"/>";
	}
	static function renderButton($_value,$_name){
		echo "<input type=\"submit\" value=\"$_value\" name=\"$_name\"/>";
	}
}
?>