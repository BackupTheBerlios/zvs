<%strip%>
<%include file=header.tpl%>
<form id="save" name="save" action="<%$SCRIPT_NAME%>" method="post">
<input type="hidden" name="frm_guestid" id="frm_guestid" value="<%if $tpl_gast.guestid neq ""%><%$tpl_gast.guestid%><%else%>0<%/if%>">
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
			<table width="100%" boder="0">
			<%if $tpl_gast.guestid neq ""%>
			<tr>
				<td colspan="2" align="right"><a href="<%$wwwroot%>exportvcard.php/guestid.<%$tpl_gast.guestid%>/lastname.<%$tpl_gast.lastname%>/firstname.<%$tpl_gast.firstname%>" onClick="bypassCheck()"><img src="<%$wwwroot%>img/vcard.png" border="0" width="26" height="20" alt="VCard exportieren"></a></td>
			</tr>
			<%/if%>
			<tr>
				<td class="SubheadlineYellow"><%if $tpl_gast.lastname neq ""%><%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></td>
				<td align="right"><a href="javascript:document.save.submit();" onClick="unsetaltered();"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a></td>
			</tr>
			</table>
 			<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td><strong>Anrede</strong></td>
               <td> <select name="frm_salutation" id="frm_salutation">
                    <%section name=sal loop=$tpl_salutation%>
                        <option value="<%$tpl_salutation[sal].salutation_id%>" <%if $tpl_salutation[sal].salutation_id eq $tpl_gast.salutation_id%>selected<%/if%>><%$tpl_salutation[sal].salutation%></option>
                    <%/section%>
               </select> </td>
               <td><strong>Titel</strong></td>
               <td><input name="frm_academictitle" type="text" id="frm_academictitle" size="30" value="<%$tpl_gast.academic_title%>"></td>
               <td><strong>Geschlecht</strong></td>
               <td> <select name="frm_gender" id="frm_gender">
                   <option value="M" <%if $tpl_gast.gender eq "M"%>selected<%/if%>>m</option>
                   <option value="F" <%if $tpl_gast.gender eq "F"%>selected<%/if%>>w</option>
                 </select> </td>                 
             </tr>
             <tr>
               <td><strong>Vorname</strong></td>
               <td><input name="frm_firstname" type="text" id="frm_firstname" size="30" value="<%$tpl_gast.firstname%>"></td>
               <td><strong>Nachname</strong></td>
               <td><input name="frm_lastname" type="text" id="frm_lastname" size="30" value="<%$tpl_gast.lastname%>"></td>
               <td><strong>Sprache</strong></td>
               <td> <select name="frm_language" id="frm_language">
                   <option value="2" <%if $tpl_gast.language_id eq "2"%>selected<%/if%>>D</option>
                   <option value="3" <%if $tpl_gast.language_id eq "3"%>selected<%/if%>>E</option>
                   <option value="4" <%if $tpl_gast.language_id eq "4"%>selected<%/if%>>I</option>
                 </select> </td>      
             </tr>
             <tr>
               <td><strong>Beruf</strong></td>
               <td><input name="frm_job" type="text" id="frm_job" size="30" value="<%$tpl_gast.job%>"></td>
               <td><strong>Firma</strong></td>
               <td><input name="frm_company" type="text" id="frm_company" size="30" value="<%$tpl_gast.company%>"></td>
               <td><strong>Du/Sie</strong></td>
               <td> <select name="frm_formal_greeting" id="frm_formal_greeting">
                   <option value="N" <%if $tpl_gast.formal_greeting eq "N"%>selected<%/if%>>Du</option>
                   <option value="Y" <%if $tpl_gast.formal_greeting eq "Y"%>selected<%/if%>>Sie</option>
                 </select> </td>      
             </tr>  
             <tr>
               <td><strong>Geburtsdatum</strong></td>
               <td><input name="frm_date_of_birth" type="text" id="frm_date_of_birth" size="10" value="<%if $tpl_gast.date_of_birth neq "00.00.0000"%><%$tpl_gast.date_of_birth%><%/if%>"><%/strip%>
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
    <%strip%> &nbsp;&nbsp;<input type="checkbox" name="frm_reminder" id="reminder" value="Y" <%if $tpl_gast.reminder eq "Y"%>checked="checked"<%/if%>> erinnern</td>
	<td><strong>Geburtsort</strong></td>
	<td><input type="text" name="frm_birthplace" id="frm_birthplace" size="30" value="<%$tpl_gast.birthplace%>"></td>
	<td colspan="2">&nbsp;</td>
  </tr>
  <tr>
	<td><strong>Staatsangeh&ouml;rigkeit</strong></td>
	<td><select id="frm_nationality" name="frm_nationality">
                <%section name=cou loop=$tpl_countries%>
                        <option value="<%$tpl_countries[cou].countrySuffix%>" <%if $tpl_gast.nationality_id neq ""%><%if $tpl_countries[cou].countrySuffix eq $tpl_gast.nationality_id%>selected<%/if%><%else%><%if $tpl_countries[cou].countrySuffix eq "DE"%>selected<%/if%><%/if%>><%$tpl_countries[cou].countryName%></option>
                <%/section%>
                        </select></td>
	<td colspan="4"></td>
  </tr>
  <tr>
	<td><strong>Ausweisdokument</strong></td>
	<td><select name="frm_identification" id="frm_identification">
           <option value="P" <%if $tpl_gast.identification eq "P"%>selected<%/if%>>Personalausweis</option>	
           <option value="R" <%if $tpl_gast.identification eq "R"%>selected<%/if%>>Reisepass</option>
           <option value="F" <%if $tpl_gast.identification eq "F"%>selected<%/if%>>F&uuml;hrerschein</option>                   
        </select></td>
	<td><strong>Ausweis-Nummer</strong></td>
    <td><input name="frm_passport" type="text" id="frm_passport" size="30" value="<%$tpl_gast.passport%>"></td>´
	<td colspan="2">&nbsp;</td>
 </tr>
 <tr>            
 	<td><strong>Ausstellungsbeh&ouml;rde</strong></td>
	<td><input name="frm_agency" type="text" id="frm_agency" size="30" value="<%$tpl_gast.agency%>"></td>
	<td><strong>Ausstellungsdatum</strong></td>
	<td><input name="frm_issue_date" type="text" id="frm_issue_date" size="10" value="<%if $tpl_gast.issue_date neq "00.00.0000"%><%$tpl_gast.issue_date%><%/if%>"><%/strip%>
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
	<td colspan="2"><input type="checkbox" name="frm_status" id="frm_status" value="Y" <%if $tpl_gast.status eq "Y"%>checked<%/if%>> <strong>Stammgast</strong></td>

               
    
             </tr> 
           <tr>
				<td colspan="6">
				<%if $tpl_gast.guestid neq ""%>
				<table border="0">
					<tr>
	                <td>erstellt von <%$tpl_gast.inserted_user%>&nbsp;am&nbsp;<%$tpl_gast.inserteddate%></td>
	               <td>&nbsp;</td>
	               <%if $tpl_gast.updated_user neq "" and $tpl_gast.updated_user neq " "%>
	               	<td>letzte &Auml;nderung von <%$tpl_gast.updated_user%>&nbsp;am&nbsp;<%$tpl_gast.updated_date%></td>
	               <%else%>
						<td>&nbsp;</td>
					<%/if%>
	 			   </tr>
				</table>
				<%else%>
				&nbsp;
				<%/if%>
				</td>
             </tr>

           </table>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
