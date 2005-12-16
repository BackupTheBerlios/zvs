<%strip%>
<%include file=header.tpl%>
<div class="box400">
		<h2><span>##BIRTHDAY_LIST##</span></h2>
		<br/>
  <div class="table">
<form accept-charset="utf-8" name="select" id="select" action="<%$SCRIPT_NAME%>" method="post">
		##MONTH##: 
		<select name="frm_month" id="frm_month" onchange="document.select.submit();">
			<option value="01" <%if $tpl_month eq "01"%>selected=selected<%/if%>>##JANUARY##</option>
			<option value="02" <%if $tpl_month eq "02"%>selected=selected<%/if%>>##FEBRUARY##</option>
			<option value="03" <%if $tpl_month eq "03"%>selected=selected<%/if%>>##MARCH##</option>
			<option value="04" <%if $tpl_month eq "04"%>selected=selected<%/if%>>##APRIL##</option>
			<option value="05" <%if $tpl_month eq "05"%>selected=selected<%/if%>>##MAY##</option>
			<option value="06" <%if $tpl_month eq "06"%>selected=selected<%/if%>>##JUNE##</option>
			<option value="07" <%if $tpl_month eq "07"%>selected=selected<%/if%>>##JULY##</option>
			<option value="08" <%if $tpl_month eq "08"%>selected=selected<%/if%>>##AUGUST##</option>
			<option value="09" <%if $tpl_month eq "09"%>selected=selected<%/if%>>##SEPTEMBER##</option>
			<option value="10" <%if $tpl_month eq "10"%>selected=selected<%/if%>>##OCTOBER##</option>
			<option value="11" <%if $tpl_month eq "11"%>selected=selected<%/if%>>##NOVEMBER##</option>
			<option value="12" <%if $tpl_month eq "12"%>selected=selected<%/if%>>##DECEMBER##</option>
		</select>
		<br/><br/>
    	<table class="list" width="100%">
			<tr class="ListHeader">
			  <th>##DATE##</th>
				<th>##NAME##</th>
				<th>##AGE##</th>
				<th>&nbsp;</th>							
			</tr>     		
			<%section name=guest loop=$tpl_guests%>
			<tr class="ListL<%$tpl_guests[guest].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_guests[guest].color%>'">
				<td><%$tpl_guests[guest].birthday%></td>			
				<td><%$tpl_guests[guest].lastname%>, <%$tpl_guests[guest].firstname%></td>		
				<td><%$tpl_guests[guest].age%></td>	
				<td><a href="<%$wwwroot%>showgast.php/guestid.<%$tpl_guests[guest].guestid%>" class="dotted">##SHOW##</a>&nbsp;&raquo;</td>									
			</tr>
			<%sectionelse%>
			<tr>
			    <td colspan="4">keine Eintr&auml;ge</td>
			</tr>
			<%/section%>
		</table>
</form>
</div>
</div>
<%include file=footer.tpl%>
<%/strip%>
