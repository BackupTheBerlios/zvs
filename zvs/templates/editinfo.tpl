<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script type="text/javascript" language="Javascript">
<!--
function save()
{
  document.save.submit();
}
//-->
</script>
<%strip%>
<form id="save" name="save" action="<%$SCRIPT_NAME%>" method="post">
<input type="hidden" name="frm_guestid" id="frm_guestid" value="<%if $tpl_gast.guestid neq ""%><%$tpl_gast.guestid%><%else%>0<%/if%>">
<table width="300" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
      <p class="SubheadlineYellow">##NOTICE## <%if $tpl_gast.lastname neq ""%>zu: <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></p>
			<table border="0" cellpadding="4" cellspacing="0">
			  <tr>
			    <td>
                   <textarea name="frm_info" id="frm_info" cols="100" rows="20"><%$tpl_gast.additional_info%></textarea>
                </td>
              </tr>
              <tr>
                <td align="right">
                <a href="javascript:document.save.submit();" onClick="unsetaltered();"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
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

</form>

<%include file=footer.tpl%>
<%/strip%>

