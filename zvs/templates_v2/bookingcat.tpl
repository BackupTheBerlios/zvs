<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--
    function openWindow(){
    F1 = window.open('<%$wwwroot%>colorchooser.php','colorchooser','width=270,height=190,left=0,top=0');
    F1.focus();
    }
    
	function editbcat(id) {
		document.cat.frm_bcatid.value = id;
		document.cat.frm_action.value = "edit";
		document.cat.submit();	
	}
	
	function delbcat(id, name) {
		var check;
		check = confirm("Kategorie \""+ name +"\" wirklich löschen?\n");
		if (check) {
			document.cat.frm_bcatid.value = id;
			document.cat.frm_action.value = "del";
			document.cat.submit();	
		}
	}	
	
	function savebcat(id){
	   document.cat.frm_bcatid.value=id;	
		document.cat.submit();
	}
	
	function neu(){
		document.cat.frm_bcatid.value = 0;
		document.cat.frm_action.value = "addnew";
		document.cat.submit();
	}

//-->
</script>
<%strip%>
<div class="box750">
	<h2><span>##ADMINISTER_BOOKING_CATEGORYS##</span></h2>
	<div class="table">
		<form accept-charset="utf-8" id="cat" name="cat" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_bcatid" id="frm_bcatid" value="0"/>
		<input type="hidden" name="frm_action" id="frm_action" value="new"/>
		
		   <%if $tpl_addnew neq 'true'%>
		  			&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span><a href="javascript:neu();" class="dotted">##NEW_CATEGORY##</a></div>
		   <%/if%>			
		<table class="list" width="100%">
			<tr class="ListHeader">
				<th>##LABEL##</th>
				<th>##COLOR##</th>
				<th>##DESCRIPTION##</th>
				<th>##DURATION##</th>
				<th>&nbsp;</th>
		</tr>			
		   <%if $tpl_addnew eq 'true'%>
			<tr class="ListHighlight">
				<td><input type="text" name="frm_name" id="frm_name" maxlength="128" size="50"/></td>
				<td><input type="text" name="frm_color" id="frm_color" size="7" maxlength="7"/><a href="javascript:openWindow();"><img src="<%$wwwroot%>img/button_colorchooser.gif" width="16" height="15" border="0"></a></td>
				<td><textarea name="frm_description" id="frm_description" cols="25" rows="2"></textarea></td>
				<td><input type="text" name="frm_days" id="frm_days" size="4" maxlength="4"/></td>				
				<td><a href="javascript:savebcat(0);"><span class="button">##SAVE##</span></a></td>
		   </tr>
        <%/if%>
			<%section name=bcat loop=$tpl_bcat%>
			<tr <%if $tpl_editid eq $tpl_bcat[bcat].bcatid%>class="ListHighlight"<%else%>class="ListL<%$tpl_bcat[bcat].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_bcat[bcat].color%>'"<%/if%>>
				<td>
					<%if $tpl_editid eq $tpl_bcat[bcat].bcatid%>
					  <input type="text" name="frm_name" id="frm_name" maxlength="128" size="50" value="<%$tpl_bcat[bcat].name%>"/>
					<%else%>
					  <a href="javascript:editbcat(<%$tpl_bcat[bcat].bcatid%>);" class="dotted"><%$tpl_bcat[bcat].name%></a>
					<%/if%>
				</td>
				<td>
					<%if $tpl_editid eq $tpl_bcat[bcat].bcatid%>
					  <input type="text" name="frm_color" id="frm_color" value="<%$tpl_bcat[bcat].catcolor%>" size="7" maxlength="7"/>
					  <a href="javascript:openWindow();"><img src="<%$wwwroot%>img/button_colorchooser.gif" width="16" height="15" border="0"></a>
					<%else%>
					  <table>
					  <tr>
					    <td class="colorchooser" bgcolor="<%$tpl_bcat[bcat].catcolor%>"><img src="<%$wwwroot%>img/spacer.gif" width="10" height="10" boder="0"></td>
					  </tr>
					  </table>
					<%/if%>
				</td>
				<td>
					<%if $tpl_editid eq $tpl_bcat[bcat].bcatid%>
					  <textarea name="frm_description" id="frm_description" cols="25" rows="2"><%$tpl_bcat[bcat].description%></textarea>
					<%else%>
					  <%$tpl_bcat[bcat].description%>&nbsp;
					<%/if%>
				</td>
				<td>
				<%if $tpl_editid eq $tpl_bcat[bcat].bcatid%>
		  			<input type="text" name="frm_days" id="frm_days" size="4" maxlength="4" value="<%$tpl_bcat[bcat].days%>"/>
				<%else%>
					<%$tpl_bcat[bcat].days%>&nbsp;
				<%/if%>
		  		</td>
				<td>
				<%if $tpl_editid eq $tpl_bcat[bcat].bcatid%>
					<a href="javascript:savebcat(<%$tpl_bcat[bcat].bcatid%>);"><span class="button">##SAVE##</span></a>
				<%else%>
						<a href="javascript:delbcat(<%$tpl_bcat[bcat].bcatid%>,'<%$tpl_bcat[bcat].name%>');" class="dotted">##DELETE##</a><strong>&nbsp;&raquo;</strong>
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

