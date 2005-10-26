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
		<form accept-charset="utf-8" id="cat" name="cat" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_catid" id="frm_catid" value="0"/>
		<input type="hidden" name="frm_action" id="frm_action" value="new"/>

		<%if $tpl_addnew neq 'true'%>
		  			<div id="toolbar"><span class="label">##TOOLS##:</span><a href="javascript:neu();" class="dotted">##NEW_CATEGORY##</a></div>
		<%/if%>
		<table class="list">
     <colgroup>
        <col width="200">
        <col width="350">
        <col width="100">
     </colgroup>
			
			<tr class="ListHeader">
				<th>##CATEGORY##</th>
				<th>##DESCRIPTION##</th>
				<th>&nbsp;</th>
		</tr>			
		   <%if $tpl_addnew eq 'true'%>
			<tr class="ListHighlight">
				<td>
		  			<input type="text" name="frm_cat" id="frm_cat" maxlength="128" size="30"/>
		  		</td>
		  		<td>
					<input type="text" name="frm_description" id="frm_description"  size="50" value=""/>
		  		</td>
				<td>
					<a href="javascript:savecat(0);"><span class="button">##SAVE## &raquo;</span></a>
				</td>
		   </tr>
		   <%/if%>
			<%section name=cat loop=$tpl_category%>
			<tr <%if $tpl_editid eq $tpl_category[cat].catid%>class="ListHighlight"<%else%>class="ListL<%$tpl_category[cat].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_category[cat].color%>'"<%/if%>>
				<td>
					<%if $tpl_editid eq $tpl_category[cat].catid%>
					  <input type="text" name="frm_cat" id="frm_cat" maxlength="128" size="30" value="<%$tpl_category[cat].cat%>"/>
					<%else%>
					  <a href="javascript:editcat(<%$tpl_category[cat].catid%>);" title="##EDIT##" class="dotted"><%$tpl_category[cat].cat%></a>
					<%/if%>
				</td>
				<td>
					<%if $tpl_editid eq $tpl_category[cat].catid%>
					  <input type="text" name="frm_description" id="frm_description" size="50" value"<%$tpl_category[cat].description%>"/>
					<%else%>
					  <%$tpl_category[cat].description%>&nbsp;
					<%/if%>
				</td>
				<td>
				<%if $tpl_editid eq $tpl_category[cat].catid%>
					<a href="javascript:savecat(<%$tpl_category[cat].catid%>);"><span class="button">##SAVE## &raquo;</span></a>
				<%else%>
					<a href="javascript:delcat(<%$tpl_category[cat].catid%>,'<%$tpl_category[cat].cat%>');" class="dotted">##DELETE##</a><strong>&nbsp;&raquo;</strong>
				<%/if%>
				</td>
			</tr>
			<%/section%>
		</table>
		</form>
</fieldset>
<%include file=footer.tpl%>
<%/strip%>