<br>
<img id="placeholder" name="placeholder" src="<%$wwwroot%>img/spacer.gif" width="1" height="1">
<div id="add_private" name="add_private" style="visibility:visible">
<input type="hidden" name="frm_private_addressid" id="frm_private_addressid" value="<%if $tpl_gast.privateAddress.addressid neq ""%><%$tpl_gast.privateAddress.addressid%><%else%>0<%/if%>">
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
   <td class="White">&nbsp;</td>
   <td align="right" class="White">
       <table border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td class="NavActive"><a href="javascript:switchLayer('add_private');" class="NavActive" onClick="bypassCheck()">privat</a></td>
           <td class="NavInactive"><a href="javascript:switchLayer('add_business');" class="NavInactive" onClick="bypassCheck()">gesch&auml;ftlich</a></td>
           <td class="NavInactive"><a href="javascript:switchLayer('add_other');" class="NavInactive" onClick="bypassCheck()">andere</a></td>
   	 	 </tr>
       </table>
   </td>
   <td class="White">&nbsp;</td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
      <p class="SubheadlineYellow">private Addresse</p>
			<input type="radio" name="frm_default_address" id="frm_default_address" value="private" <%if $tpl_gast.privateAddress.defaultaddress eq "1" or $tpl_gast.guestid eq ""%>checked="checked"<%/if%>> Postanschrift
			&nbsp;&nbsp;
			<%if $tpl_gast.privateAddress.count gt 1%><input type="checkbox" name="frm_private_copy" id="frm_private_copy" value="true"> Addresse nicht mehr teilen<%/if%>
      		<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td  rowspan="2" valign="top"><strong>Stra&szlig;e</strong></td>
               <td rowspan="2"><textarea name="frm_private_address" id="frm_private_address" cols="50" rows="3"><%$tpl_gast.privateAddress.address%></textarea></td>
               <td><strong>Telefon</strong></td>
               <td><input name="frm_private_phone" type="text" id="frm_private_phone" size="30" value="<%$tpl_gast.privateAddress.phone%>"></td>
             </tr>
             <tr>
               <td><strong>FAX</strong></td>
               <td><input name="frm_private_fax" type="text" id="frm_private_fax" size="30" value="<%$tpl_gast.privateAddress.fax%>"></td>
             </tr>
             <tr>
				<td colspan="2">
             <table border="0" cellpadding="4" cellspacing="0">
                <tr>
	               <td><strong>LKZ</strong></td>
	               <td><input name="frm_private_region" type="text" id="frm_private_region" size="10" value="<%$tpl_gast.privateAddress.region%>"></td>
	               <td><strong>PLZ</strong></td>
	               <td><input name="frm_private_postalcode" type="text" id="frm_private_postalcode" size="10" value="<%$tpl_gast.privateAddress.postalcode%>"></td>
 	               <td><strong>Ort</strong></td>
	               <td><input name="frm_private_city" type="text" id="frm_private_city" size="30" value="<%$tpl_gast.privateAddress.city%>"></td>
                </tr>
               </table>
				</td>
				<td><strong>Handy</strong></td>
               <td><input name="frm_private_mobile" type="text" id="frm_private_mobile" size="30" value="<%$tpl_gast.privateAddress.mobile%>"></td>
             </tr>
             <tr>
             	<td><strong>Land</strong></td>
	            <td><select id="frm_private_country" name="frm_private_country">
                <%section name=cou loop=$tpl_countries%>
                        <option value="<%$tpl_countries[cou].countrySuffix%>" <%if $tpl_gast.privateAddress.country_id neq ""%><%if $tpl_countries[cou].countrySuffix eq $tpl_gast.privateAddress.country_id%>selected<%/if%><%else%><%if $tpl_countries[cou].countrySuffix eq "DE"%>selected<%/if%><%/if%>><%$tpl_countries[cou].countryName%></option>
                <%/section%>
                        </select></td>
               <td><strong>eMail</strong></td>
               <td><input name="frm_private_email" type="text" id="frm_private_email" size="30" value="<%$tpl_gast.privateAddress.email%>"></td>
             </tr>
             <tr>
				<td colspan="2">&nbsp;</td>
				<td><strong>Homepage</strong></td>
				<td><input type="text" name="frm_private_homepage" id="frm_private_homepage" size="30" value="<%$tpl_gast.privateAddress.homepage%>"></td>
             </tr>
  			</table>

    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
