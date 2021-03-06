<%strip%>
<%include file=header.tpl%>
	<h1><span><%if $tpl_gast.lastname neq ""%><%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%>&nbsp;</span></h1>
<%if not $tpl_editmode%>
<div id="show" name="show">	
	<div class="toolbar"><%if $tpl_gast.guestid neq ""%><a href="<%$wwwroot%>exportvcard.php/guestid.<%$tpl_gast.guestid%>/lastname.<%$tpl_gast.lastname%>/firstname.<%$tpl_gast.firstname%>" class="toolbar">##VCARD_EXPORT##</a><%/if%> <a href="javascript:switchLayer2('edit');" class="toolbar">##EDIT##</a></div>
	
			<table class="mainaddress">
			 <colgroup>
				<col width="18%">
				<col width="18%">
				<col width="18%">
				<col width="18%">
				<col width="18%">
				<col width="10%">
			 </colgroup>			
             <tr>
               <td><strong>##SALUTATION##</strong></td>
               <td><%$tpl_gast.salutation_title%></td>
               <td align="right"><strong>##TITLE##</strong></td>
               <td><%$tpl_gast.academic_title%></td>
               <td align="right"><strong>##GENDER##</strong></td>
               <td><%if $tpl_gast.gender eq "M"%>##GENDER_M##<%elseif $tpl_gast.gender eq "F"%>##GENDER_F##<%/if%></td>
             </tr>
             <tr>
               <td><strong>##FIRSTNAME##</strong></td>
               <td><%$tpl_gast.firstname%></td>
               <td align="right"><strong>##LASTNAME##</strong></td>
               <td><%$tpl_gast.lastname%></td>
               <td align="right"><strong>##LANGUAGE##</strong></td>
               <td><%if $tpl_gast.language_id eq "2"%>##LANGUAGE_D##<%elseif $tpl_gast.language_id eq "3"%>##LANGUAGE_E##<%elseif $tpl_gast.language_id eq "4"%>##LANGUAGE_I##<%/if%></td>
             </tr>
             <tr>
               <td><strong>##JOB##</strong></td>
               <td><%$tpl_gast.job%></td>
               <td align="right"><strong>##COMPANY##</strong></td>
               <td><%$tpl_gast.company%></td>
               <td align="right"><strong>##FORMAL_GREETING##</strong></td>
               <td><%if $tpl_gast.formal_greeting eq "N"%>##FORMAL_GREETING_NO##<%elseif $tpl_gast.formal_greeting eq "Y"%>##FORMAL_GREETING_YES##<%/if%></td>
             </tr>
             <tr>
               <td><strong>##DATE_OF_BIRTH##</strong></td>
               <td><%if $tpl_gast.date_of_birth neq "00.00.0000"%><%$tpl_gast.date_of_birth%>&nbsp;<input type="checkbox" name="frm_reminder" id="reminder" value="Y" <%if $tpl_gast.reminder eq "Y"%>checked="checked"<%/if%> disabled="disabled"/> ##REMINDER##<%/if%></td>
			   <td align="right"><strong>##PLACE_OF_BIRTH##</strong></td>
				<td><%$tpl_gast.birthplace%></td>
				<td colspan="2"></td>
				</tr>
			  <tr>
				<td><strong>##NATIONALITY##</strong></td>
				<td><%$tpl_gast.nationality_name%></td>
				<td colspan="4"></td>
			  </tr>		
			  <tr>
				<td><strong>##DOCUMENT_OF_IDENTITY##</strong></td>
				<td><%if $tpl_gast.identification eq "P"%>##IDENTITY_CARD##<%elseif $tpl_gast.identification eq "R"%>##PASSPORT##<%elseif $tpl_gast.identification eq "F"%>##DRIVING_LICENSE##<%/if%></td>
				<td align="right"><strong>##IDENTITY_CARD_NUMBER##</strong></td>
			    <td><%$tpl_gast.passport%></td>
				<td colspan="2">&nbsp;</td>
			 </tr>			  		
				<tr>
					 	<td><strong>##AGENCY_OF_EXHIBITION##</strong></td>
						<td><%$tpl_gast.agency%></td>
						<td align="right"><strong>##DATE_OF_EXHIBITION##</strong></td>
						<td><%$tpl_gast.issue_date%></td>
            <td colspan="2"><input type="checkbox" name="frm_status" id="frm_status" value="Y" <%if $tpl_gast.status eq "Y"%>checked<%/if%> disabled="disabled"/> <strong>##REGULAR_GUEST##</strong></td>
        </tr>
        <tr>
				<td colspan="6" class="annotation">
				<%if $tpl_gast.guestid neq ""%>
	                ##MADE_BY## <%$tpl_gast.inserted_user%>&nbsp;##AT##&nbsp;<%$tpl_gast.inserteddate%>&nbsp;
	               <%if $tpl_gast.updated_user neq "" and $tpl_gast.updated_user neq " "%> - 
	               	##LAST_ACTUALISATION_BY## <%$tpl_gast.updated_user%>&nbsp;##AT##&nbsp;<%$tpl_gast.updated_date%>
	               <%else%>
						&nbsp;
					<%/if%>
				<%else%>
				&nbsp;
				<%/if%>
				</td>
       </tr>
      </table>
