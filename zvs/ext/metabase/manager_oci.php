<?php
if(!defined("METABASE_MANAGER_OCI_INCLUDED"))
{
	define("METABASE_MANAGER_OCI_INCLUDED",1);

/*
 * manager_oci.php
 *
 * @(#) $Header: /home/xubuntu/berlios_backup/github/tmp-cvs/zvs/Repository/zvs/ext/metabase/manager_oci.php,v 1.1 2004/11/03 14:24:49 ehret Exp $
 *
 */

class metabase_manager_oci_class extends metabase_manager_database_class
{
	Function CreateDatabase(&$db,$name)
	{
		if(!IsSet($db->options[$option="DBAUser"])
		|| !IsSet($db->options[$option="DBAPassword"]))
			return($db->SetError("Create database","it was not specified the Oracle $option option"));
		$success=0;
		if($db->Connect($db->options["DBAUser"],$db->options["DBAPassword"],0))
		{
			if($db->DoQuery("CREATE USER ".$db->user." IDENTIFIED BY ".$db->password.(IsSet($db->options["DefaultTablespace"]) ? " DEFAULT TABLESPACE ".$db->options["DefaultTablespace"] : "")))
			{
				if($db->DoQuery("GRANT CREATE SESSION, CREATE TABLE,UNLIMITED TABLESPACE,CREATE SEQUENCE TO ".$db->user))
					$success=1;
				else
				{
					$error=$db->Error();
					if(!$db->DoQuery("DROP USER ".$db->user." CASCADE"))
						$error="could not setup the database user ($error) and then could drop its records (".$db->Error().")";
					return($db->SetError("Create database",$error));
				}
			}
		}
		return($success);
	}

	Function DropDatabase(&$db,$name)
	{
		if(!IsSet($db->options[$option="DBAUser"])
		|| !IsSet($db->options[$option="DBAPassword"]))
			return($db->SetError("Drop database","it was not specified the Oracle $option option"));
		return($db->Connect($db->options["DBAUser"],$db->options["DBAPassword"],0)
		&& $db->DoQuery("DROP USER ".$db->user." CASCADE"));
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
					case "RemovedFields":
					case "ChangedFields":
					case "name":
						break;
					case "RenamedFields":
					default:
						return($db->SetError("Alter table","change type \"".Key($changes)."\" not yet supported"));
				}
			}
			return(1);
		}
		else
		{
			if(IsSet($changes["RemovedFields"]))
			{
				$query=" DROP (";
				$fields=$changes["RemovedFields"];
				for($field=0,Reset($fields);$field<count($fields);Next($fields),$field++)
				{
					if($field>0)
						$query.=", ";
					$query.=Key($fields);
				}
				$query.=")";
				if(!$db->Query("ALTER TABLE $name $query"))
					return(0);
				$query="";
			}
			$query=(IsSet($changes["name"]) ? "RENAME TO ".$changes["name"] : "");
			if(IsSet($changes["AddedFields"]))
			{
				$fields=$changes["AddedFields"];
				for($field=0,Reset($fields);$field<count($fields);Next($fields),$field++)
					$query.=" ADD (".$fields[Key($fields)]["Declaration"].")";
			}
			if(IsSet($changes["ChangedFields"]))
			{
				$fields=$changes["ChangedFields"];
				for($field=0,Reset($fields);$field<count($fields);Next($fields),$field++)
				{
					$current_name=Key($fields);
					if(IsSet($renamed_fields[$current_name]))
					{
						$field_name=$renamed_fields[$current_name];
						UnSet($renamed_fields[$current_name]);
					}
					else
						$field_name=$current_name;
					$change="";
					$change_type=$change_default=0;
					if(IsSet($fields[$current_name]["type"]))
						$change_type=$change_default=1;
					if(IsSet($fields[$current_name]["length"]))
						$change_type=1;
					if(IsSet($fields[$current_name]["ChangedDefault"]))
						$change_default=1;
					if($change_type)
						$change.=" ".$db->GetFieldTypeDeclaration($fields[$current_name]["Definition"]);
					if($change_default)
						$change.=" DEFAULT ".(IsSet($fields[$current_name]["Definition"]["default"]) ? $db->GetFieldValue($fields[$current_name]["Definition"]["type"],$fields[$current_name]["Definition"]["default"]) : "NULL");
					if(IsSet($fields[$current_name]["ChangedNotNull"]))
						$change.=(IsSet($fields[$current_name]["notnull"]) ? " NOT" : "")." NULL";
					if(strcmp($change,""))
						$query.=" MODIFY ($field_name$change)";
				}
			}
			return($query=="" || $db->Query("ALTER TABLE $name $query"));
		}
	}

	Function CreateSequence(&$db,$name,$start)
	{
		return($db->Query("CREATE SEQUENCE $name START WITH $start INCREMENT BY 1".($start<1 ? " MINVALUE $start" : "")));
	}

	Function DropSequence(&$db,$name)
	{
		return($db->Query("DROP SEQUENCE $name"));
	}
};
}
?>