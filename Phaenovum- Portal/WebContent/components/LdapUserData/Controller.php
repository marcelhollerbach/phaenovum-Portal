<?php 
class LdapUserDataController {
	private $submitchanges;
	private $data;
	function __construct(){
		$inst = Authorization::getInst();
		$this -> data = array();
		$this -> data['givenname'] = $inst ->getLdapField('givenname');
		$this -> data['sn'] = $inst ->getLdapField('sn');
		$this -> data['description'] = $inst -> getLdapField('description');
		$this -> data['mail'] = $inst ->getLdapField('mail');
		$this -> data['street'] = $inst ->getLdapField('street');
		$this -> data['ort'] = $inst ->getLdapField('l');
		$this -> data['plz'] = $inst ->getLdapField('postalcode');
	}
	function render() {
		if(Authorization::getUserName() != 'admin'){

			$givenname = $this -> data['givenname'];
			$sn = $this -> data['sn'];
			if($this -> submitchanges){
				echo "<form action=\"index.php\" method=\"POST\">";
				echo "Neue Daten sind: <br/>";
				if(isset($this -> data['new_description'])){
					FormBuilder::renderHidden($this ->data['new_description'], 'new_description');
					echo "Neue Discription : ".$this->data['new_description'];
				}
				if(isset($this -> data['new_street'])){
					FormBuilder::renderHidden($this ->data['new_street'], 'new_street');
					echo "<br/>Neue Straße : ".$this->data['new_street'];
				}
				if(isset($this -> data['new_plz'])){
					FormBuilder::renderHidden($this ->data['new_plz'], 'new_plz');
					echo "<br/>Neue plz : ".$this->data['new_plz'];
				}
				if(isset($this -> data['new_ort'])){
					FormBuilder::renderHidden($this ->data['new_ort'], 'new_ort');
					echo "<br/>Neue Ort : ".$this->data['new_ort'];
				}
				if(isset($this -> data['new_mail'])){
					FormBuilder::renderHidden($this ->data['new_mail'], 'new_mail');
					echo "<br/>Neue Mail : ".$this->data['new_mail'];
				}
				if(isset($this -> data['new_pw'])){
					FormBuilder::renderHidden($this ->data['new_pw'], 'new_pw');
					echo "<br/>Neue Passwort : ".$this->data['new_pw']."";
				}
				echo "</br>";
				FormBuilder::renderHidden("LdapUserData", "com");
				FormBuilder::renderHidden("editUsrData", "task");
				FormBuilder::renderButton("Übernehmen", "submit");
				echo "</form>";
			}else{
				echo "<form action=index.php method=POST>";
				FormBuilder::renderHidden("LdapUserData", "com");
				FormBuilder::renderHidden("submitchanges", "task");
				echo "Vorname : ".$givenname;
				//FormBuilder::renderTextField("usr_name", "Vorname: ",FALSE,$givenname);
				echo "<br/>Nachname : ".$sn."<br/>";
				//FormBuilder::renderTextField("usr_nachname", "Nachname: ",FALSE,$sn);
				FormBuilder::renderTextField("usr_description", "Beschreibung:",FALSE,$this -> data['description']);
				echo "<br/>Adresse : ";
				echo "<br/>Folgende Daten sind Freiwillig Anzugeben !</br>";
				FormBuilder::renderTextField("usr_street", "Straße :",FALSE,$this -> data['street']);
				FormBuilder::renderTextField("usr_plz", "Postleitzahl :",FALSE,$this -> data['plz']);
				FormBuilder::renderTextField("usr_ort", "Ort :",FALSE,$this -> data['ort']);
				echo "Kontaktdaten : </br>";
				FormBuilder::renderTextField("usr_email", "E- mail :",FALSE,$this -> data['mail']);
				echo "<br/>Passwort :";
				echo "<br/>Nur eingeben wenn man ein neues Passwort setzen will ! <br/>";
				FormBuilder::renderPasswordfield("usr_pw", "Neues Passwort: ",FALSE);
				FormBuilder::renderPasswordfield("usr_pw2", "Wiederholung : ",FALSE);
				FormBuilder::renderButton("Übernehmen", "submit_edit");
				echo "</form>";
			}
		}else{
			echo "Sie sind admin, sie können keine Benutzerdaten ändern.";
		}
	}
	function task(){
		if(isset($_POST['task'])){
			switch($_POST['task']){
				case "submitchanges":
					$this -> submitchanges = TRUE;
					if($_POST['usr_description'] !=$this -> data['description']){
						//straße ändert sich
						$this -> data['new_description'] = $_POST['usr_description'];
					}
					if($_POST['usr_street'] !=$this -> data['street']){
						//straße ändert sich
						$this -> data['new_street'] = $_POST['usr_street'];
					}
					if($_POST['usr_plz'] !=$this -> data['plz']){
						//straße ändert sich
						$this -> data['new_plz'] = $_POST['usr_plz'];
					}
					if($_POST['usr_ort'] !=$this -> data['ort']){
						//straße ändert sich
						$this -> data['new_ort'] = $_POST['usr_ort'];
					}
					if($_POST['usr_email'] != $this -> data['mail']){
						//mail änderte sich
						$this -> data['new_email'] = $_POST['usr_email'];
					}
					if($_POST['usr_pw'] != ''&&$_POST['usr_pw'] == $_POST['usr_pw2'] && $_POST['usr_pw'] != $_SESSION['pw']){
						//passwort ändert sich
						$this -> data['new_pw'] = $_POST['usr_pw'];
					}
					break;
				case "editUsrData":
					$inst = Authorization::getInst();
					if(isset($_POST['new_description'])){
						$inst ->editLDAPField('description', $_POST['new_description']);
					}
					if(isset($_POST['new_street'])){
						$inst ->editLDAPField('street', $_POST['new_street']);
					}
					if(isset($_POST['new_plz'])){
						$inst ->editLDAPField('postalcode', $_POST['new_plz']);
					}
					if(isset($_POST['new_ort'])){
						$inst ->editLDAPField('l', $_POST['new_ort']);
					}
					if(isset($_POST['new_mail'])){
						$inst ->editLDAPField('mail', $_POST['new_mail']);
					}
					if(isset($_POST['new_pw'])){
						$inst ->editLDAPField('userpassword', "{MD5}".base64_encode(pack("H*",md5($_POST['new_pw']))));
					}
					break;
			}
		}
	}
}
?>