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
		check = confirm("Saison \""+ name +"\" wirklich löschen?\n");
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
<table width="400" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Saisonzeitr&auml;ume verwalten</p>
		<form id="season" name="season" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_seasonid" id="frm_seasonid" value="0">
		<input type="hidden" name="frm_action" id="frm_action" value="new">
		<table border="0" cellspacing="0" cellpadding="3" width="400">
		   <%if $tpl_addnew neq 'true'%>
			<tr>
				<td colspan="4">		  		
		  			<a href="javascript:neu();"><img src="<%$wwwroot%>img/button_neu.gif" width="56" height="24" border="0"></a>
		  		</td>
		  	</tr>		
		   <%/if%>		
			<tr>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>Bezeichnung</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>von</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>bis</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
					&nbsp;
				</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">&nbsp;</td>
		   </tr>		
		   <%if $tpl_addnew eq 'true'%>
			<tr>
				<td class="ListL1">
		  			<input type="text" name="frm_name" id="frm_name" maxlength="128" size="50">&nbsp;
		  		</td>
				<td class="ListL1" nowrap>
		  			<input type="text" name="frm_start" id="frm_start" size="10" maxlength="10">
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
    <%strip%>
		  		</td>
				<td class="ListL1" nowrap>
				<input type="text" name="frm_end" id="frm_end" size="10" maxlength="10">
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
    <%strip%>

		  		</td>
				<td class="ListL1">
					<a href="javascript:saveseason(0);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				</td>
				<td class="ListL1">&nbsp;</td>
		   </tr>
            <%/if%>
			<%section name=season loop=$tpl_season%>
			<tr>
				<td class="ListL<%$tpl_season[season].color%>">
					<%if $tpl_editid eq $tpl_season[season].seasonid%>
					  <input type="text" name="frm_name" id="frm_name" maxlength="128" size="50" value="<%$tpl_season[season].name%>">
					<%else%>
					  <%$tpl_season[season].name%>
					<%/if%>
				</td>
				<td class="ListL<%$tpl_season[season].color%>" nowrap>
					<%if $tpl_editid eq $tpl_season[season].seasonid%>
<input type="text" name="frm_start" id="frm_start" size="10" maxlength="10"  value="<%if $tpl_season[season].start_date neq "00.00.0000"%><%$tpl_season[season].start_date%><%/if%>">
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
    <%strip%>
					<%else%>
					    <%$tpl_season[season].start_date%>
					<%/if%>
				</td>
				<td class="ListL<%$tpl_season[season].color%>" nowrap>
					<%if $tpl_editid eq $tpl_season[season].seasonid%>
				<input type="text" name="frm_end" id="frm_end" size="10" maxlength="10" value="<%if $tpl_season[season].end_date neq "00.00.0000"%><%$tpl_season[season].end_date%><%/if%>">
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
    <%strip%>

					<%else%>
					  <%$tpl_season[season].end_date%>&nbsp;
					<%/if%>
				</td>
				<td class="ListL<%$tpl_season[season].color%>">
				<%if $tpl_editid eq $tpl_season[season].seasonid%>
					<a href="javascript:saveseason(<%$tpl_season[season].seasonid%>);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				<%else%>
					<a href="javascript:editseason(<%$tpl_season[season].seasonid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
				<%/if%>
				</td>
				<td class="ListL<%$tpl_season[season].color%>">
					<%if $tpl_editid neq $$tpl_season[season].seasonid%>
						<a href="javascript:delseason(<%$tpl_season[season].seasonid%>,'<%$tpl_season[season].name%>');"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0"></a>
					<%/if%>&nbsp;
				</td>
			</tr>
			<%/section%>
		</table>
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

<%include file=footer.tpl%>
<%/strip%>

