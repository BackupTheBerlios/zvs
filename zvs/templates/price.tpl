<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript">
<!--
var isIE, isDOM;
isIE = (document.all ? true : false);
isDOM = (document.getElementById ? true : false);


function switchLayer(layername)
{
	if (isIE)
	{
		<%section name="season" loop="$tpl_seasons"%>
			element<%$tpl_seasons[season].seasonid%> = document.all.L<%$tpl_seasons[season].seasonid%>;		
		<%/section%>
		myelement = eval('document.all.'+layername);
	} else {
		<%section name="season" loop="$tpl_seasons"%>
			element<%$tpl_seasons[season].seasonid%> = document.getElementById("L<%$tpl_seasons[season].seasonid%>");	
		<%/section%>
		myelement = document.getElementById(layername);
	}	
	<%section name="season" loop="$tpl_seasons"%>
		element<%$tpl_seasons[season].seasonid%>.style.display = 'none';
	<%/section%>
	myelement.style.display = '';
	document.seasoncopy.frm_theseason.value=layername;
	document.save.frm_theseason.value=layername;
	checkUnload = true;
}

//-->
</script>
<%strip%>
<table width="600" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    
	    <form id="season" name="season" action="<%$SCRIPT_NAME%>" method="post">
		<table border="0" width="100%">
			<tr>
				<td class="SubheadlineYellow">Zimmerpreise verwalten</td>	
				<td align="right"><a href="javascript:document.save.submit();" onClick="unsetaltered();"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a></td>				
			</tr>
			<tr>
				<td colspan="2"  class="SubheadlineYellow">Jahr: 
			<select name="frm_theyear" id="frm_theyear" onchange="document.season.submit();">
				<%section name=year loop=$tpl_years%>
				<option value="<%$tpl_years[year]%>" <%if $tpl_theyear eq $tpl_years[year]%>selected<%/if%>><%$tpl_years[year]%></option>
				<%/section%>
			</select></td>
			</tr>
		</table>
		</form>		
		<br>
    <form id="seasoncopy" name="seasoncopy" action="<%$SCRIPT_NAME%>" method="post">
	<input type="hidden" name="frm_theyear" id="frm_theyear" value="<%$tpl_theyear%>">
	<input type="hidden" name="frm_theseason" id="frm_theseason" value="L<%$tpl_seasons[0].seasonid%>">
		<table border="0" width="100%">
			<tr>
				<td colspan="2"  class="SubheadlineYellow">Preise kopieren von: 
		<select name="frm_copy" id="frm_copy" onchange="document.seasoncopy.submit();">
				<option value="-1">Saison ausw&auml;hlen</option>
			<%section name="season" loop="$tpl_allseasons"%>
				<option value="<%$tpl_allseasons[season].seasonid%>"><%$tpl_allseasons[season].name%></option>
			<%/section%>
		</select>	</td>
			</tr>
		</table>
		</form>				
	
		<form id="save" name="save" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_theseason" id="frm_theseason" value="L<%$tpl_seasons[0].seasonid%>">
		<input type="hidden" name="frm_theyear" id="frm_theyear" value="<%$tpl_theyear%>">
		<input type="hidden" name="frm_action" id="frm_action" value="save">
			<%section name="season" loop="$tpl_seasons"%>
			<%assign var="seasonid" value="`$tpl_seasons[season].seasonid`"%>
				<div id="L<%$tpl_seasons[season].seasonid%>" name="L<%$tpl_seasons[season].seasonid%>" style="visibility:visible">
					
					<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
					  <tr>
					   <td>&nbsp;</td>
					   <td align="right">
					       <table border="0" cellspacing="0" cellpadding="0">
					         <tr>
							 <%section name="season2" loop="$tpl_seasons"%>
					           <td class="<%if $tpl_seasons[season].seasonid eq $tpl_seasons[season2].seasonid%>NavActive<%else%>NavInactive<%/if%>"><a href="javascript:switchLayer('L<%$tpl_seasons[season2].seasonid%>');" class="<%if $tpl_seasons[season].seasonid eq $tpl_seasons[season2].seasonid%>NavActive<%else%>NavInactive<%/if%>" onClick="bypassCheck()"><%$tpl_seasons[season2].name%></a></td>
							 <%/section%>
					   	 	 </tr>
					       </table>
					   </td>
					   <td>&nbsp;</td>
					  </tr>
					  <tr>
					    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
					    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
					    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
					  </tr>
					  <tr>
					    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
					    <td width="100%">
					      <p class="SubheadlineYellow"><%$tpl_seasons[season].name%></p>
						  <input type="hidden" name="frm_seasonid[]" id="frm_seasonid[]" value="<%$tpl_seasons[season].seasonid%>">
			<table  border="0" cellspacing="0" cellpadding="3">
		<%section name="bcat" loop="$tpl_bcat"%>
		<%assign var="bcatid" value="`$tpl_bcat[bcat].bcatid`"%>
			<tr>
				<td class="White" colspan="11"><strong><%$tpl_bcat[bcat].name%>&nbsp;(<%$tpl_bcat[bcat].days%>&nbsp;Tag<%if $tpl_bcat[bcat].days gt 1%>e<%/if%>)</strong></td>