<br/>

<div id="add_private" name="add_private">
   &nbsp;<div class="toolbar"><a href="javascript:switchLayer('add_private');" class="dotted">##PRIVATE##</a> | <a href="javascript:switchLayer('add_business');" class="dotted">##BUSINESS##</a> | <a href="javascript:switchLayer('add_other');" class="dotted">##OTHER##</a></div>
      <h3>##PRIVAT_ADRESS##</h3>
			<input type="checkbox" <%if $tpl_gast.privateAddress.defaultaddress eq "1" or $tpl_gast.guestid eq ""%>checked="checked"<%/if%> disabled="disabled"/> ##POSTAL_ADRESS##
      		<table class="address">
			     <colgroup>
        			<col width="25%">
        			<col width="20%">
        			<col width="20%">
					<col width="35%">
     			</colgroup>			
             <tr>
               <td colspan="2" valign="top"><strong>##STREET##</strong></td>
               <td align="right"><strong>##PHONE##</strong></td>
               <td><%$tpl_gast.privateAddress.phone%></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><textarea name="frm_other_address" id="frm_other_address" cols="42" rows="3"  class="disabled"><%$tpl_gast.privateAddress.address%></textarea></td>
               <td align="right"><strong>##FAX##</strong></td>
               <td><%$tpl_gast.privateAddress.fax%></td>
             </tr>
             <tr>
				<td colspan="2">
             <table class="city">
                <tr>
	               <td><strong>##COUNTRY_LABEL_SHORT##</strong></td>
	               <td><%$tpl_gast.privateAddress.region%></td>
	               <td><strong>##POSTAL_CODE_SHORT##</strong></td>
	               <td><%$tpl_gast.privateAddress.postalcode%></td>
 	               <td><strong>##CITY##</strong></td>
	               <td><%$tpl_gast.privateAddress.city%></td>
                </tr>
               </table>
				</td>
				<td align="right"><strong>##MOBILE_PHONE##</strong></td>
               <td><%$tpl_gast.privateAddress.mobile%></td>
             </tr>
             <tr>
             	<td><strong>##COUNTRY##</strong></td>
	            <td>&nbsp;</td>
               <td align="right"><strong>##EMAIL##</strong></td>
               <td><%if $tpl_gast.privateAddress.email neq ""%><a href="mailto:<%$tpl_gast.privateAddress.email%>"><%$tpl_gast.privateAddress.email%></a><%else%>&nbsp;<%/if%></td>
             </tr>
             <tr>
             	<td colspan="2"><%$tpl_gast.privateAddress.country_Name%></td>
				<td align="right"><strong>##HOMEPAGE##</strong></td>
				<td><%$tpl_gast.privateAddress.homepage%></td>
             </tr>
			</table>
