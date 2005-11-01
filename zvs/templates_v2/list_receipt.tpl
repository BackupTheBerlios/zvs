<%strip%>
<%include file=header.tpl%>
<div class="boxdyn">
		<h2><span>##BILLS##</span></h2>
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
	<select name="frm_display" id="frm_display" onChange="javascript:document.select.frm_what.value='thedate';document.select.submit();">
		<option value="all" <%if $tpl_display eq "all"%>selected="selected"<%/if%>>##ALL##</option>
		<option value="open" <%if $tpl_display eq "open"%>selected="selected"<%/if%>>##OPEN##</option>
		<option value="payed" <%if $tpl_display eq "payed"%>selected="selected"<%/if%>>##CLEARED##</option>
		<option value="commission" <%if $tpl_display eq "commission"%>selected="selected"<%/if%>>##PAID_ON_ACCOUNT##</option>		
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
	<input name="frm_end1" type="text" id="frm_end1" size="10" value="<%$tpl_end1%>" class="nomargin">
	<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
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
	<select name="frm_display2" id="frm_display2" onChange="javascript:document.select.frm_what.value='timeline';document.select.submit();">
		<option value="all" <%if $tpl_display eq "all"%>selected="selected"<%/if%>>##ALL##</option>
		<option value="open" <%if $tpl_display eq "open"%>selected="selected"<%/if%>>##OPEN##</option>
		<option value="payed" <%if $tpl_display eq "payed"%>selected="selected"<%/if%>>##CLEARED##</option>
		<option value="commission" <%if $tpl_display eq "commission"%>selected="selected"<%/if%>>##PAID_ON_ACCOUNT##</option>		
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
	<select name="frm_display3" id="frm_display3" onChange="javascript:document.select.frm_what.value='timeline2';document.select.submit();">
		<option value="all" <%if $tpl_display eq "all"%>selected="selected"<%/if%>>##ALL##</option>
		<option value="open" <%if $tpl_display eq "open"%>selected="selected"<%/if%>>##OPEN##</option>
		<option value="payed" <%if $tpl_display eq "payed"%>selected="selected"<%/if%>>##CLEARED##</option>
		<option value="commission" <%if $tpl_display eq "commission"%>selected="selected"<%/if%>>##PAID_ON_ACCOUNT##</option>		
	</select>
	</div>	

<br/>

	<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr class="ListHeader">
			  <th>&nbsp;</th>
			  <th>##DATE##</th>
				<th>##INVOICE_NUMBER##</th>
				<th>##NAME##</th>
				<th align="right">##INVOICE_AMOUNT##</th>
				<th align="right">##PAID##</th>
				<th align="right">##BALANCE##</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>

			<%section name=receipt loop=$tpl_receipt%>
				<tr class="ListL<%$tpl_receipt[receipt].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_receipt[receipt].color%>'">
				  <td><img src="<%$wwwroot%>img/<%$tpl_receipt[receipt].type%><%$tpl_receipt[receipt].color%>.png" width="14" height="14" border="0"></td>
					<td><%$tpl_receipt[receipt].receipt_date%>&nbsp;</td>
					<td><%$tpl_receipt[receipt].receipt_reference%>&nbsp;</td>
					<td><%$tpl_receipt[receipt].firstname%>&nbsp;<%$tpl_receipt[receipt].lastname%></td>
					<td align="right"><%$tpl_receipt[receipt].receipt_sum%>&nbsp;EUR&nbsp;</td>
					<td align="right"><%$tpl_receipt[receipt].paid%>&nbsp;EUR&nbsp;</td>
					<td align="right"><%$tpl_receipt[receipt].diff%>&nbsp;EUR&nbsp;</td>					
					<td><a href="<%$wwwroot%>receiptrtf.php/receiptid.<%$tpl_receipt[receipt].receiptid%>/receiptrtf.php" target="_blank" class="dotted">##SHOW##</a>&nbsp;&raquo;</td>
					<td><a href="<%$wwwroot%>receipt.php/receiptid.<%$tpl_receipt[receipt].receiptid%>/bookid.<%$tpl_receipt[receipt].bookid%>/guestid.<%$tpl_receipt[receipt].guestid%>/receipt.php" target="_blank" class="dotted">##EDIT##</a>&nbsp;&raquo;</td>
				</tr>
			<%/section%>
		</table>
	</form>
	</div>
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

