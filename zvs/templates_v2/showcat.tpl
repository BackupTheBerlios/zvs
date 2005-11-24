<%include file=header.tpl%>
<div id="dek"></div>

<script type="text/javascript" language="Javascript">
<!--

	var offsetxpoint=10; //Customize x offset of tooltip
	var offsetypoint=100; //Customize y offset of tooltip
	var ie=document.all;
	var ns6=document.getElementById && !document.all;
	var enabletip=false;
	if (ie||ns6)
	var tipobj=document.all? document.all["dek"] : document.getElementById? document.getElementById("dek") : "";
	
	document.onmousemove=positiontip;

//-->
</script>
<%strip%>
<div class="boxdyn">
	<h2><span>##CATEGORY_PLURAL## <%if $tpl_gast.guestid neq ""%>##FROM##: <%$tpl_gast.lastname%>, <%$tpl_gast.firstname%><%/if%></span></h2>
	<%if $tpl_gast.guestid neq ""%>&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span><a href="<%$wwwroot%>editcat.php/guestid.<%$tpl_gast.guestid%>" class="dotted">##EDIT##</a></div><%/if%>
   <table boder="0" cellspacing="0" cellpadding="3">
		<tr class="ListHeader">
			<th>##CATEGORY##</th>
		</tr>
     <%section name=cat loop=$tpl_cat%>
      <tr class="ListL<%$tpl_cat[cat].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_cat[cat].color%>'">
          <td><%if $tpl_cat[cat].description neq ""%><a ONMOUSEOVER=" popup('<%$tpl_cat[cat].description|strip%>','<%$wwwroot%>');" ONMOUSEOUT="kill()"><%/if%><%$tpl_cat[cat].cat%><%if $tpl_cat[cat].description neq ""%></a><%/if%><td>
     <tr>
     <%/section%>
   </table>
</div>
<%include file=footer.tpl%>
<%/strip%>

