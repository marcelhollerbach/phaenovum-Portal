/**
 * Unser haupt Javascript file mit allen Functionen für das Programm
 * 
 */

/**
 * ====================================================================================
 * 										EDITOR 
 * ====================================================================================
 */
/**
 * Funktion zum leeren des Inhalts
 */
function leeren(element){
	document.getElementById(element).value='';
}

/**
 * Funktion um den Editor gut nutzen zu können
 */
function insert(feld,aTag, eTag) {
  var input = document.forms['editor'].elements[feld];
  input.focus();
  /* für Internet Explorer von Microdoof*/
  if(typeof document.selection != 'undefined') {
    /* Einfügen des Formatierungscodes */
    var range = document.selection.createRange();
    var insText = range.text;
    range.text = aTag + insText + eTag;
    /* Anpassen der Cursorposition */
    range = document.selection.createRange();
    if (insText.length == 0) {
      range.move('character', -eTag.length);
    } else {
      range.moveStart('character', aTag.length + insText.length + eTag.length);      
    }
    range.select();
  }
  /* für moderne Browser like Firefox oder Chrome  */
  else if(typeof input.selectionStart != 'undefined')
  {
    /* Code einfügen */
    var start = input.selectionStart;
    var end = input.selectionEnd;
    var insText = input.value.substring(start, end);
    input.value = input.value.substr(0, start) + aTag + insText + eTag + input.value.substr(end);
    /* Cursorpositon dazwischen setzen */
    var pos;
    if (insText.length == 0) {
      pos = start + aTag.length;
    } else {
      pos = start + aTag.length + insText.length + eTag.length;
    }
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }
  /* für den ganzen rest :( */
  else
  {
    /* Abfrage der Einfügeposition */
    var pos;
    var re = new RegExp('^[0-9]{0,3}$');
    while(!re.test(pos)) {
      pos = prompt("Einfügen an Position (0.." + input.value.length + "):", "0");
    }
    if(pos > input.value.length) {
      pos = input.value.length;
    }
    /* Einfügen des Formatierungscodes */
    var insText = prompt("Bitte Text der formatiert werden soll eingeben:");
    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
  }
}