</div>
<div id="add_business" name="add_business" style="display:none;">
		&nbsp;<div class="toolbar"><a href="javascript:switchLayer('add_private');" class="dotted">##PRIVATE##</a> | <a href="javascript:switchLayer('add_business');" class="dotted">##BUSINESS##</a> | <a href="javascript:switchLayer('add_other');" class="dotted">##OTHER##</a></div>      
		<h3>##BUSINESS_ADRESS##</h3>
			<input type="checkbox" <%if $tpl_gast.businessAddress.defaultaddress eq "1" or $tpl_gast.guestid eq ""%>checked="checked"<%/if%> disabled="disabled"/> Postanschrift
      		<table class="address">
			     <colgroup>
        			<col width="25%">
        			<col width="20%">
        			<col width="20%">
					<col width="35%">
     			</colgroup>		

             <tr>
               <td colspan="2" valign="top"><strong>##STREET##</strong></td>
               <td align="right"><strong>##PHONE##</strong></td>
               <td><%$tpl_gast.businessAddress.phone%></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><textarea name="frm_other_address" id="frm_other_address" cols="42" rows="3"  class="disabled"><%$tpl_gast.businessAddress.address%></textarea></td>
               <td align="right"><strong>##FAX##</strong></td>
               <td><%$tpl_gast.businessAddress.fax%></td>
             </tr>
             <tr>
				<td colspan="2">
             <table class="city">
                <tr>
	               <td><strong>##COUNTRY_LABEL_SHORT##</strong></td>
	               <td><%$tpl_gast.businessAddress.region%></td>
	               <td><strong>##POSTAL_CODE_SHORT##</strong></td>
	               <td><%$tpl_gast.businessAddress.postalcode%></td>
 	               <td><strong>##CITY##</strong></td>
	               <td><%$tpl_gast.businessAddress.city%></td>
                </tr>
               </table>
				</td>
				<td align="right"><strong>##MOBILE_PHONE##</strong></td>
               <td><%$tpl_gast.businessAddress.mobile%></td>
             </tr>
             <tr>
             	<td><strong>##COUNTRY##</strong></td>
	            <td>&nbsp;</td>
               <td align="right"><strong>##EMAIL##</strong></td>
               <td><%if $tpl_gast.businessAddress.email neq ""%><a href="mailto:<%$tpl_gast.businessAddress.email%>"><%$tpl_gast.businessAddress.email%></a><%else%>&nbsp;<%/if%></td>
             </tr>
             <tr>
             	<td colspan="2"><%$tpl_gast.businessAddress.country_Name%></td>
				<td align="right"><strong>##HOMEPAGE##</strong></td>
				<td><%$tpl_gast.businessAddress.homepage%></td>
             </tr>
			</table>
</div>
<div id="add_other" name="add_other" style="display:none;">
&nbsp;<div class="toolbar"><a href="javascript:switchLayer('add_private');" class="dotted">##PRIVATE##</a> | <a href="javascript:switchLayer('add_business');" class="dotted">##BUSINESS##</a> | <a href="javascript:switchLayer('add_other');" class="dotted">##OTHER##</a></div>      
			<h3>##ANOTHER_ADRESS##</h3>
			<input type="checkbox" <%if $tpl_gast.otherAddress.otherAddress eq "1" or $tpl_gast.guestid eq ""%>checked="checked"<%/if%> disabled="disabled"/> Postanschrift
      		<table class="address">
			     <colgroup>
        			<col width="25%">
        			<col width="20%">
        			<col width="20%">
					<col width="35%">
     			</colgroup>				
             <tr>
               <td colspan="2" valign="top"><strong>##STREET##</strong></td>
               <td align="right"><strong>##PHONE##</strong></td>
               <td><%$tpl_gast.otherAddress.phone%></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><textarea name="frm_other_address" id="frm_other_address" cols="42" rows="3"  class="disabled"><%$tpl_gast.otherAddress.address%></textarea></td>
               <td align="right"><strong>##FAX##</strong></td>
               <td><%$tpl_gast.otherAddress.fax%></td>
             </tr>
             <tr>
				<td colspan="2">
             <table class="city">
                <tr>
	               <td><strong>##COUNTRY_LABEL_SHORT##</strong></td>
	               <td><%$tpl_gast.otherAddress.region%></td>
	               <td><strong>##POSTAL_CODE_SHORT##</strong></td>
	               <td><%$tpl_gast.otherAddress.postalcode%></td>
 	               <td><strong>##CITY##</strong></td>
	               <td><%$tpl_gast.otherAddress.city%></td>
                </tr>
               </table>
				</td>
				<td align="right"><strong>##MOBILE_PHONE##</strong></td>
               <td><%$tpl_gast.otherAddress.mobile%></td>
             </tr>
             <tr>
             	<td><strong>##COUNTRY##</strong></td>
	            <td>&nbsp;</td>
               <td align="right"><strong>##EMAIL##</strong></td>
               <td><%if $tpl_gast.otherAddress.email neq ""%><a href="mailto:<%$tpl_gast.otherAddress.email%>"><%$tpl_gast.otherAddress.email%></a><%else%>&nbsp;<%/if%></td>
             </tr>
             <tr>
             	<td colspan="2"><%$tpl_gast.otherAddress.country_Name%></td>
				<td align="right"><strong>##HOMEPAGE##</strong></td>
				<td><%$tpl_gast.otherAddress.homepage%></td>
             </tr>
			</table>
</div>
</div>
<%/if%>
<div id="edit" name="edit" <%if not $tpl_editmode%>style="display:none;"<%/if%>>	

