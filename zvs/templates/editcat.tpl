<%strip%>
<%include file=header.tpl%>

<DIV ID="dek"></DIV>
<%/strip%>

<script type="text/javascript" language="Javascript">
<!--
function add(catid)
{
  document.save.frm_changeAction.value='add';
  document.save.frm_catid.value = catid;
  document.save.submit();
}

function del(catid)
{
  document.save.frm_changeAction.value='del';
  document.save.frm_catid.value = catid;
  document.save.submit();
}

function save()
{
  document.save.frm_changeAction.value='save';
  document.save.submit();
}

	var offsetxpoint=-60; //Customize x offset of tooltip
	var offsetypoint=20; //Customize y offset of tooltip
	var ie=document.all;
	var ns6=document.getElementById && !document.all;
	var enabletip=false;
	if (ie||ns6)
	var tipobj=document.all? document.all["dek"] : document.getElementById? document.getElementById("dek") : "";
	
	document.onmousemove=positiontip;


//-->
</script>
<%strip%>
<form id="save" name="save" action="<%$SCRIPT_NAME%>" method="post">
<input type="hidden" name="frm_gastid" id="frm_gastid" value="<%if $tpl_gast.guestid neq ""%><%$tpl_gast.guestid%><%else%>0<%/if%>">
<input type="hidden" name="frm_changeAction" id="frm_changeAction" value="">
<input type="hidden" name="frm_catid" id="frm_catid" value="">
<table width="300" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
      <p class="SubheadlineYellow">Kategorie(n) <%if $tpl_gast.nachname neq ""%>von: <%$tpl_gast.nachname%>, <%$tpl_gast.vorname%><%/if%></p>
			<table border="0" cellpadding="4" cellspacing="0">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><strong>Kategorie</strong></td>
              </tr>
              <%section name=cat loop=$tpl_category%>
               <tr>
                 <td><%if $tpl_category[cat].subscribed eq "yes"%><img src="<%$wwwroot%>img/icon_ok.gif" border="0" width="15" height="13"><%else%>&nbsp;<%/if%></td>
                 <td><%if $tpl_category[cat].description neq ""%><a ONMOUSEOVER=" popup('<%$tpl_category[cat].description|strip%>','<%$wwwroot%>');" ONMOUSEOUT="kill()"><%/if%><%$tpl_category[cat].cat%><%if $tpl_category[cat].description neq ""%></a><%/if%><td>
                 <td>
                 <%if $tpl_category[cat].subscribed eq "yes"%>
                   <a href="javascript:del(<%$tpl_category[cat].catid%>);"><img src="<%$wwwroot%>img/shutter_minus.gif" border="0" width="13" height="13"></a>
                 <%else%>
                   <a href="javascript:add(<%$tpl_category[cat].catid%>);"><img src="<%$wwwroot%>img/shutter_plus.gif" border="0" width="13" height="13"></a>
                 <%/if%>
                 </td>
              <tr>
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
<input type="hidden" name="frm_max" value="<%$smarty.section.cat.total%>">
</form>

<%include file=footer.tpl%>
<%/strip%>