</div>
<div id="add_business" name="add_business" style="visibility:visible">
<input type="hidden" name="frm_business_addressid" id="frm_business_addressid" value="<%if $tpl_gast.businessAddress.addressid neq ""%><%$tpl_gast.businessAddress.addressid%><%else%>0<%/if%>">
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
   <td class="White">&nbsp;</td>
   <td align="right" class="White">
       <table border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td class="NavInactive"><a href="javascript:switchLayer('add_private');" class="NavInactive" onClick="bypassCheck()">privat</a></td>
           <td class="NavActive"><a href="javascript:switchLayer('add_business');" class="NavActive" onClick="bypassCheck()">gesch&auml;ftlich</a></td>
           <td class="NavInactive"><a href="javascript:switchLayer('add_other');" class="NavInactive" onClick="bypassCheck()">andere</a></td>
   	 	 </tr>
       </table>
   </td>
   <td class="White">&nbsp;</td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
      <p class="SubheadlineYellow">Gesch&auml;ftsaddresse</p>
			<input type="radio" name="frm_default_address" id="frm_default_address" value="business" <%if $tpl_gast.businessAddress.defaultaddress eq "1"%>checked="checked"<%/if%>> Postanschrift
			&nbsp;&nbsp;
			<%if $tpl_gast.businessAddress.count gt 1%><input type="checkbox" name="frm_business_copy" id="frm_business_copy" value="true"> Addresse nicht mehr teilen<%/if%>
      		<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td  rowspan="2" valign="top"><strong>Stra&szlig;e</strong></td>
               <td rowspan="2"><textarea name="frm_business_address" id="frm_business_address" cols="50" rows="3"><%$tpl_gast.businessAddress.address%></textarea></td>
               <td><strong>Telefon</strong></td>
               <td><input name="frm_business_phone" type="text" id="frm_business_phone" size="30" value="<%$tpl_gast.businessAddress.phone%>"></td>
             </tr>
             <tr>
               <td><strong>FAX</strong></td>
               <td><input name="frm_business_fax" type="text" id="frm_business_fax" size="30" value="<%$tpl_gast.businessAddress.fax%>"></td>
             </tr>
             <tr>
				<td colspan="2">
             <table border="0" cellpadding="4" cellspacing="0">
                <tr>
	               <td><strong>LKZ</strong></td>
	               <td><input name="frm_business_region" type="text" id="frm_business_region" size="10" value="<%$tpl_gast.businessAddress.region%>"></td>
	               <td><strong>PLZ</strong></td>
	               <td><input name="frm_business_postalcode" type="text" id="frm_business_postalcode" size="10" value="<%$tpl_gast.businessAddress.postalcode%>"></td>
 	               <td><strong>Ort</strong></td>
	               <td><input name="frm_business_city" type="text" id="frm_business_city" size="30" value="<%$tpl_gast.businessAddress.city%>"></td>
                </tr>
               </table>
				</td>
				<td><strong>Handy</strong></td>
               <td><input name="frm_business_mobile" type="text" id="frm_business_mobile" size="30" value="<%$tpl_gast.businessAddress.mobile%>"></td>
             </tr>
             <tr>
             	<td><strong>Land</strong></td>
	            <td><select id="frm_business_country" name="frm_business_country">
                <%section name=cou loop=$tpl_countries%>
                        <option value="<%$tpl_countries[cou].countrySuffix%>" <%if $tpl_gast.businessAddress.country_id neq ""%><%if $tpl_countries[cou].countrySuffix eq $tpl_gast.businessAddress.country_id%>selected<%/if%><%else%><%if $tpl_countries[cou].countrySuffix eq "DE"%>selected<%/if%><%/if%>><%$tpl_countries[cou].countryName%></option>
                <%/section%>
                        </select></td>
               <td><strong>eMail</strong></td>
               <td><input name="frm_business_email" type="text" id="frm_business_email" size="30" value="<%$tpl_gast.businessAddress.email%>"></td>
             </tr>
             <tr>
				<td colspan="2">&nbsp;</td>
				<td><strong>Homepage</strong></td>
				<td><input type="text" name="frm_business_homepage" id="frm_business_homepage" size="30" value="<%$tpl_gast.businessAddress.homepage%>"></td>
             </tr>
			</table>

    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
