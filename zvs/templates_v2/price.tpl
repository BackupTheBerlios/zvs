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
<div class="boxdyn">
	<h2><span>##ADMINISTER_ROOM_PRICES##</span>
	</h2>
	<div class="table">
			&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span>
		<form accept-charset="utf-8" id="season" name="season" action="<%$SCRIPT_NAME%>" method="post" class="inline">
			##YEAR##: 
			<select name="frm_theyear" id="frm_theyear" onchange="document.season.submit();">
				<%section name=year loop=$tpl_years%>
				<option value="<%$tpl_years[year]%>" <%if $tpl_theyear eq $tpl_years[year]%>selected<%/if%>><%$tpl_years[year]%></option>
				<%/section%>
			</select>
		</form>				
    <form accept-charset="utf-8" id="seasoncopy" name="seasoncopy" action="<%$SCRIPT_NAME%>" method="post" class="inline">
	<input type="hidden" name="frm_theyear" id="frm_theyear" value="<%$tpl_theyear%>"/>
	<input type="hidden" name="frm_theseason" id="frm_theseason" value="L<%$tpl_seasons[0].seasonid%>"/>
		##COPY_PRICE##: 
		<select name="frm_copy" id="frm_copy" onchange="document.seasoncopy.submit();">
				<option value="-1">##SELECT_SEASON##</option>
			<%section name="season" loop="$tpl_allseasons"%>
				<option value="<%$tpl_allseasons[season].seasonid%>"><%$tpl_allseasons[season].name%></option>
			<%/section%>
		</select>
		</form>				
  </div><br/>
		
		
		<form accept-charset="utf-8" id="save" name="save" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_theseason" id="frm_theseason" value="L<%$tpl_seasons[0].seasonid%>"/>
		<input type="hidden" name="frm_theyear" id="frm_theyear" value="<%$tpl_theyear%>"/>
		<input type="hidden" name="frm_action" id="frm_action" value="save"/>
			<%section name="season" loop="$tpl_seasons"%>
			<input type="hidden" name="frm_seasonid[]" id="frm_seasonid[]" value="<%$tpl_seasons[season].seasonid%>"/>
			<%assign var="seasonid" value="`$tpl_seasons[season].seasonid`"%>
				<div id="L<%$tpl_seasons[season].seasonid%>" name="L<%$tpl_seasons[season].seasonid%>" style="visibility:visible">
					
				<div class="boxdyn">
				<h2><span><%$tpl_seasons[season].name%></span></h2>
				<br/>
				<ul class="tabbed">
				 <%section name="season2" loop="$tpl_seasons"%>
           <li <%if $tpl_seasons[season].seasonid eq $tpl_seasons[season2].seasonid%>id="current"<%/if%>><a href="javascript:switchLayer('L<%$tpl_seasons[season2].seasonid%>');" onClick="bypassCheck()"><%$tpl_seasons[season2].name%></a><%if not $smarty.section.season2.last%>|<%/if%></li>
				 <%/section%>
       	</ul>
		<p align="right"><a href="javascript:document.save.submit();" onClick="unsetaltered();" class="dotted">##SAVE##</a></p>						
				
		<%section name="bcat" loop="$tpl_bcat"%>
		<%assign var="bcatid" value="`$tpl_bcat[bcat].bcatid`"%>
		<h3><%$tpl_bcat[bcat].name%>&nbsp;(<%$tpl_bcat[bcat].days%>&nbsp;<%if $tpl_bcat[bcat].days gt 1%>##DAYS##<%else%>##DAY##<%/if%>)</h3>
			<table class="list" width="100%">
			<tr class="ListHeader">
				<th>&nbsp;</td>
				<th>##ADULT##<br/>##REGULAR##</th>
				<th>##ADULT##<br/>##SHORT##</th>
				<th><%$tpl_children1%><br/>##REGULAR##</th>
				<th><%$tpl_children1%><br/>##SHORT##</th>
				<th><%$tpl_children2%><br/>##REGULAR##</th>
				<th><%$tpl_children2%><br/>##SHORT##</th>
				<th><%$tpl_children3%><br/>##REGULAR##</th>
				<th><%$tpl_children3%><br/>##SHORT##</th>								
			</tr>			
			<%section name="rcat" loop=$tpl_rcat"%>
			<%assign var="rcatid" value="`$tpl_rcat[rcat].catid`"%>
			<tr class="ListL<%$tpl_rcat[rcat].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_rcat[rcat].color%>'">
				<td><strong><%$tpl_rcat[rcat].name%></strong></td>
					<td><input name="frm_price_adult_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_adult_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].person%>"/></td>
					<td><input name="frm_price_adult_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_adult_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].person_short%>"/></td>
					<td><input name="frm_price_child_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children%>"/></td>
					<td><input name="frm_price_child_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children_short%>"/></td>
					<td><input name="frm_price_child2_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child2_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children2%>"/></td>
					<td><input name="frm_price_child2_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child2_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children2_short%>"/></td>
					<td><input name="frm_price_child3_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child3_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children3%>"/></td>
					<td><input name="frm_price_child3_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" id="frm_price_child3_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat[rcat].catid%>" type="text" size="4" value="<%$tpl_prices[$seasonid][$rcatid][$bcatid].children3_short%>"/></td>
			</tr>
			<%/section%>
			</table>
			<br/><br/>		
			<%/section%>
		<br/><br/>
		<%section name="bcat" loop="$tpl_bcat"%>
		<%assign var="bcatid" value="`$tpl_bcat[bcat].bcatid`"%>
			<h3><%$tpl_bcat[bcat].name%>&nbsp;(<%$tpl_bcat[bcat].days%>&nbsp;<%if $tpl_bcat[bcat].days gt 1%>##DAYS##<%else%>##DAY##<%/if%>)</h3>
			<table class="list" width="100%">
			<tr class="ListHeader">
				<th>&nbsp;</th>
				<th>##BASIC_RATE## ##REGULAR##</th>
				<th>##BASIC_RATE## ##SHORT##</th>
				<th>##INCLUDED_PERSONS##</th>
				<th>##UPCHARGE## ##REGULAR##</th>
				<th>##UPCHARGE## ##SHORT##</th>
			</tr>			
			<%section name="rcat" loop=$tpl_rcat2"%>
			<%assign var="rcatid" value="`$tpl_rcat2[rcat].catid`"%>
			<tr class="ListL<%$tpl_rcat2[rcat].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_rcat2[rcat].color%>'">
				<td><strong><%$tpl_rcat2[rcat].name%></strong></td>
				<td><input name="frm_price_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" id="frm_price_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" type="text" size="4" value="<%$tpl_prices2[$seasonid][$rcatid][$bcatid].price%>"/></td>
				<td><input name="frm_price_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" id="frm_price_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" type="text" size="4" value="<%$tpl_prices2[$seasonid][$rcatid][$bcatid].price_short%>"/></td>
				<td><input name="frm_person_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" id="frm_person_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" type="text" size="4" value="<%$tpl_prices2[$seasonid][$rcatid][$bcatid].person%>"/></td>
				<td><input name="frm_additional_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" id="frm_additional_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" type="text" size="4" value="<%$tpl_prices2[$seasonid][$rcatid][$bcatid].additional%>"/></td>
				<td><input name="frm_additional_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" id="frm_additional_short_<%$tpl_seasons[season].seasonid%>_<%$tpl_bcat[bcat].bcatid%>_<%$tpl_rcat2[rcat].catid%>" type="text" size="4" value="<%$tpl_prices2[$seasonid][$rcatid][$bcatid].additional_short%>"/></td>
			</tr>
			<%/section%>
				</table>
				<br/><br/>
			<%/section%>
			<p align="right"><a href="javascript:document.save.submit();" onClick="unsetaltered();" class="dotted">##SAVE##</a></p>						
			</div>
				</div>
			<%/section%>			
		</form>		
		
	</div>
</div>
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

