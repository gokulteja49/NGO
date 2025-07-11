
<?php


$obj = new mysqli("127.0.0.1","root","Aksangwan264@","project");

if($obj->connect_errno != 0)
{
	echo $obj->connect_error;
	exit;
}

?> 
