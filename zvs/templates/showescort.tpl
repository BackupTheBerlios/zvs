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
    <p class="SubheadlineYellow">Begleitpersonen von <%if $tpl_gast.firstname neq ""%> <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></p>
     <table boder="0" cellspacing="0" cellpadding="3">
		<tr>
			<td class="ListL1">&nbsp;</td>
			<td class="ListL1">
	  			<strong>Nachname</strong>
	  		</td>
			<td class="ListL1">
	  			<strong>Vorname</strong>
	  		</td>
		</tr>
     <%section name=escort loop=$tpl_escort%>
       <tr>
		 <td class="ListL<%$tpl_escort[escort].color%>"><a href="<%$wwwroot%>showgast.php/guestid.<%$tpl_escort[escort].guestid%>"><img src="<%$wwwroot%>img/icon_show.gif" width="16" height="16" border="0" alt="Anzeigen"></a></td>
         <td class="ListL<%$tpl_escort[escort].color%>"><%$tpl_escort[escort].lastname%></td>
		 <td class="ListL<%$tpl_escort[escort].color%>"><%$tpl_escort[escort].firstname%></td>
       </tr>
     <%sectionelse%>
       <tr>
          <td colspan="3">bisher keine Buchungen mit Begleitpersonen</td>
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

