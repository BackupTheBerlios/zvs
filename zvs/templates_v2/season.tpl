<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--
    function openWindow(){
    F1 = window.open('<%$wwwroot%>colorchooser.php','colorchooser','width=270,height=190,left=0,top=0');
    F1.focus();
    }
    
	function editseason(id) {
		document.season.frm_seasonid.value = id;
		document.season.frm_action.value = "edit";
		document.season.submit();	
	}
	
	function delseason(id, name) {
		var check;
		check = confirm("##REALLY_DELETE_SAISON##: \""+ name +"\"\n");
		if (check) {
			document.season.frm_seasonid.value = id;
			document.season.frm_action.value = "del";
			document.season.submit();	
		}
	}	
	
	function saveseason(id){
	   document.season.frm_seasonid.value=id;	
	   document.season.submit();
	}
	
	function neu(){
		document.season.frm_seasonid.value = 0;
		document.season.frm_action.value = "addnew";
		document.season.submit();
	}

//-->
</script>
<%strip%>
<div class="box750">
	<h2><span>##ADMINISTER_SEASON##</span></h2>
	<div class="table">
		<form accept-charset="utf-8" id="season" name="season" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_seasonid" id="frm_seasonid" value="0"/>
		<input type="hidden" name="frm_action" id="frm_action" value="new"/>
		   <%if $tpl_addnew neq 'true'%>
		  			&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span><a href="javascript:neu();" class="dotted">##NEW_SEASON##</a></div>
		   <%/if%>						
		<table class="list" width="100%">
			<tr class="ListHeader">		
				<th>##LABEL##</th>
				<th>##FROM##</th>
				<th>##UNTIL##</th>
				<th>&nbsp;</th>
			</tr>
		   <%/strip%>
		   <%if $tpl_addnew eq 'true'%>
		   <%strip%>
			<tr class="ListHighlight">
				<td><input type="text" name="frm_name" id="frm_name" maxlength="128" size="50"/></td>
				<td><input type="text" name="frm_start" id="frm_start" size="10" maxlength="10"><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar1Callback(date, month, year)
        {
            document.forms['season'].frm_start.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['season'].frm_start.value;
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
		  		</td>
				<td><input type="text" name="frm_end" id="frm_end" size="10" maxlength="10"/><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar2Callback(date, month, year)
        {
            document.forms['season'].frm_end.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['season'].frm_end.value;
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
	  		</td>
				<td>
					<a href="javascript:saveseason(0);"><span class="button">##SAVE##</span></a>
				</td>
		   </tr>
		   <%/strip%>
      <%/if%>
			<%section name=season loop=$tpl_season%>
			<%strip%>
			<tr <%if $tpl_editid eq $tpl_season[season].seasonid%>class="ListHighlight"<%else%>class="ListL<%$tpl_season[season].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_season[season].color%>'"<%/if%>>
				<td>
					<%if $tpl_editid eq $tpl_season[season].seasonid%>
					  <input type="text" name="frm_name" id="frm_name" maxlength="128" size="50" value="<%$tpl_season[season].name%>"/>
					<%else%>
					  <a href="javascript:editseason(<%$tpl_season[season].seasonid%>);" class="dotted"><%$tpl_season[season].name%></a>
					<%/if%>
				</td>
				<td>
				<%/strip%>
					<%if $tpl_editid eq $tpl_season[season].seasonid%>
					<%strip%>
						<input type="text" name="frm_start" id="frm_start" size="10" maxlength="10"  value="<%if $tpl_season[season].start_date neq "00.00.0000"%><%$tpl_season[season].start_date%><%/if%>"/>
					<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar1Callback(date, month, year)
        {
            document.forms['season'].frm_start.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['season'].frm_start.value;
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
					<%else%>
					    <%$tpl_season[season].start_date%>
					<%/if%>
			    <%strip%>
				</td>
				<td>
				<%/strip%>
					<%if $tpl_editid eq $tpl_season[season].seasonid%>
					<%strip%>
					<input type="text" name="frm_end" id="frm_end" size="10" maxlength="10" value="<%if $tpl_season[season].end_date neq "00.00.0000"%><%$tpl_season[season].end_date%><%/if%>"/>
					<%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--

        function calendar2Callback(date, month, year)
        {
            document.forms['season'].frm_end.value = date + '.' + month + '.' + year;
			setaltered();
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['season'].frm_end.value;
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

					<%else%>
					  <%$tpl_season[season].end_date%>&nbsp;
					<%/if%>
				<%strip%>
				</td>
				<td>
				<%if $tpl_editid eq $tpl_season[season].seasonid%>
					<a href="javascript:saveseason(<%$tpl_season[season].seasonid%>);"><span class="button">##SAVE##</span></a>
				<%else%>
					<a href="javascript:delseason(<%$tpl_season[season].seasonid%>,'<%$tpl_season[season].name%>');" class="dotted">##DELETE##</a><strong>&nbsp;&raquo;</strong>
					<%/if%>&nbsp;
				</td>
			</tr>
			<%/strip%>
			<%/section%>
			<%strip%>
		</table>
		</form>
	</div>
</div>

<%include file=footer.tpl%>
<%/strip%>

