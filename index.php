<?php
	include_once("src/init.php");
	$sqweb->sqwebScript();
	$sqweb->sqwebButton('grey');
	if ($sqweb->sqwebCheckCredits())
	{
		echo "content";
	}
	else
	{
		echo "ads";
	}