</div>
<div id="add_other" name="add_other" style="visibility:visible">
<input type="hidden" name="frm_other_addressid" id="frm_other_addressid" value="<%if $tpl_gast.otherAddress.addressid neq ""%><%$tpl_gast.otherAddress.addressid%><%else%>0<%/if%>">
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
   <td class="White">&nbsp;</td>
   <td align="right" class="White">
       <table border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td class="NavInactive"><a href="javascript:switchLayer('add_private');" class="NavInactive" onClick="bypassCheck()">privat</a></td>
           <td class="NavInactive"><a href="javascript:switchLayer('add_business');" class="NavInactive" onClick="bypassCheck()">gesch&auml;ftlich</a></td>
           <td class="NavActive"><a href="javascript:switchLayer('add_other');" class="NavActive" onClick="bypassCheck()">andere</a></td>
   	 	 </tr>
       </table>
   </td>
   <td class="White">&nbsp;</td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
      <p class="SubheadlineYellow">weitere Addresse</p>
			<input type="radio" name="frm_default_address" id="frm_default_address" value="other"  <%if $tpl_gast.otherAddress.defaultaddress eq "1"%>checked="checked"<%/if%>> Postanschrift
			&nbsp;&nbsp;
			<%if $tpl_gast.otherAddress.count gt 1%><input type="checkbox" name="frm_other_copy" id="frm_other_copy" value="true"> Addresse nicht mehr teilen<%/if%>
      		<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td  rowspan="2" valign="top"><strong>Stra&szlig;e</strong></td>
               <td rowspan="2"><textarea name="frm_other_address" id="frm_other_address" cols="50" rows="3"><%$tpl_gast.otherAddress.address%></textarea></td>
               <td><strong>Telefon</strong></td>
               <td><input name="frm_other_phone" type="text" id="frm_other_phone" size="30" value="<%$tpl_gast.otherAddress.phone%>"></td>
             </tr>
             <tr>
               <td><strong>FAX</strong></td>
               <td><input name="frm_other_fax" type="text" id="frm_other_fax" size="30" value="<%$tpl_gast.otherAddress.fax%>"></td>
             </tr>
             <tr>
				<td colspan="2">
             <table border="0" cellpadding="4" cellspacing="0">
                <tr>
	               <td><strong>LKZ</strong></td>
	               <td><input name="frm_other_region" type="text" id="frm_other_region" size="10" value="<%$tpl_gast.otherAddress.region%>"></td>
	               <td><strong>PLZ</strong></td>
	               <td><input name="frm_other_postalcode" type="text" id="frm_other_postalcode" size="10" value="<%$tpl_gast.otherAddress.postalcode%>"></td>
 	               <td><strong>Ort</strong></td>
	               <td><input name="frm_other_city" type="text" id="frm_other_city" size="30" value="<%$tpl_gast.otherAddress.city%>"></td>
                </tr>
               </table>
				</td>
				<td><strong>Handy</strong></td>
               <td><input name="frm_other_mobile" type="text" id="frm_other_mobile" size="30" value="<%$tpl_gast.otherAddress.mobile%>"></td>
             </tr>
             <tr>
             	<td><strong>Land</strong></td>
	            <td><select id="frm_other_country" name="frm_other_country">
                <%section name=cou loop=$tpl_countries%>
                        <option value="<%$tpl_countries[cou].countrySuffix%>" <%if $tpl_gast.otherAddress.country_id neq ""%><%if $tpl_countries[cou].countrySuffix eq $tpl_gast.otherAddress.country_id%>selected<%/if%><%else%><%if $tpl_countries[cou].countrySuffix eq "DE"%>selected<%/if%><%/if%>><%$tpl_countries[cou].countryName%></option>
                <%/section%>
                        </select></td>
               <td><strong>eMail</strong></td>
               <td><input name="frm_other_email" type="text" id="frm_other_email" size="30" value="<%$tpl_gast.otherAddress.email%>"></td>
             </tr>
             <tr>
				<td colspan="2">&nbsp;</td>
				<td><strong>Homepage</strong></td>
				<td><input type="text" name="frm_other_homepage" id="frm_other_homepage" size="30" value="<%$tpl_gast.otherAddress.homepage%>"></td>
             </tr>
			</table>

    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
</div>
</form>

<%include file=footer.tpl%>
<%/strip%>

