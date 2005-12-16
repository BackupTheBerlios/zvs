<%strip%>
<%include file=header.tpl%>
<div class="boxdyn">
		<h2><span>##ITEM_OF_AN_INVOICE##</span></h2>
		<br/>
  <div class="table">
<form accept-charset="utf-8" name="select" id="select" action="<%$SCRIPT_NAME%>" method="post">
<input type="hidden" name="frm_newstart" id="frm_newstart" value="false"/>
<input type="hidden" name="frm_what" id="frm_what" value="<%$tpl_what%>"/>

<a href="javascript:switchLayer('thedate');document.select.frm_what.value='thedate';document.select.submit();" class="dotted">##DATE##</a>
	&nbsp;<a href="javascript:switchLayer('timeline');document.select.frm_what.value='timeline';document.select.submit();" class="dotted">##TIMEFRAME## (##DATE##)</a>
	&nbsp;<a href="javascript:switchLayer('timeline2');document.select.frm_what.value='timeline2';document.select.submit();" class="dotted">##TIMEFRAME## (##MONTH##)</a>
	<br/><br/>
	<div id="thedate" name="thedate" style="visibility:visible">
	##DATE##: 
	<input name="frm_thedate" type="text" id="frm_thedate" size="10" value="<%$tpl_thedate%>"  onChange="javascript:document.select.frm_what.value='thedate';document.select.submit();" class="nomargin"/>
	<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        function calendar1Callback(date, month, year)
        {
            document.forms['select'].frm_thedate.value = date + '.' + month + '.' + year;
			document.select.frm_what.value='thedate';
			document.forms['select'].submit();
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['select'].frm_thedate.value;
        	if (strDate != "")
			{
				arrDate = strDate.split(".");
				month = arrDate[1]-1;
				year = arrDate[2];
				day = arrDate[0];
				strDate = month+', '+year+', '+day;
			} else {
				strDate = "";
			}
         return strDate
        }

        calendar1 = new dynCalendar('calendar1', 'calendar1Callback', '<%$wwwroot%>img/');
    //-->
    </script>
    <%strip%>	
	&nbsp;
	##TAX##:
	<select name="frm_mwst1" id="frm_mwst1" onChange="document.select.submit();">
		<option value="-1" <%if $tpl_themwst eq "-1"%>selected<%/if%>>##ALL##</option>
	<%section name="mwst" loop="$tpl_mwst%>
		<option value="<%$tpl_mwst[mwst]%>" <%if $tpl_themwst eq $tpl_mwst[mwst]%>selected<%/if%>><%$tpl_mwst[mwst]%></option>
	<%/section%>
	</select>	
	</div>
	<div id="timeline" name="timeline" style="visibility:visible">
	##FROM##: 
	<input name="frm_start1" type="text" id="frm_start1" size="10" value="<%$tpl_start1%>" class="nomargin">
	<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        function calendar2Callback(date, month, year)
        {
            document.forms['select'].frm_start1.value = date + '.' + month + '.' + year;
			document.select.frm_what.value='timeline';
			if (document.forms['select'].frm_end1.value != '')
			{
				document.forms['select'].submit();
			}
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['select'].frm_start1.value;
        	if (strDate != "")
			{
				arrDate = strDate.split(".");
				month = arrDate[1]-1;
				year = arrDate[2];
				day = arrDate[0];
				strDate = month+', '+year+', '+day;
			} else {
				strDate = "";
			}
         return strDate
        }

        calendar2 = new dynCalendar('calendar2', 'calendar2Callback', '<%$wwwroot%>img/');
    //-->
    </script>
    <%strip%>	

	&nbsp;##UNTIL##: 
	<input name="frm_end1" type="text" id="frm_end1" size="10" value="<%$tpl_end1%>" class="nomargin"/>
	<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        function calendar3Callback(date, month, year)
        {
            document.forms['select'].frm_end1.value = date + '.' + month + '.' + year;
			document.select.frm_what.value='timeline';
			if (document.forms['select'].frm_start1.value != '')
			{
				document.forms['select'].submit();
			}
        }
        function calendar3GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['select'].frm_end1.value;
        	if (strDate != "")
			{
				arrDate = strDate.split(".");
				month = arrDate[1]-1;
				year = arrDate[2];
				day = arrDate[0];
				strDate = month+', '+year+', '+day;
			} else {
				strDate = "";
			}
         return strDate
        }

        calendar3 = new dynCalendar('calendar3', 'calendar3Callback', '<%$wwwroot%>img/');
    //-->
    </script>
    <%strip%>	
	&nbsp;
	##TAX##:
	<select name="frm_mwst2" id="frm_mwst2" onChange="document.select.submit();">
		<option value="-1" <%if $tpl_themwst eq "-1"%>selected<%/if%>>##ALL##</option>
	<%section name="mwst" loop="$tpl_mwst%>
		<option value="<%$tpl_mwst[mwst]%>" <%if $tpl_themwst eq $tpl_mwst[mwst]%>selected<%/if%>><%$tpl_mwst[mwst]%></option>
	<%/section%>
	</select>	
	</div>
	<div id="timeline2" name="timeline2" style="visibility:visible">
	##FROM##: 
	<select name="frm_start" id="frm_start" onChange="javascript:document.select.frm_newstart.value='true';document.select.frm_what.value='timeline2';document.select.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_thestart%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	&nbsp;
	##UNTIL##: 
	<select name="frm_end" id="frm_end" onChange="javascript:document.select.frm_what.value='timeline2';document.select.submit();">
	<%section name="date" loop=$tpl_dates%>
		<option value="<%$tpl_dates[date]%>" <%if $tpl_dates[date] eq $tpl_theend%>selected<%/if%>><%$tpl_dates[date]%></option>
	<%/section%>
	</select>
	&nbsp;
	MwSt.:
	<select name="frm_mwst3" id="frm_mwst3" onChange="document.select.submit();">
		<option value="-1" <%if $tpl_themwst eq "-1"%>selected<%/if%>>##ALL##</option>
	<%section name="mwst" loop="$tpl_mwst%>
		<option value="<%$tpl_mwst[mwst]%>" <%if $tpl_themwst eq $tpl_mwst[mwst]%>selected<%/if%>><%$tpl_mwst[mwst]%></option>
	<%/section%>
	</select>	
	</div>	
