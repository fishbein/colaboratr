<?php
	class myClass{
		function regularFunction($variable1,$variable2){
			echo $variable1.'<br />'.$variable2;
		}
		
		function __construct(){
			echo 'This is the default function';
		}
		
		function __destruct(){
			echo 'Destruction successful.';
		}
	}
	
	$myclass = new myClass;
	$myclass->regularFunction('value1', 'value2');
?>