<form accept-charset="utf-8" id="save" name="save" action="<%$SCRIPT_NAME%>" method="post">
	<input type="hidden" name="frm_guestid" id="frm_guestid" value="<%if $tpl_gast.guestid neq ""%><%$tpl_gast.guestid%><%else%>0<%/if%>"/>
	<div class="toolbar"><%if $tpl_gast.guestid neq ""%><a href="<%$wwwroot%>exportvcard.php/guestid.<%$tpl_gast.guestid%>/lastname.<%$tpl_gast.lastname%>/firstname.<%$tpl_gast.firstname%>" class="toolbar">##VCARD_EXPORT##</a><%/if%> <a href="javascript:document.save.submit();" class="toolbar" onclick="unsetaltered();" >##SAVE##</a> </div>
			<table class="mainaddress">
			 <colgroup>
				<col width="18%">
				<col width="18%">
				<col width="18%">
				<col width="18%">
				<col width="18%">
				<col width="10%">
			 </colgroup>
             <tr>
               <td><strong>##SALUTATION##</strong></td>
               <td><select name="frm_salutation" id="frm_salutation">
                    <%section name=sal loop=$tpl_salutation%>
                        <option value="<%$tpl_salutation[sal].salutation_id%>" <%if $tpl_salutation[sal].salutation_id eq $tpl_gast.salutation_id%>selected<%/if%>><%$tpl_salutation[sal].salutation%></option>
                    <%/section%>
               </select></td>
               <td align="right"><strong>##TITLE##</strong></td>
               <td><input name="frm_academictitle" type="text" id="frm_academictitle" size="30" value="<%$tpl_gast.academic_title%>"></td>
               <td align="right"><strong>##GENDER##</strong></td>
               <td><select name="frm_gender" id="frm_gender" style="width:4em;">
                   <option value="M" <%if $tpl_gast.gender eq "M"%>selected<%/if%>>##MALE_SHORT##</option>
                   <option value="F" <%if $tpl_gast.gender eq "F"%>selected<%/if%>>##FEMALE_SHORT##</option>
                 </select></td>
             </tr>
             <tr>
               <td><strong>##FIRSTNAME##</strong></td>
               <td><input name="frm_firstname" type="text" id="frm_firstname" size="30" value="<%$tpl_gast.firstname%>"/></td>
               <td align="right"><strong>##LASTNAME##</strong></td>
               <td><input name="frm_lastname" type="text" id="frm_lastname" size="30" value="<%$tpl_gast.lastname%>"/></td>
               <td align="right"><strong>##LANGUAGE##</strong></td>
               <td><select name="frm_language" id="frm_language" style="width:4em;">
                   <option value="2" <%if $tpl_gast.language_id eq "2"%>selected<%/if%>>##GERMAN_SHORT##</option>
                   <option value="3" <%if $tpl_gast.language_id eq "3"%>selected<%/if%>>##ENGLISH_SHORT##</option>
                   <option value="4" <%if $tpl_gast.language_id eq "4"%>selected<%/if%>>##ITALIAN_SHORT##</option>
                 </select></td>
             </tr>
             <tr>
               <td><strong>##JOB##</strong></td>
               <td><input name="frm_job" type="text" id="frm_job" size="30" value="<%$tpl_gast.job%>"/></td>
               <td align="right"><strong>##COMPANY##</strong></td>
               <td><input name="frm_company" type="text" id="frm_company" size="30" value="<%$tpl_gast.company%>"/></td>
               <td align="right"><strong>##FORMAL_GREETING##</strong></td>
               <td><select name="frm_formal_greeting" id="frm_formal_greeting" style="width:4em;">
                   <option value="N" <%if $tpl_gast.formal_greeting eq "N"%>selected<%/if%>>##YOU_PERSONAL##</option>
                   <option value="Y" <%if $tpl_gast.formal_greeting eq "Y"%>selected<%/if%>>##YOU_UNPERSONAL##</option>
                 </select></td>
             </tr>
             <tr>
               <td><strong>##DATE_OF_BIRTH##</strong></td>
               <td><input name="frm_date_of_birth" type="text" id="frm_date_of_birth" size="10" value="<%if $tpl_gast.date_of_birth neq "00.00.0000"%><%$tpl_gast.date_of_birth%><%/if%>"/><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar1Callback(date, month, year)
        {
            document.forms['save'].frm_date_of_birth.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['save'].frm_date_of_birth.value;
        	if (strDate != "")
			{
				arrDate = strDate.split(".");
				month = arrDate[1]-1;
				year = arrDate[2];
				day = arrDate[0];
				strDate = month+', '+year+', '+day;
			} else {
				strDate = "";
			}
         return strDate
        }

        calendar1 = new dynCalendar('calendar1', 'calendar1Callback', '<%$wwwroot%>img/');
    //-->
    </script>
    <%strip%> &nbsp;&nbsp;<input type="checkbox" name="frm_reminder" id="reminder" value="Y" <%if $tpl_gast.reminder eq "Y"%>checked="checked"<%/if%>/> ##REMINDER##</td>
			   <td align="right"><strong>##PLACE_OF_BIRTH##</strong></td>
				<td><input type="text" name="frm_birthplace" id="frm_birthplace" size="30" value="<%$tpl_gast.birthplace%>"/></td>
				<td colspan="2"></td>
				</tr>
			  <tr>
				<td><strong>##NATIONALITY##</strong></td>
				<td colspan="5"><select id="frm_nationality" name="frm_nationality">
                <%section name=cou loop=$tpl_countries%>
                        <option value="<%$tpl_countries[cou].countrySuffix%>" <%if $tpl_gast.nationality_id neq ""%><%if $tpl_countries[cou].countrySuffix eq $tpl_gast.nationality_id%>selected<%/if%><%else%><%if $tpl_countries[cou].countrySuffix eq "DE"%>selected<%/if%><%/if%>><%$tpl_countries[cou].countryName%></option>
                <%/section%>
                        </select></td>
			  </tr>		
			  <tr>
				<td><strong>##DOCUMENT_OF_IDENTITY##</strong></td>
				<td><select name="frm_identification" id="frm_identification" style="width:10em;">
           <option value="P" <%if $tpl_gast.identification eq "P"%>selected<%/if%>>##IDENTITY_CARD##</option>	
           <option value="R" <%if $tpl_gast.identification eq "R"%>selected<%/if%>>##PASSPORT##</option>
           <option value="F" <%if $tpl_gast.identification eq "F"%>selected<%/if%>>##DRIVING_LICENSE##</option>                   
        </select></td>
				<td align="right"><strong>##IDENTITY_CARD_NUMBER##</strong></td>
			    <td><input name="frm_passport" type="text" id="frm_passport" size="30" value="<%$tpl_gast.passport%>"/></td>
				<td colspan="2">&nbsp;</td>
			 </tr>			  		
				<tr>
					 	<td><strong>##AGENCY_OF_EXHIBITION##</strong></td>
						<td><input name="frm_agency" type="text" id="frm_agency" size="30" value="<%$tpl_gast.agency%>"/></td>
						<td align="right"><strong>##DATE_OF_EXHIBITION##</strong></td>
						<td><input name="frm_issue_date" type="text" id="frm_issue_date" size="10" value="<%if $tpl_gast.issue_date neq "00.00.0000"%><%$tpl_gast.issue_date%><%/if%>"/><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar2Callback(date, month, year)
        {
            document.forms['save'].frm_issue_date.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['save'].frm_issue_date.value;
        	if (strDate != "")
			{
				arrDate = strDate.split(".");
				month = arrDate[1]-1;
				year = arrDate[2];
				day = arrDate[0];
				strDate = month+', '+year+', '+day;
			} else {
				strDate = "";
			}

         return strDate
        }

        calendar2 = new dynCalendar('calendar2', 'calendar2Callback', '<%$wwwroot%>img/');
    //-->
    </script>
    <%strip%></td>
            <td colspan="2"><input type="checkbox" name="frm_status" id="frm_status" value="Y" <%if $tpl_gast.status eq "Y"%>checked<%/if%>/> <strong>##REGULAR_GUEST##</strong></td>
        </tr>
        <tr>
				<td colspan="6" class="annotation">
				<%if $tpl_gast.guestid neq ""%>
	                ##MADE_BY## <%$tpl_gast.inserted_user%>&nbsp;##AT##&nbsp;<%$tpl_gast.inserteddate%>
	               &nbsp;
	               <%if $tpl_gast.updated_user neq "" and $tpl_gast.updated_user neq " "%> - 
	               	##LAST_ACTUALISATION_BY## <%$tpl_gast.updated_user%>&nbsp;##AT##&nbsp;<%$tpl_gast.updated_date%>
					<%/if%>
				<%else%>
				&nbsp;
				<%/if%>
				</td>
       </tr>
      </table>