<br>
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr class="ListHeader">
			  <th>##DATE##</th>
				<th>##INVOICE_NUMBER##</th>
				<th>##NAME##</th>
				<th>##LABEL##</th>
				<th align="right">##SET##</th>
				<th align="right">##NET##</th>
				<th align="right">##TOTAL## ##NET##</th>
				<th align="right">##TAX##</th>
				<th align="right">##GROSS##</th>
				<th align="right">##TOTAL## ##GROSS##</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
			<%section name=receipt loop=$tpl_receiptitems%>
				<tr class="ListL<%$tpl_receiptitems[receipt].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_receiptitems[receipt].color%>'">
				<%if $smarty.section.receipt.last%>
				<td colspan="10" align="right"><b>Gesamt:</b></td>
				<td align="right"><%$tpl_receiptitems[receipt].netto_sum%>&nbsp;EUR&nbsp;</td>
				<td align="right"><%$tpl_receiptitems[receipt].brutto_sum%>&nbsp;EUR&nbsp;</td>								
				<%else%>
					<td><%$tpl_receiptitems[receipt].receipt_date%>&nbsp;</td>
					<td><%$tpl_receiptitems[receipt].receipt_reference_id%>&nbsp;</td>
					<td><%$tpl_receiptitems[receipt].firstname%>&nbsp;<%$tpl_receiptitems[receipt].lastname%></td>
					<td><%$tpl_receiptitems[receipt].article%>&nbsp;</td>					
					<td align="right"><%$tpl_receiptitems[receipt].amount%>&nbsp;</td>										
					<td align="right"><%$tpl_receiptitems[receipt].price_netto%>&nbsp;EUR&nbsp;</td>							
					<td align="right"><%$tpl_receiptitems[receipt].sum_netto%>&nbsp;EUR&nbsp;</td>							
					<td align="right"><%$tpl_receiptitems[receipt].mwst%>&nbsp;</td>							
					<td align="right"><%$tpl_receiptitems[receipt].price_brutto%>&nbsp;EUR&nbsp;</td>																	
					<td align="right"><%$tpl_receiptitems[receipt].sum_brutto%>&nbsp;EUR&nbsp;</td>						
					<td align="right"><%$tpl_receiptitems[receipt].netto_sum%><%if $tpl_receiptitems[receipt].netto_sum neq ''%>&nbsp;EUR<%/if%>&nbsp;</td>						
					<td align="right"><%$tpl_receiptitems[receipt].brutto_sum%><%if $tpl_receiptitems[receipt].netto_sum neq ''%>&nbsp;EUR<%/if%>&nbsp;</td>																
				<%/if%>
				</tr>
			<%/section%>
		</table>
</form>
</div>
<%/strip%>
<script language="JavaScript" type="text/javascript">
var isIE, isDOM;
isIE = (document.all ? true : false);
isDOM = (document.getElementById ? true : false);


function switchLayer(layername)
{
	if (isIE)
	{
		element1 = document.all.thedate;
		element2 = document.all.timeline;
		element3 = document.all.timeline2;
		myelement = eval('document.all.'+layername);
	} else {
		element1 = document.getElementById("thedate");		
		element2 = document.getElementById("timeline");
		element3 = document.getElementById("timeline2");
		myelement = document.getElementById(layername);
	}	

	element1.style.display = 'none';
	element2.style.display = 'none';
	element3.style.display = 'none';
	myelement.style.display = '';
}

switchLayer('<%$tpl_what%>');
</script>
<%strip%>

<%include file=footer.tpl%>
<%/strip%>

