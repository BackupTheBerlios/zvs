<%strip%>
<%include file=header.tpl%>
<div class="boxdyn">
	<h2><span><%if $tpl_gast.lastname neq ""%><%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></span></h2>
	&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span><%if $tpl_gast.guestid neq ""%><a href="<%$wwwroot%>exportvcard.php/guestid.<%$tpl_gast.guestid%>/lastname.<%$tpl_gast.lastname%>/firstname.<%$tpl_gast.firstname%>" class="dotted">##VCARD_EXPORT##</a> | <%/if%><a href="<%$wwwroot%>editgast.php/guestid.<%$tpl_gast.guestid%>" class="dotted">##EDIT##</a></div>
			<table border="0" cellpadding="2" cellspacing="0" width="750">
             <tr>
               <td><strong>##SALUTATION##</strong></td>
               <td><%$tpl_gast.salutation_title%></td>
               <td><strong>##TITLE##</strong></td>
               <td><%$tpl_gast.academic_title%></td>
               <td><strong>##GENDER##</strong></td>
               <td><%if $tpl_gast.gender eq "M"%>##GENDER_M##<%elseif $tpl_gast.gender eq "F"%>##GENDER_F##<%/if%></td>
             </tr>
             <tr>
               <td><strong>##FIRSTNAME##</strong></td>
               <td><%$tpl_gast.firstname%></td>
               <td><strong>##LASTNAME##</strong></td>
               <td><%$tpl_gast.lastname%></td>
               <td><strong>##LANGUAGE##</strong></td>
               <td><%if $tpl_gast.language_id eq "2"%>##LANGUAGE_D##<%elseif $tpl_gast.language_id eq "3"%>##LANGUAGE_E##<%elseif $tpl_gast.language_id eq "4"%>##LANGUAGE_I##<%/if%></td>
             </tr>
             <tr>
               <td><strong>##JOB##</strong></td>
               <td><%$tpl_gast.job%></td>
               <td><strong>##COMPANY##</strong></td>
               <td><%$tpl_gast.company%></td>
               <td><strong>##FORMAL_GREETING##</strong></td>
               <td><%if $tpl_gast.formal_greeting eq "N"%>##FORMAL_GREETING_NO##<%elseif $tpl_gast.formal_greeting eq "Y"%>##FORMAL_GREETING_YES##<%/if%></td>
             </tr>
             <tr>
               <td><strong>##DATE_OF_BIRTH##</strong></td>
               <td><%if $tpl_gast.date_of_birth neq "00.00.0000"%><%$tpl_gast.date_of_birth%> &nbsp;&nbsp;<input type="checkbox" name="frm_reminder" id="reminder" value="Y" <%if $tpl_gast.reminder eq "Y"%>checked="checked"<%/if%> disabled="disabled"> ##REMINDER##<%/if%></td>
			   <td><strong>##PLACE_OF_BIRTH##</strong></td>
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
				<td><strong>##IDENTITY_CARD_NUMBER##</strong></td>
			    <td><%$tpl_gast.passport%></td>
				<td colspan="2">&nbsp;</td>
			 </tr>			  		
				<tr>
					 	<td><strong>##AGENCY_OF_EXHIBITION##</strong></td>
						<td><%$tpl_gast.agency%></td>
						<td><strong>##DATE_OF_EXHIBITION##</strong></td>
						<td><%$tpl_gast.issue_date%></td>
            <td colspan="2"><input type="checkbox" name="frm_status" id="frm_status" value="Y" <%if $tpl_gast.status eq "Y"%>checked<%/if%> disabled="disabled"> <strong>##REGULAR_GUEST##</strong></td>
        </tr>
        <tr>
				<td colspan="6">
				<%if $tpl_gast.guestid neq ""%>
				<table border="0">
					<tr>
	                <td>##MADE_BY## <%$tpl_gast.inserted_user%>&nbsp;##AT##&nbsp;<%$tpl_gast.inserteddate%></td>
	               <td>&nbsp;</td>
	               <%if $tpl_gast.updated_user neq "" and $tpl_gast.updated_user neq " "%>
	               	<td>##LAST_ACTUALISATION_BY## <%$tpl_gast.updated_user%>&nbsp;##AT##&nbsp;<%$tpl_gast.updated_date%></td>
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
<br>

