<?php
if(!defined("METABASE_MANAGER_PGSQL_INCLUDED"))
{
	define("METABASE_MANAGER_PGSQL_INCLUDED",1);

/*
 * manager_pgsql.php
 *
 * @(#) $Header: /home/xubuntu/berlios_backup/github/tmp-cvs/zvs/Repository/zvs/ext/metabase/manager_pgsql.php,v 1.1 2004/11/03 14:24:49 ehret Exp $
 *
 */

class metabase_manager_pgsql_class extends metabase_manager_database_class
{
	Function StandaloneQuery(&$db,$query)
	{
		if(($connection=$db->DoConnect("template1",0))==0)
			return(0);
		if(!($success=@pg_Exec($connection,"$query")))
			$db->SetError("Standalone query",pg_ErrorMessage($connection));
		pg_Close($connection);
		return($success);
	}

	Function CreateDatabase(&$db,$name)
	{
		return($this->StandaloneQuery($db,"CREATE DATABASE $name"));
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
						return($db->SetError("Alter table","database server does not support dropping table columns"));
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
			if(IsSet($changes[$change="name"])
			|| IsSet($changes[$change="RenamedFields"])
			|| IsSet($changes[$change="ChangedFields"]))
				return($db->SetError("Alter table","change type \"$change\" not yet supported"));
			$query="";
			if(IsSet($changes["AddedFields"]))
			{
				$fields=$changes["AddedFields"];
				for($field=0,Reset($fields);$field<count($fields);Next($fields),$field++)
				{
					if(!$db->Query("ALTER TABLE $name ADD ".$fields[Key($fields)]["Declaration"]))
						return(0);
				}
			}
			if(IsSet($changes["RemovedFields"]))
			{
				$fields=$changes["RemovedFields"];
				for($field=0,Reset($fields);$field<count($fields);Next($fields),$field++)
				{
					if(!$db->Query("ALTER TABLE $name DROP ".Key($fields)))
						return(0);
				}
			}
			return(1);
		}
	}

	Function CreateSequence(&$db,$name,$start)
	{
		return($db->Query("CREATE SEQUENCE $name INCREMENT 1".($start<1 ? " MINVALUE $start" : "")." START $start"));
	}

	Function DropSequence(&$db,$name)
	{
		return($db->Query("DROP SEQUENCE $name"));
	}

	Function GetSequenceCurrentValue(&$db,$name,&$value)
	{
		if(!($result=$db->Query("SELECT last_value FROM $name")))
			return(0);
		if($db->NumberOfRows($result)==0)
		{
			$db->FreeResult($result);
			return($db->SetError("Get sequence current value","could not find value in sequence table"));
		}
		$value=intval($db->FetchResult($result,0,0));
		$db->FreeResult($result);
		return(1);
	}

};
}
?>