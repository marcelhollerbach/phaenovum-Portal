<?php
/**
 * Test 
 */
 require_once("Controller.php");
 require_once("includes/News.php");
 require_once("includes/Database.php");
 
 $heute = date("d.m.y");
 
 $Obj = new newsfeedController();
 $Obj->render();
 //Start: 0:33 Uhr
 //$O = new News("Marcel Neidinger",$heute,"Däs währe dunnäääüü \n mal ein zeilenumbruch","Testheadline of the week");
 
 
?>