<%include file=header.tpl%>
<DIV ID="dek"></DIV>
<%/strip%>

<script type="text/javascript" language="Javascript">
<!--

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
              <%section name=cat loop=$tpl_cat%>
               <tr>
                 <td><%if $tpl_cat[cat].description neq ""%><a ONMOUSEOVER=" popup('<%$tpl_cat[cat].description|strip%>','<%$wwwroot%>');" ONMOUSEOUT="kill()"><%/if%><%$tpl_cat[cat].cat%><%if $tpl_cat[cat].description neq ""%></a><%/if%><td>
               <tr>
              <%/section%>
             <tr>
               <td align="right"><a href="<%$wwwroot%>editcat.php/guestid.<%$tpl_gast.guestid%>"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a></td>
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

