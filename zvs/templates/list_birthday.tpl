<%strip%>
<%include file=header.tpl%>
<form name="select" id="select" action="<%$SCRIPT_NAME%>" method="post">
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Geburtstagsliste &nbsp;&nbsp;</p>
		Monat: 
		<select name="frm_month" id="frm_month" onchange="document.select.submit();">
			<option value="01" <%if $tpl_month eq "01"%>selected=selected<%/if%>>Januar</option>
			<option value="02" <%if $tpl_month eq "02"%>selected=selected<%/if%>>Februar</option>
			<option value="03" <%if $tpl_month eq "03"%>selected=selected<%/if%>>M&auml;rz</option>
			<option value="04" <%if $tpl_month eq "04"%>selected=selected<%/if%>>April</option>
			<option value="05" <%if $tpl_month eq "05"%>selected=selected<%/if%>>Mai</option>
			<option value="06" <%if $tpl_month eq "06"%>selected=selected<%/if%>>Juni</option>
			<option value="07" <%if $tpl_month eq "07"%>selected=selected<%/if%>>Juli</option>
			<option value="08" <%if $tpl_month eq "08"%>selected=selected<%/if%>>August</option>
			<option value="09" <%if $tpl_month eq "09"%>selected=selected<%/if%>>September</option>
			<option value="10" <%if $tpl_month eq "10"%>selected=selected<%/if%>>Oktober</option>
			<option value="11" <%if $tpl_month eq "11"%>selected=selected<%/if%>>November</option>
			<option value="12" <%if $tpl_month eq "12"%>selected=selected<%/if%>>Dezember</option>
		</select>
		<br><br>
    	<table border="0" cellspacing="0" cellpadding="3">
			<tr>
			    <td class="ListL1Header">&nbsp;</td>
				<td class="ListL1Header"><b>Datum</b></td>
			    <td class="ListL1Header"><b>Name</b></td>				
				<td class="ListL1Header"><b>Alter</b></td>
			</tr>
			<%section name=guest loop=$tpl_guests%>
			<tr>
				<td class="ListL<%$tpl_guests[guest].color%>" valign="top">
					<a href="<%$wwwroot%>showgast.php/guestid.<%$tpl_guests[guest].guestid%>"><img src="<%$wwwroot%>img/icon_show.gif" width="16" height="16" border="0" alt="Anzeigen"></a>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>" valign="top">
					  <%$tpl_guests[guest].birthday%>
				</td>			
				<td class="ListL<%$tpl_guests[guest].color%>" valign="top">
					  <%$tpl_guests[guest].lastname%>, <%$tpl_guests[guest].firstname%>
				</td>		
				<td class="ListL<%$tpl_guests[guest].color%>" valign="top">
					  <%$tpl_guests[guest].age%>
				</td>						
			</tr>
			<%sectionelse%>
			<tr>
			    <td colspan="4">keine Eintr&auml;ge</td>
			</tr>
			<%/section%>
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

<%include file=footer.tpl%>
<%/strip%>
