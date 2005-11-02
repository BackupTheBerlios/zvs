<%strip%>
<%include file=header.tpl%>
<div class="box400">
		<h2><span>##EMPLOYEES## ##ATTENDANCE_LIST##</span></h2>
		<br/>
  <div class="table">
    	<table class="list" width="100%">
			<tr class="ListHeader">
			  <th>##NAME##</th>				
				<th>##SINCE##</th>
			</tr>
			<%section name=employee loop=$tpl_employees%>
			<tr class="ListL<%$tpl_employees[employee].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_employees[employee].color%>'">
				<td><%$tpl_employees[employee].firstname%>&nbsp;<%$tpl_employees[employee].lastname%></td>			
				<td><%$tpl_employees[employee].start_date%></td>		
			</tr>
			<%sectionelse%>
			<tr>
			    <td colspan="2">##NO_EMPLOYEE##</td>
			</tr>
			<%/section%>
		</table>
</div>
</div>

<%include file=footer.tpl%>
<%/strip%>
