<?php
if(!defined("METABASE_MANAGER_MSSQL_INCLUDED"))
{
	define("METABASE_MANAGER_MSSQL_INCLUDED",1);

/*
 * manager_mssql.php
 *
 * @(#) $Header: /home/xubuntu/berlios_backup/github/tmp-cvs/zvs/Repository/zvs/ext/metabase/manager_mssql.php,v 1.1 2004/11/03 14:24:49 ehret Exp $
 *
 */

class metabase_manager_mssql_class extends metabase_manager_database_class
{
	Function StandaloneQuery(&$db,$query)
	{
		if(!function_exists("mssql_connect"))
			return($db->SetError("Standalone query","Microsoft SQL server support is not available in this PHP configuration"));
		if(($connection=mssql_connect($db->host,$db->user,$db->password))==0)
			return($db->SetMSSQLError("Standalone query","Could not connect to the Microsoft SQL server"));
		if(!($success=@mssql_query($query,$connection)))
			$db->SetMSSQLError("Standalone query","Could not query a Microsoft SQL server");
		mssql_close($connection);
		return($success);
	}

	Function CreateDatabase(&$db,$name)
	{
		return($this->StandaloneQuery($db,"CREATE DATABASE $name ON ".(IsSet($db->options["DatabaseDevice"]) ? $db->options["DatabaseDevice"] : "DEFAULT").(IsSet($db->options["DatabaseSize"]) ? "=".$db->options["DatabaseSize"] : "")));
	}

	Function DropDatabase(&$db,$name)
	{
		return($this->StandaloneQuery($db,"DROP DATABASE $name"));
	}

	Function AlterTable(&$db,$name,&$changes,$check)
	{
		if($check)
		{
			for($change=0,Reset($changes);$change<count($changes);Next($changes),$change++)
			{
				switch(Key($changes))
				{
					case "AddedFields":
						break;
					case "RemovedFields":
					case "name":
					case "RenamedFields":
					case "ChangedFields":
					default:
						return($db->SetError("Alter table","change type \"".Key($changes)."\" not yet supported"));
				}
			}
			return(1);
		}
		else
		{
			if(IsSet($changes[$change="RemovedFields"])
			|| IsSet($changes[$change="name"])
			|| IsSet($changes[$change="RenamedFields"])
			|| IsSet($changes[$change="ChangedFields"]))
				return($db->SetError("Alter table","change type \"$change\" is not supported by the server"));
			$query="";
			if(IsSet($changes["AddedFields"]))
			{
				if(strcmp($query,""))
					$query.=", ";
				$query.="ADD ";
				$fields=$changes["AddedFields"];
				for($field=0,Reset($fields);$field<count($fields);Next($fields),$field++)
				{
					if(strcmp($query,""))
						$query.=", ";
					$query.=$fields[Key($fields)]["Declaration"];
				}
			}
			return(strcmp($query,"") ? $db->Query("ALTER TABLE $name $query") : 1);
		}
	}

	Function CreateSequence(&$db,$name,$start)
	{
		return($db->Query("CREATE TABLE _sequence_$name (sequence INT NOT NULL IDENTITY($start,1) PRIMARY KEY CLUSTERED)"));
	}

	Function DropSequence(&$db,$name)
	{
		return($db->Query("DROP TABLE _sequence_$name"));
	}
};
}
?>