<!--					<td class="ListL1" rowspan="2"><strong>Pro Person</strong></td>
				<td class="ListL1" rowspan="2"><strong>Pauschal</strong></td> //-->
			</tr>
			<tr>
				<td class="ListL1">&nbsp;</td>
				<td class="ListL1"><strong>Erwachsene</strong><br>regul&auml;r</td>
				<td class="ListL1"><strong>Erwachsene</strong><br>kurz</td>
				<td class="ListL1"><strong><%$tpl_children1%></strong><br>regul&auml;r</td>
				<td class="ListL1"><strong><%$tpl_children1%></strong><br>kurz</td>
				<td class="ListL1"><strong><%$tpl_children2%></strong><br>regul&auml;r</td>
				<td class="ListL1"><strong><%$tpl_children2%></strong><br>kurz</td>
				<td class="ListL1"><strong><%$tpl_children3%></strong><br>regul&auml;r</td>
				<td class="ListL1"><strong><%$tpl_children3%></strong><br>kurz</td>								
<!--
				<td class="ListL1"><strong>Pauschal</strong><br>regul&auml;r</td>
				<td class="ListL1"><strong>Pauschal</strong><br>kurz</td>
//-->
			</tr>			
			<%section name="rcat" loop=$tpl_rcat"%>
			<%assign var="rcatid" value="`$tpl_rcat[rcat].catid`"%>
			<tr>
				<td class="ListL<%$tpl_rcat[rcat].color%>"><strong><%$tpl_rcat[rcat].name%></strong></td>
					<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_price_adult_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_adult_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].person%>"></td>
					<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_price_adult_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_adult_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].person_short%>"></td>
					<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_price_child_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children%>"></td>
					<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_price_child_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children_short%>"></td>
					<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_price_child2_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child2_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children2%>"></td>
					<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_price_child2_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child2_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children2_short%>"></td>
					<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_price_child3_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child3_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children3%>"></td>
					<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_price_child3_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child3_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children3_short%>"></td>
<!--
					<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_price_pausch_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_pausch_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].absolute%>"></td>
					<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_price_pausch_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_pausch_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].absolute_short%>"></td>
				<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_type_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_type_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="radio" value="PP" <%if $tpl_prices[$seasonid][$rcatid][$bcatid].type eq "PP"%>checked<%/if%>></td>
				<td class="ListL<%$tpl_rcat[rcat].color%>"><input name="frm_type_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_type_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="radio" value="PR" <%if $tpl_prices[$seasonid][$rcatid][$bcatid].type eq "PR"%>checked<%/if%>></td>				
//-->
			</tr>
			<%/section%>
			<%/section%>
			</table>						

<br><br>
			<table  border="0" cellspacing="0" cellpadding="3">
		<%section name="bcat" loop="$tpl_bcat"%>
		<%assign var="bcatid" value="`$tpl_bcat[bcat].bcatid`"%>
			<tr>
				<td class="White" colspan="11"><strong><%$tpl_bcat[bcat].name%>&nbsp;(<%$tpl_bcat[bcat].days%>&nbsp;Tag<%if $tpl_bcat[bcat].days gt 1%>e<%/if%>)</strong></td>
<!--					<td class="ListL1" rowspan="2"><strong>Pro Person</strong></td>
				<td class="ListL1" rowspan="2"><strong>Pauschal</strong></td> //-->
			</tr>
			<tr>
				<td class="ListL1">&nbsp;</td>
				<td class="ListL1"><strong>Grundpreis</strong><br>regul&auml;r</td>
				<td class="ListL1"><strong>Grundpreis</strong><br>kurz</td>
				<td class="ListL1"><strong>enthaltene<br>Personen</strong></td>
				<td class="ListL1"><strong>Aufpreis</strong><br>regul&auml;r</td>
				<td class="ListL1"><strong>Aufpreis</strong><br>kurz</td>
			</tr>			
			<%section name="rcat" loop=$tpl_rcat2"%>
			<%assign var="rcatid" value="`$tpl_rcat2[rcat].catid`"%>
			<tr>
				<td class="ListL<%$tpl_rcat2[rcat].color%>"><strong><%$tpl_rcat2[rcat].name%></strong></td>
				<td class="ListL<%$tpl_rcat2[rcat].color%>"><input name="frm_price_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" id="frm_price_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" type="text" size="4" value="<%$tpl_prices2[$seasonid][$rcatid][$bcatid].price%>"></td>
				<td class="ListL<%$tpl_rcat2[rcat].color%>"><input name="frm_price_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" id="frm_price_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" type="text" size="4" value="<%$tpl_prices2[$seasonid][$rcatid][$bcatid].price_short%>"></td>
				<td class="ListL<%$tpl_rcat2[rcat].color%>"><input name="frm_person_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" id="frm_person_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" type="text" size="4" value="<%$tpl_prices2[$seasonid][$rcatid][$bcatid].person%>"></td>
				<td class="ListL<%$tpl_rcat2[rcat].color%>"><input name="frm_additional_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" id="frm_additional_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" type="text" size="4" value="<%$tpl_prices2[$seasonid][$rcatid][$bcatid].additional%>"></td>
				<td class="ListL<%$tpl_rcat2[rcat].color%>"><input name="frm_additional_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" id="frm_additional_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" type="text" size="4" value="<%$tpl_prices2[$seasonid][$rcatid][$bcatid].additional_short%>"></td>
			</tr>
			<%/section%>
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
				</div>
			<%/section%>			
		</form>			

    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
<%/strip%>
<script language="Javascript">
<!--
switchLayer('<%if $tpl_theseason neq "-1"%><%$tpl_theseason%><%else%>L<%$tpl_seasons[0].seasonid%><%/if%>');
<%if $tpl_altered eq "true"%>
setaltered();
<%/if%>
//-->
</script>
<%strip%>
<%include file=footer.tpl%>
<%/strip%>

