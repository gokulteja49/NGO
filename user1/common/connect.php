
<?php


$obj = new mysqli("127.0.0.1","root","","project");

if($obj->connect_errno != 0)
{
	echo $obj->connect_error;
	exit;
}

?> 