<div id="add_private" name="add_private" style="visibility:visible">
   &nbsp;<div id="toolbar"><a href="javascript:switchLayer('add_private');" class="dotted">##PRIVATE##</a> | <a href="javascript:switchLayer('add_business');" class="dotted">##BUSINESS##</a> | <a href="javascript:switchLayer('add_other');" class="dotted">##OTHER##</a></div>
      <h3>##PRIVAT_ADRESS##</h3>
			<input type="checkbox" <%if $tpl_gast.privateAddress.defaultaddress eq "1" or $tpl_gast.guestid eq ""%>checked="checked"<%/if%> disabled="disabled"> ##POSTAL_ADRESS##
      		<table border="0" cellpadding="2" cellspacing="0" width="750">
			     <colgroup>
        			<col width="25%">
        			<col width="5%">
        			<col width="25%">
					<col width="45%">
     			</colgroup>			
             <tr>
               <td colspan="2" valign="top"><strong>##STREET##</strong></td>
               <td align="right"><strong>##PHONE##</strong></td>
               <td><%$tpl_gast.privateAddress.phone%></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><%$tpl_gast.privateAddress.address|nl2br%></td>
               <td align="right"><strong>##FAX##</strong></td>
               <td><%$tpl_gast.privateAddress.fax%></td>
             </tr>
             <tr>
				<td colspan="2">
             <table border="0" cellpadding="4" cellspacing="0">
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
             	<td><%$tpl_gast.privateAddress.country_Name%></td>
				<td>&nbsp;</td>
				<td align="right"><strong>##HOMEPAGE##</strong></td>
				<td><%$tpl_gast.privateAddress.homepage%></td>
             </tr>
			</table>
</div>
<div id="add_business" name="add_business" style="visibility:visible">
		&nbsp;<div id="toolbar"><a href="javascript:switchLayer('add_private');" class="dotted">##PRIVATE##</a> | <a href="javascript:switchLayer('add_business');" class="dotted">##BUSINESS##</a> | <a href="javascript:switchLayer('add_other');" class="dotted">##OTHER##</a></div>      
		<h3>##BUSINESS_ADRESS##</h3>
			<input type="checkbox" <%if $tpl_gast.businessAddress.defaultaddress eq "1" or $tpl_gast.guestid eq ""%>checked="checked"<%/if%> disabled="disabled"> Postanschrift
      		<table border="0" cellpadding="2" cellspacing="0" width="750">
			     <colgroup>
        			<col width="25%">
        			<col width="5%">
        			<col width="25%">
					<col width="45%">
     			</colgroup>		

             <tr>
               <td colspan="2" valign="top"><strong>##STREET##</strong></td>
               <td align="right"><strong>##PHONE##</strong></td>
               <td><%$tpl_gast.businessAddress.phone%></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><%$tpl_gast.businessAddress.address|nl2br%></td>
               <td align="right"><strong>##FAX##</strong></td>
               <td><%$tpl_gast.businessAddress.fax%></td>
             </tr>
             <tr>
				<td colspan="2">
             <table border="0" cellpadding="4" cellspacing="0">
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
             	<td><%$tpl_gast.businessAddress.country_Name%></td>
				<td>&nbsp;</td>
				<td align="right"><strong>##HOMEPAGE##</strong></td>
				<td><%$tpl_gast.businessAddress.homepage%></td>
             </tr>
			</table>
</div>
<div id="add_other" name="add_other" style="visibility:visible">
&nbsp;<div id="toolbar"><a href="javascript:switchLayer('add_private');" class="dotted">##PRIVATE##</a> | <a href="javascript:switchLayer('add_business');" class="dotted">##BUSINESS##</a> | <a href="javascript:switchLayer('add_other');" class="dotted">##OTHER##</a></div>      
			<h3>##ANOTHER_ADRESS##</h3>
			<input type="checkbox" <%if $tpl_gast.otherAddress.otherAddress eq "1" or $tpl_gast.guestid eq ""%>checked="checked"<%/if%> disabled="disabled"> Postanschrift
      		<table border="0" cellpadding="2" cellspacing="0" width="750">
			     <colgroup>
        			<col width="25%">
        			<col width="5%">
        			<col width="25%">
					<col width="45%">
     			</colgroup>				
             <tr>
               <td colspan="2" valign="top"><strong>##STREET##</strong></td>
               <td align="right"><strong>##PHONE##</strong></td>
               <td><%$tpl_gast.otherAddress.phone%></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><%$tpl_gast.otherAddress.address|nl2br%></td>
               <td align="right"><strong>##FAX##</strong></td>
               <td><%$tpl_gast.otherAddress.fax%></td>
             </tr>
             <tr>
				<td colspan="2">
             <table border="0" cellpadding="4" cellspacing="0">
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
             	<td><%$tpl_gast.otherAddress.country_Name%></td>
				<td>&nbsp;</td>
				<td align="right"><strong>##HOMEPAGE##</strong></td>
				<td><%$tpl_gast.otherAddress.homepage%></td>
             </tr>
			</table>
</div>
</div>

<%include file=footer.tpl%>
<%/strip%>

