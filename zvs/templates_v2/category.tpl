<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--

	function editcat(id) {
		document.cat.frm_catid.value = id;
		document.cat.frm_action.value = "edit";
		document.cat.submit();	
	}
	
	function delcat(id, name) {
		var check;
		check = confirm("##CATEGORY## \""+ name +"\" ##REALLY_DELETE##?");
		if (check) {
			document.cat.frm_catid.value = id;
			document.cat.frm_action.value = "del";
			document.cat.submit();	
		}
	}	
	
	function savecat(id){
	   document.cat.frm_catid.value=id;	
		document.cat.submit();
	}
	
	function neu(){
		document.cat.frm_catid.value = 0;
		document.cat.frm_action.value = "addnew";
		document.cat.submit();
	}

//-->
</script>
<%strip%>
<fieldset class="w750">
	<legend>##ADMINISTER_GUEST_CATEGORYS##</legend>
		<form id="cat" name="cat" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_catid" id="frm_catid" value="0">
		<input type="hidden" name="frm_action" id="frm_action" value="new">
		<table border="0" cellspacing="0" cellpadding="3" width="600">
		   <%if $tpl_addnew eq 'true'%>
			<tr>
				<td class="ListL1">
		  			<input type="text" name="frm_cat" id="frm_cat" maxlength="128" size="50">
		  		</td>
		  		<td class="ListL1">
					<textarea name="frm_description" id="frm_description" cols="25" rows="2"></textarea>
		  		</td>
				<td class="ListL1">
					<a href="javascript:savecat(0);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				</td>
				<td class="ListL1">&nbsp;</td>
		   </tr>
		   <%else%>
			<tr>
				<td colspan="4">
		  			<a href="javascript:neu();"><img src="<%$wwwroot%>img/button_neu.gif" width="56" height="24" border="0"></a>
		  		</td>
		  	</tr>		   
		   <%/if%>
			<%section name=cat loop=$tpl_category%>
			<tr>
				<td class="ListL<%$tpl_category[cat].color%>">
					<%if $tpl_editid eq $tpl_category[cat].catid%>
					  <input type="text" name="frm_cat" id="frm_cat" maxlength="128" size="50" value="<%$tpl_category[cat].cat%>">
					<%else%>
					  <%$tpl_category[cat].cat%>
					<%/if%>
				</td>
				<td class="ListL<%$tpl_category[cat].color%>">
					<%if $tpl_editid eq $tpl_category[cat].catid%>
					  <textarea name="frm_description" id="frm_description" cols="25" rows="2"><%$tpl_category[cat].description%></textarea>
					<%else%>
					  <%$tpl_category[cat].description%>&nbsp;
					<%/if%>
				</td>
				<td class="ListL<%$tpl_category[cat].color%>">
				<%if $tpl_editid eq $tpl_category[cat].catid%>
					<a href="javascript:savecat(<%$tpl_category[cat].catid%>);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				<%else%>
					<a href="javascript:editcat(<%$tpl_category[cat].catid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
				<%/if%>
				</td>
				<td class="ListL<%$tpl_category[cat].color%>">
					<%if $tpl_editid neq $tpl_category[cat].catid%>
						<a href="javascript:delcat(<%$tpl_category[cat].catid%>,'<%$tpl_category[cat].cat%>');"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0"></a>
					<%/if%>&nbsp;
				</td>
			</tr>
			<%/section%>
		</table>
		</form>
</fieldset>
<%include file=footer.tpl%>
<%/strip%>

