<%strip%>
<%include file=header.tpl%>
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
				<td colspan="2" align="right"><a href="<%$wwwroot%>exportvcard.php/guestid.<%$tpl_gast.guestid%>/lastname.<%$tpl_gast.lastname%>/firstname.<%$tpl_gast.firstname%>"><img src="<%$wwwroot%>img/vcard.png" border="0" width="26" height="20" alt="VCard exportieren"></a></td>
			</tr>
			<%/if%>		
			<tr>
				<td class="SubheadlineYellow"><%if $tpl_gast.lastname neq ""%><%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></td>
				<td align="right"><a href="<%$wwwroot%>editgast.php/guestid.<%$tpl_gast.guestid%>"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a></td>
			</tr>		
		</table>
			<table width="100%" border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td><strong>Anrede</strong></td>
               <td><%$tpl_gast.salutation_title%></td>
               <td><strong>Titel</strong></td>
               <td><%$tpl_gast.academic_title%></td>
               <td><strong>Geschlecht</strong></td>
               <td><%if $tpl_gast.gender eq "M"%>m<%elseif $tpl_gast.gender eq "F"%>w<%/if%></td>
             </tr>
             <tr>
               <td><strong>Vorname</strong></td>
               <td><%$tpl_gast.firstname%></td>
               <td><strong>Nachname</strong></td>
               <td><%$tpl_gast.lastname%></td>
               <td><strong>Sprache</strong></td>
               <td><%if $tpl_gast.language_id eq "2"%>D<%elseif $tpl_gast.language_id eq "3"%>E<%elseif $tpl_gast.language_id eq "4"%>I<%/if%></td>
             </tr>
             <tr>
               <td><strong>Beruf</strong></td>
               <td><%$tpl_gast.job%></td>
               <td><strong>Firma</strong></td>
               <td><%$tpl_gast.company%></td>
               <td><strong>Du/Sie</strong></td>
               <td><%if $tpl_gast.formal_greeting eq "N"%>Du<%elseif $tpl_gast.formal_greeting eq "Y"%>Sie<%/if%></td>
             </tr>
             <tr>
               <td><strong>Geburtsdatum</strong></td>
               <td><%if $tpl_gast.date_of_birth neq "00.00.0000"%><%$tpl_gast.date_of_birth%> &nbsp;&nbsp;<input type="checkbox" name="frm_reminder" id="reminder" value="Y" <%if $tpl_gast.reminder eq "Y"%>checked="checked"<%/if%> disabled="disabled"> erinnern<%/if%></td>
			   <td><strong>Geburtsort</strong></td>
				<td><%$tpl_gast.birthplace%></td>
				<td colspan="2"></td>
				</tr>
			  <tr>
				<td><strong>Staatsangeh&ouml;rigkeit</strong></td>
				<td><%$tpl_gast.nationality_name%></td>
				<td colspan="4"></td>
			  </tr>		
			  <tr>
				<td><strong>Ausweisdokument</strong></td>
				<td><%if $tpl_gast.identification eq "P"%>Personalausweis<%elseif $tpl_gast.identification eq "R"%>Reisepass<%elseif $tpl_gast.identification eq "F"%>F&uuml;hrerschein<%/if%></td>
				<td><strong>Ausweis-Nummer</strong></td>
			    <td><%$tpl_gast.passport%></td>
				<td colspan="2">&nbsp;</td>
			 </tr>			  		
				<tr>
 	<td><strong>Ausstellungsbeh&ouml;rde</strong></td>
	<td><%$tpl_gast.agency%></td>
	<td><strong>Ausstellungsdatum</strong></td>
	<td><%$tpl_gast.issue_date%></td>

               <td colspan="2"><input type="checkbox" name="frm_status" id="frm_status" value="Y" <%if $tpl_gast.status eq "Y"%>checked<%/if%> disabled="disabled"> <strong>Stammgast</strong></td>
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
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
   <td class="White">&nbsp;</td>
   <td align="right" class="White">
       <table border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td class="NavInactive"><a href="javascript:switchLayer('add_private');" class="NavInactive">privat</a></td>
           <td class="NavInactive"><a href="javascript:switchLayer('add_business');" class="NavInactive">gesch&auml;ftlich</a></td>
           <td class="NavInactive"><a href="javascript:switchLayer('add_other');" class="NavInactive">andere</a></td>
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
			<input type="checkbox" <%if $tpl_gast.privateAddress.defaultaddress eq "1" or $tpl_gast.guestid eq ""%>checked="checked"<%/if%> disabled="disabled"> Postanschrift
      		<table width="100%" border="0" cellpadding="4" cellspacing="0">
			     <colgroup>
        			<col width="25%">
        			<col width="5%">
        			<col width="25%">
					<col width="45%">
     			</colgroup>			
             <tr>
               <td colspan="2" valign="top"><strong>Stra&szlig;e</strong></td>
               <td align="right"><strong>Telefon</strong></td>
               <td><%$tpl_gast.privateAddress.phone%></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><%$tpl_gast.privateAddress.address|nl2br%></td>
               <td align="right"><strong>FAX</strong></td>
               <td><%$tpl_gast.privateAddress.fax%></td>
             </tr>
             <tr>
				<td colspan="2">
             <table border="0" cellpadding="4" cellspacing="0">
                <tr>
	               <td><strong>LKZ</strong></td>
	               <td><%$tpl_gast.privateAddress.region%></td>
	               <td><strong>PLZ</strong></td>
	               <td><%$tpl_gast.privateAddress.postalcode%></td>
 	               <td><strong>Ort</strong></td>
	               <td><%$tpl_gast.privateAddress.city%></td>
                </tr>
               </table>
				</td>
				<td align="right"><strong>Handy</strong></td>
               <td><%$tpl_gast.privateAddress.mobile%></td>
             </tr>
             <tr>
             	<td><strong>Land</strong></td>
	            <td>&nbsp;</td>
               <td align="right"><strong>eMail</strong></td>
               <td><%if $tpl_gast.privateAddress.email neq ""%><a href="mailto:<%$tpl_gast.privateAddress.email%>"><%$tpl_gast.privateAddress.email%></a><%else%>&nbsp;<%/if%></td>
             </tr>
             <tr>
             	<td><%$tpl_gast.privateAddress.country_Name%></td>
				<td>&nbsp;</td>
				<td align="right"><strong>Homepage</strong></td>
				<td><%$tpl_gast.privateAddress.homepage%></td>
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
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
   <td class="White">&nbsp;</td>
   <td align="right" class="White">
       <table border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td class="NavInactive"><a href="javascript:switchLayer('add_private');" class="NavInactive">privat</a></td>
           <td class="NavInactive"><a href="javascript:switchLayer('add_business');" class="NavInactive">gesch&auml;ftlich</a></td>
           <td class="NavInactive"><a href="javascript:switchLayer('add_other');" class="NavInactive">andere</a></td>
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
			<input type="checkbox" <%if $tpl_gast.businessAddress.defaultaddress eq "1" or $tpl_gast.guestid eq ""%>checked="checked"<%/if%> disabled="disabled"> Postanschrift
      		<table width="100%" border="0" cellpadding="4" cellspacing="0">
			     <colgroup>
        			<col width="25%">
        			<col width="5%">
        			<col width="25%">
					<col width="45%">
     			</colgroup>		

             <tr>
               <td colspan="2" valign="top"><strong>Stra&szlig;e</strong></td>
               <td align="right"><strong>Telefon</strong></td>
               <td><%$tpl_gast.businessAddress.phone%></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><%$tpl_gast.businessAddress.address|nl2br%></td>
               <td align="right"><strong>FAX</strong></td>
               <td><%$tpl_gast.businessAddress.fax%></td>
             </tr>
             <tr>
				<td colspan="2">
             <table border="0" cellpadding="4" cellspacing="0">
                <tr>
	               <td><strong>LKZ</strong></td>
	               <td><%$tpl_gast.businessAddress.region%></td>
	               <td><strong>PLZ</strong></td>
	               <td><%$tpl_gast.businessAddress.postalcode%></td>
 	               <td><strong>Ort</strong></td>
	               <td><%$tpl_gast.businessAddress.city%></td>
                </tr>
               </table>
				</td>
				<td align="right"><strong>Handy</strong></td>
               <td><%$tpl_gast.businessAddress.mobile%></td>
             </tr>
             <tr>
             	<td><strong>Land</strong></td>
	            <td>&nbsp;</td>
               <td align="right"><strong>eMail</strong></td>
               <td><%if $tpl_gast.businessAddress.email neq ""%><a href="mailto:<%$tpl_gast.businessAddress.email%>"><%$tpl_gast.businessAddress.email%></a><%else%>&nbsp;<%/if%></td>
             </tr>
             <tr>
             	<td><%$tpl_gast.businessAddress.country_Name%></td>
				<td>&nbsp;</td>
				<td align="right"><strong>Homepage</strong></td>
				<td><%$tpl_gast.businessAddress.homepage%></td>
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
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
   <td class="White">&nbsp;</td>
   <td align="right" class="White">
       <table border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td class="NavInactive"><a href="javascript:switchLayer('add_private');" class="NavInactive">privat</a></td>
           <td class="NavInactive"><a href="javascript:switchLayer('add_business');" class="NavInactive">gesch&auml;ftlich</a></td>
           <td class="NavInactive"><a href="javascript:switchLayer('add_other');" class="NavInactive">andere</a></td>
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
			<input type="checkbox" <%if $tpl_gast.otherAddress.otherAddress eq "1" or $tpl_gast.guestid eq ""%>checked="checked"<%/if%> disabled="disabled"> Postanschrift
      		<table width="100%" border="0" cellpadding="4" cellspacing="0">
			     <colgroup>
        			<col width="25%">
        			<col width="5%">
        			<col width="25%">
					<col width="45%">
     			</colgroup>				
             <tr>
               <td colspan="2" valign="top"><strong>Stra&szlig;e</strong></td>
               <td align="right"><strong>Telefon</strong></td>
               <td><%$tpl_gast.otherAddress.phone%></td>
             </tr>
             <tr>
               <td colspan="2" valign="top"><%$tpl_gast.otherAddress.address|nl2br%></td>
               <td align="right"><strong>FAX</strong></td>
               <td><%$tpl_gast.otherAddress.fax%></td>
             </tr>
             <tr>
				<td colspan="2">
             <table border="0" cellpadding="4" cellspacing="0">
                <tr>
	               <td><strong>LKZ</strong></td>
	               <td><%$tpl_gast.otherAddress.region%></td>
	               <td><strong>PLZ</strong></td>
	               <td><%$tpl_gast.otherAddress.postalcode%></td>
 	               <td><strong>Ort</strong></td>
	               <td><%$tpl_gast.otherAddress.city%></td>
                </tr>
               </table>
				</td>
				<td align="right"><strong>Handy</strong></td>
               <td><%$tpl_gast.otherAddress.mobile%></td>
             </tr>
             <tr>
             	<td><strong>Land</strong></td>
	            <td>&nbsp;</td>
               <td align="right"><strong>eMail</strong></td>
               <td><%if $tpl_gast.otherAddress.email neq ""%><a href="mailto:<%$tpl_gast.otherAddress.email%>"><%$tpl_gast.otherAddress.email%></a><%else%>&nbsp;<%/if%></td>
             </tr>
             <tr>
             	<td><%$tpl_gast.otherAddress.country_Name%></td>
				<td>&nbsp;</td>
				<td align="right"><strong>Homepage</strong></td>
				<td><%$tpl_gast.otherAddress.homepage%></td>
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


<%include file=footer.tpl%>
<%/strip%>