<br/>

<div id="e_add_private" name="e_add_private">
	<input type="hidden" name="frm_private_addressid" id="frm_private_addressid" value="<%if $tpl_gast.privateAddress.addressid neq ""%><%$tpl_gast.privateAddress.addressid%><%else%>0<%/if%>"/>
   &nbsp;<div class="toolbar"><a href="javascript:switchLayer('e_add_private');" class="dotted" onClick="bypassCheck();">##PRIVATE##</a> | <a href="javascript:switchLayer('e_add_business');" class="dotted" onClick="bypassCheck();">##BUSINESS##</a> | <a href="javascript:switchLayer('e_add_other');" class="dotted" onClick="bypassCheck();">##OTHER##</a> | 
	 &nbsp;&nbsp;<%if $tpl_gast.guestid neq ""%><a href="<%$wwwroot%>shareaddress.php/guestid.<%$tpl_gast.guestid%>/type.private/shareaddress.php" class="dotted">##SHARE_ADDRESS##</a><%/if%> | <%if $tpl_gast.privateAddress.count gt 1%><input type="checkbox" name="frm_private_copy" id="frm_private_copy" value="true"/> ##DO_NOT_SHARE_ADDRESS##<%else%><input type="checkbox" name="frm_private_copy2" id="frm_private_copy2" value="true" diabled="disabled"/>##ADDRESS_NOT_SHARED##<%/if%></div>
      <h3>##PRIVAT_ADRESS##</h3>
			<input type="radio" name="frm_default_address" id="frm_default_address" value="private" <%if $tpl_gast.privateAddress.defaultaddress eq "1" or $tpl_gast.guestid eq ""%>checked="checked"<%/if%>/> ##POSTAL_ADRESS##
      		<table class="address">
			     <colgroup>
        			<col width="25%">
        			<col width="20%">
        			<col width="20%">
					<col width="35%">
     			</colgroup>			
             <tr>
               <td colspan="2" valign="top"><strong>##STREET##</strong></td>
               <td align="right"><strong>##PHONE##</strong></td>
               <td><input name="frm_private_phone" type="text" id="frm_private_phone" size="30" value="<%$tpl_gast.privateAddress.phone%>"/></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><textarea name="frm_private_address" id="frm_private_address" cols="42" rows="3"><%$tpl_gast.privateAddress.address%></textarea></td>
               <td align="right"><strong>##FAX##</strong></td>
               <td><input name="frm_private_fax" type="text" id="frm_private_fax" size="30" value="<%$tpl_gast.privateAddress.fax%>"/></td>
             </tr>
             <tr>
				<td colspan="2">
             <table class="city">
                <tr>
	               <td><strong>##COUNTRY_LABEL_SHORT##</strong></td>
	               <td><input name="frm_private_region" type="text" id="frm_private_region" size="5" value="<%$tpl_gast.privateAddress.region%>"/></td>
	               <td><strong>##POSTAL_CODE_SHORT##</strong></td>
	               <td><input name="frm_private_postalcode" type="text" id="frm_private_postalcode" size="10" value="<%$tpl_gast.privateAddress.postalcode%>"/></td>
 	               <td><strong>##CITY##</strong></td>
	               <td><input name="frm_private_city" type="text" id="frm_private_city" size="30" value="<%$tpl_gast.privateAddress.city%>"/></td>
                </tr>
               </table>
				</td>
				<td align="right"><strong>##MOBILE_PHONE##</strong></td>
               <td><input name="frm_private_mobile" type="text" id="frm_private_mobile" size="30" value="<%$tpl_gast.privateAddress.mobile%>"/></td>
             </tr>
             <tr>
             	<td><strong>##COUNTRY##</strong></td>
	            <td>&nbsp;</td>
               <td align="right"><strong>##EMAIL##</strong></td>
               <td><input name="frm_private_email" type="text" id="frm_private_email" size="30" value="<%$tpl_gast.privateAddress.email%>"/></td>
             </tr>
             <tr>
             	<td colspan="2"><select id="frm_private_country" name="frm_private_country">
                <%section name=cou loop=$tpl_countries%>
                        <option value="<%$tpl_countries[cou].countrySuffix%>" <%if $tpl_gast.privateAddress.country_id neq ""%><%if $tpl_countries[cou].countrySuffix eq $tpl_gast.privateAddress.country_id%>selected<%/if%><%else%><%if $tpl_countries[cou].countrySuffix eq "DE"%>selected<%/if%><%/if%>><%$tpl_countries[cou].countryName%></option>
                <%/section%>
                        </select></td>
				<td align="right"><strong>##HOMEPAGE##</strong></td>
				<td><input type="text" name="frm_private_homepage" id="frm_private_homepage" size="30" value="<%$tpl_gast.privateAddress.homepage%>"/></td>
             </tr>
			</table>
