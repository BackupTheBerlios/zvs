#!/usr/local/bin/php -q
<?php
/*
 * get_database.php
 *
 * @(#) $Header: /home/xubuntu/berlios_backup/github/tmp-cvs/zvs/Repository/bar/ext/metabase/get_database.php,v 1.1 2004/11/03 15:18:32 ehret Exp $
 *
 */

	require("metabase_parser.php");
	require("metabase_manager.php");
	require("metabase_database.php");
	require("metabase_interface.php");
	require("xml_parser.php");

Function Dump($output)
{
	echo $output;
}


	if($argc<2)
	{
		echo "Usage:   ".$argv[0]." Connection-string\n";
		echo "Example: ".$argv[0]." mysql://root@localhost/driver_test?Options/Port=/var/lib/mysql/mysql.sock\n";
		exit;
	}
	$arguments=array(
	  "Connection"=>$argv[1]
	);
	$manager=new metabase_manager_class;
	if(strlen($error=$manager->GetDefinitionFromDatabase($arguments))==0)
	{
		$error=$manager->DumpDatabase(array(
			"Output"=>"Dump",
			"EndOfLine"=>"\n")
		);
	}
	else
		echo "Error: $error\n";
	if($manager->database)
	{
/*
		if(count($manager->warnings)>0)
			echo "WARNING:\n",implode($manager->warnings,"!\n"),"\n";
		echo MetabaseDebugOutput($manager->database);
*/
		$manager->CloseSetup();
	}
?>