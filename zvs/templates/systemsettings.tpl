<%include file=header.tpl%>
<script language="JavaScript" type="text/javascript">
<!--
    function openWindow(){
    F1 = window.open('<%$wwwroot%>colorchooser.php/field.frm_field/form.fields','colorchooser','width=270,height=190,left=0,top=0');
    F1.focus();
    }
    
	function edit(id) {
		document.fields.frm_defaultid.value = id;
		document.fields.frm_action.value = "edit";
		document.fields.submit();	
	}
	
	function save(id) {
		document.fields.frm_defaultid.value = id;
		document.fields.frm_action.value = "save";
		document.fields.submit();	
	}	
//-->
</script>
<%strip%>	
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Systemeinstellungen</p>
 		<form id="fields" name="fields" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_defaultid" id="frm_defaultid" value="0">
		<input type="hidden" name="frm_action" id="frm_action" value="new">
		
		<table border="0" cellspacing="0" cellpadding="3" >
            <tr>
               <td class="ListL1"><strong>Feld</strong></td>
               <td class="ListL1"><strong>Wert</strong></td>
               <td class="ListL1">&nbsp;</td>
            </tr>
			<%section name=field loop=$tpl_fields%>
			<tr>
				<td class="ListL<%$tpl_fields[field].color%>">
					  <%$tpl_fields[field].description%>
				</td>			
				<td class="ListL<%$tpl_fields[field].color%>" width="250">
					<%if $tpl_editid eq $tpl_fields[field].defaultid%>
					  <%if $tpl_fields[field].fieldtype eq 'color'%>
					     <input type="text" name="frm_field" id="frm_field" size="7" maxlength="7" value="<%$tpl_fields[field].value%>"><a href="javascript:openWindow();"><img src="<%$wwwroot%>img/button_colorchooser.gif" width="16" height="15" border="0"></a>
					  <%else%>
                         <input type="text" name="frm_field" id="frm_field" maxlength="128" size="30" value="<%$tpl_fields[field].value%>">
                      <%/if%>
					<%else%>
					  <%$tpl_fields[field].value%> &nbsp;
					<%/if%>
				</td>
				<td class="ListL<%$tpl_fields[field].color%>">
				<%if $tpl_editid eq $tpl_fields[field].defaultid%>
					<a href="javascript:save(<%$tpl_fields[field].defaultid%>);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				<%else%>
					<a href="javascript:edit(<%$tpl_fields[field].defaultid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
				<%/if%>
				</td>
			</tr>
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


<%include file=footer.tpl%>
<%/strip%>