</div>
<div id="e_add_business" name="e_add_business" style="display:none;">
<input type="hidden" name="frm_business_addressid" id="frm_business_addressid" value="<%if $tpl_gast.businessAddress.addressid neq ""%><%$tpl_gast.businessAddress.addressid%><%else%>0<%/if%>"/>
		&nbsp;<div class="toolbar"><a href="javascript:switchLayer('e_add_private');" class="dotted" onClick="bypassCheck();">##PRIVATE##</a> | <a href="javascript:switchLayer('e_add_business');" class="dotted" onClick="bypassCheck();">##BUSINESS##</a> | <a href="javascript:switchLayer('e_add_other');" class="dotted" onClick="bypassCheck();">##OTHER##</a> | 
		&nbsp;&nbsp;<%if $tpl_gast.guestid neq ""%><a href="<%$wwwroot%>shareaddress.php/guestid.<%$tpl_gast.guestid%>/type.business/shareaddress.php" class="dotted">##SHARE_ADDRESS##</a><%/if%> | <%if $tpl_gast.businessAddress.count gt 1%><input type="checkbox" name="frm_business_copy" id="frm_business_copy" value="true"/> ##DO_NOT_SHARE_ADDRESS##<%else%><input type="checkbox" name="frm_business_copy2" id="frm_business_copy2" value="true" disabled="disabled"/> ##ADDRESS_NOT_SHARED##<%/if%>
		</div>      
		<h3>##BUSINESS_ADRESS##</h3>
			<input type="radio" name="frm_default_address" id="frm_default_address" value="business" <%if $tpl_gast.businessAddress.defaultaddress eq "1"%>checked="checked"<%/if%>/> ##POSTAL_ADRESS##
			 		<table class="address">
			     <colgroup>
        			<col width="25%">
        			<col width="20%">
        			<col width="20%">
					<col width="35%">
     			</colgroup>	

             <tr>
               <td colspan="2" valign="top"><strong>##STREET##</strong></td>
               <td align="right"><strong>##PHONE##</strong></td>
               <td><input name="frm_business_phone" type="text" id="frm_business_phone" size="30" value="<%$tpl_gast.businessAddress.phone%>"/></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><textarea name="frm_business_address" id="frm_business_address" cols="42" rows="3"><%$tpl_gast.businessAddress.address%></textarea></td>
               <td align="right"><strong>##FAX##</strong></td>
               <td><input name="frm_business_fax" type="text" id="frm_business_fax" size="30" value="<%$tpl_gast.businessAddress.fax%>"/></td>
             </tr>
             <tr>
				<td colspan="2">
             <table class="city">
                <tr>
	               <td><strong>##COUNTRY_LABEL_SHORT##</strong></td>
	               <td><input name="frm_business_region" type="text" id="frm_business_region" size="5" value="<%$tpl_gast.businessAddress.region%>"/></td>
	               <td><strong>##POSTAL_CODE_SHORT##</strong></td>
	               <td><input name="frm_business_postalcode" type="text" id="frm_business_postalcode" size="10" value="<%$tpl_gast.businessAddress.postalcode%>"/></td>
 	               <td><strong>##CITY##</strong></td>
	               <td><input name="frm_business_city" type="text" id="frm_business_city" size="30" value="<%$tpl_gast.businessAddress.city%>"/></td>
                </tr>
               </table>
				</td>
				<td align="right"><strong>##MOBILE_PHONE##</strong></td>
               <td><input name="frm_business_mobile" type="text" id="frm_business_mobile" size="30" value="<%$tpl_gast.businessAddress.mobile%>"/></td>
             </tr>
             <tr>
             	<td><strong>##COUNTRY##</strong></td>
	            <td>&nbsp;</td>
               <td align="right"><strong>##EMAIL##</strong></td>
               <td><input name="frm_business_email" type="text" id="frm_business_email" size="30" value="<%$tpl_gast.businessAddress.email%>"/></td>
             </tr>
             <tr>
             	<td colspan="2"><select id="frm_business_country" name="frm_business_country">
                <%section name=cou loop=$tpl_countries%>
                        <option value="<%$tpl_countries[cou].countrySuffix%>" <%if $tpl_gast.businessAddress.country_id neq ""%><%if $tpl_countries[cou].countrySuffix eq $tpl_gast.businessAddress.country_id%>selected<%/if%><%else%><%if $tpl_countries[cou].countrySuffix eq "DE"%>selected<%/if%><%/if%>><%$tpl_countries[cou].countryName%></option>
                <%/section%>
                        </select></td>
				<td align="right"><strong>##HOMEPAGE##</strong></td>
				<td><input type="text" name="frm_business_homepage" id="frm_business_homepage" size="30" value="<%$tpl_gast.businessAddress.homepage%>"/></td>
             </tr>
			</table>
