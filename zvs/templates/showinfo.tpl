<%strip%>
<%include file=header.tpl%>

<table width="500" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
      <p class="SubheadlineYellow">Notizen <%if $tpl_gast.nachname neq ""%>zu: <%$tpl_gast.nachname%>, <%$tpl_gast.vorname%><%/if%></p>
			<table border="0" cellpadding="4" cellspacing="0">
			  <tr>
			    <td width="500">
                   <%$tpl_gast.additional_info|nl2br%>
                </td>
              </tr>
              <tr>
                <td align="right">
                <a href="<%$wwwroot%>editinfo.php/guestid.<%$tpl_gast.guestid%>"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
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

<%include file=footer.tpl%>
<%/strip%>

