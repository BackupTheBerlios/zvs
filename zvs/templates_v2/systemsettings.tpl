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
<div class="box750">
	<h2><span>##SYSTEM_SETTINGS##</span></h2>
	<div class="table">
		<form accept-charset="utf-8" id="fields" name="fields" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_defaultid" id="frm_defaultid" value="0"/>
		<input type="hidden" name="frm_action" id="frm_action" value="new"/>
		<table class="list" width="100%">
			<tr class="ListHeader">		
				<th>##FIELD##</th>
				<th>##VALUE##</th>
				<th>&nbsp;</th>
			</tr>		
			<%section name=field loop=$tpl_fields%>
			<tr <%if $tpl_editid eq $tpl_fields[field].defaultid%>class="ListHighlight"<%else%>class="ListL<%$tpl_fields[field].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_fields[field].color%>'"<%/if%>>
				<td>
					  <a href="javascript:edit(<%$tpl_fields[field].defaultid%>);" class="dotted"><%$tpl_fields[field].description%></if>
				</td>			
				<td>
					<%if $tpl_editid eq $tpl_fields[field].defaultid%>
					  <%if $tpl_fields[field].fieldtype eq 'color'%>
					     <input type="text" name="frm_field" id="frm_field" size="7" maxlength="7" value="<%$tpl_fields[field].value%>"/><a href="javascript:openWindow();"><img src="<%$wwwroot%>img/button_colorchooser.gif" width="16" height="15" border="0"></a>
					  <%else%>
                <input type="text" name="frm_field" id="frm_field" maxlength="128" size="30" value="<%$tpl_fields[field].value%>"/>
            <%/if%>
					<%else%>
					  <%$tpl_fields[field].value%>
					<%/if%>
				</td>
				<td>
				<%if $tpl_editid eq $tpl_fields[field].defaultid%>
					<a href="javascript:save(<%$tpl_fields[field].defaultid%>);"><span class="button">##SAVE##</span></a>
				<%/if%>
				</td>
			</tr>
			<%/section%>
		</table>
</form>
</div>
</div>

<%include file=footer.tpl%>
<%/strip%>