</div>
<div id="e_add_other" name="e_add_other" style="display:none;">
<input type="hidden" name="frm_other_addressid" id="frm_other_addressid" value="<%if $tpl_gast.otherAddress.addressid neq ""%><%$tpl_gast.otherAddress.addressid%><%else%>0<%/if%>"/>
&nbsp;<div class="toolbar"><a href="javascript:switchLayer('e_add_private');" class="dotted" onClick="bypassCheck();">##PRIVATE##</a> | <a href="javascript:switchLayer('e_add_business');" class="dotted" onClick="bypassCheck();">##BUSINESS##</a> | <a href="javascript:switchLayer('e_add_other');" class="dotted" onClick="bypassCheck();">##OTHER##</a> | 
&nbsp;&nbsp;<%if $tpl_gast.guestid neq ""%><a href="<%$wwwroot%>shareaddress.php/guestid.<%$tpl_gast.guestid%>/type.other/shareaddress.php" class="dotted">##SHARE_ADDRESS##</a><%/if%> | <%if $tpl_gast.otherAddress.count gt 1%><input type="checkbox" name="frm_other_copy" id="frm_other_copy" value="true"/> ##DO_NOT_SHARE_ADDRESS## <%else%><input type="checkbox" name="frm_other_copy2" id="frm_other_copy2" value="true" disabled="disabled"/>  ##ADDRESS_NOT_SHARED##<%/if%>
</div>      
			<h3>##ANOTHER_ADRESS##</h3>
			<input type="radio" name="frm_default_address" id="frm_default_address" value="other"  <%if $tpl_gast.otherAddress.defaultaddress eq "1"%>checked="checked"<%/if%>/> ##POSTAL_ADRESS##
      		<table class="address">
			     <colgroup>
        			<col width="25%">
        			<col width="20%">
        			<col width="20%">
					<col width="35%">
     			</colgroup>		
             <tr>
               <td colspan="2" valign="top"><strong>##STREET##</strong></td>
               <td align="right"><strong>##PHONE##</strong></td>
               <td><input name="frm_other_phone" type="text" id="frm_other_phone" size="30" value="<%$tpl_gast.otherAddress.phone%>"/></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><textarea name="frm_other_address" id="frm_other_address" cols="42" rows="3"><%$tpl_gast.otherAddress.address%></textarea></td>
               <td align="right"><strong>##FAX##</strong></td>
               <td><input name="frm_other_fax" type="text" id="frm_other_fax" size="30" value="<%$tpl_gast.otherAddress.fax%>"/></td>
             </tr>
             <tr>
				<td colspan="2">
             <table class="city">
                <tr>
	               <td><strong>##COUNTRY_LABEL_SHORT##</strong></td>
	               <td><input name="frm_other_region" type="text" id="frm_other_region" size="5" value="<%$tpl_gast.otherAddress.region%>"/></td>
	               <td><strong>##POSTAL_CODE_SHORT##</strong></td>
	               <td><input name="frm_other_postalcode" type="text" id="frm_other_postalcode" size="10" value="<%$tpl_gast.otherAddress.postalcode%>"/></td>
 	               <td><strong>##CITY##</strong></td>
	               <td><input name="frm_other_city" type="text" id="frm_other_city" size="30" value="<%$tpl_gast.otherAddress.city%>"/></td>
                </tr>
               </table>
				</td>
				<td align="right"><strong>##MOBILE_PHONE##</strong></td>
               <td><input name="frm_other_mobile" type="text" id="frm_other_mobile" size="30" value="<%$tpl_gast.otherAddress.mobile%>"/></td>
             </tr>
             <tr>
             	<td><strong>##COUNTRY##</strong></td>
	            <td>&nbsp;</td>
               <td align="right"><strong>##EMAIL##</strong></td>
               <td><input name="frm_other_email" type="text" id="frm_other_email" size="30" value="<%$tpl_gast.otherAddress.email%>"/></td>
             </tr>
             <tr>
             	<td colspan="2"><select id="frm_other_country" name="frm_other_country">
                <%section name=cou loop=$tpl_countries%>
                        <option value="<%$tpl_countries[cou].countrySuffix%>" <%if $tpl_gast.otherAddress.country_id neq ""%><%if $tpl_countries[cou].countrySuffix eq $tpl_gast.otherAddress.country_id%>selected<%/if%><%else%><%if $tpl_countries[cou].countrySuffix eq "DE"%>selected<%/if%><%/if%>><%$tpl_countries[cou].countryName%></option>
                <%/section%>
                        </select></td>
				<td align="right"><strong>##HOMEPAGE##</strong></td>
				<td><input type="text" name="frm_other_homepage" id="frm_other_homepage" size="30" value="<%$tpl_gast.otherAddress.homepage%>"/></td>
             </tr>
			</table>
	</div>
	</form>
</div>
<%include file=footer.tpl%>
<%/strip%>

