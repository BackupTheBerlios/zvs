<%strip%>
<%include file=header.tpl%>
<div id="dek"></div>
<div class="box750">
	<h2><span>##ADMINISTER_ROOM_CATEGORIES##</span></h2>
	<div class="table">
		<form accept-charset="utf-8" id="cat" name="cat" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_catid" id="frm_catid" value="0"/>
		<input type="hidden" name="frm_action" id="frm_action" value="new"/>
		   <%if $tpl_addnew neq 'true'%>
		  			&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span><a href="javascript:neu();" class="dotted">##NEW_CATEGORY##</a></div>
		   <%/if%>

		<table class="list" width="100%">
			
			<tr class="ListHeader">
				<th>##LABEL##</th>
				<th>##ARTICLE##</th>
				<th>##PRICE_SCHEMA##</th>
				<th>&nbsp;</th>
		</tr>			
	   <%if $tpl_addnew eq 'true'%>
			<tr class="ListHighlight">
				<td><input type="text" name="frm_cat" id="frm_cat" maxlength="128" size="50"/></td>
				<td>&nbsp;</td>
				<td>
		  			<select name="frm_price_type" id="frm_price_type">
						<option value="N">##PER_PERSON##</option>
						<option value="A">##PROGRESSIVE##</option>
					</select>
					&nbsp;
		  	</td>					
				<td class="ListL1"><a href="javascript:savecat(0);"><span class="button">##SAVE##</span></a></td>
		   </tr>
		   <%/if%>		   			   
			<%section name=cat loop=$tpl_category%>
			<tr <%if $tpl_editid eq $tpl_category[cat].catid%>class="ListHighlight"<%else%>class="ListL<%$tpl_category[cat].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_category[cat].color%>'"<%/if%>>
				<td>
					<%if $tpl_editid eq $tpl_category[cat].catid%>
					  <input type="text" name="frm_cat" id="frm_cat" maxlength="128" size="50" value="<%$tpl_category[cat].name%>"/>
					<%else%>
					  <a href="javascript:editcat(<%$tpl_category[cat].catid%>);" class="dotted"><%$tpl_category[cat].name%></a>
					<%/if%>
				</td>
				<td>
					<%if $tpl_editid eq $tpl_category[cat].catid%>
					
					<%else%>
					<%$tpl_category[cat].articles%>
					<a href="javascript:openWindow('<%$wwwroot%>articlechooser.php/id.<%$tpl_category[cat].catid%>/type.rcat/articlechooser.php');" class="dotted"><%if $tpl_category[cat].articles neq ""%><br/>##EDIT##<%else%>##ADD##<%/if%></a>					
					<%/if%>
					</td>
				<td>
					<%if $tpl_editid eq $tpl_category[cat].catid%>
			  			<select name="frm_price_type" id="frm_price_type">
							<option value="N" <%if $tpl_category[cat].price_type eq 'N'%>selected="selected"<%/if%>>##PER_PERSON##</option>
							<option value="A" <%if $tpl_category[cat].price_type eq 'A'%>selected="selected"<%/if%>>##PROGRESSIVE##</option>
						</select>					
					<%else%>
					  <%if $tpl_category[cat].price_type eq 'N'%>##PER_PERSON##<%else%>##PROGRESSIVE##<%/if%>
					<%/if%>
				</td>		
				<td>
				<%if $tpl_editid eq $tpl_category[cat].catid%>
					<a href="javascript:savecat(<%$tpl_category[cat].catid%>);"><span class="button">##SAVE##</span></a>
				<%else%>
				<a href="javascript:delcat(<%$tpl_category[cat].catid%>,'<%$tpl_category[cat].name%>');" class="dotted">##DELETE##</a><strong>&nbsp;&raquo;</strong>
				<%/if%>
				</td>
			</tr>
			<%/section%>
		</table>
		</form>
</div>
</div>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--
	var offsetxpoint=-60; //Customize x offset of tooltip
	var offsetypoint=20; //Customize y offset of tooltip
	var ie=document.all;
	var ns6=document.getElementById && !document.all;
	var enabletip=false;
	if (ie||ns6)
	var tipobj=document.all? document.all["dek"] : document.getElementById? document.getElementById("dek") : "";
	
	document.onmousemove=positiontip;
	
  function openWindow(url){
    F1 = window.open(url,'articlechooser','width=400,height=300,left=0,top=0');
    F1.focus();
    }
	
	function editcat(id) {
		document.cat.frm_catid.value = id;
		document.cat.frm_action.value = "edit";
		document.cat.submit();	
	}
	
	function delcat(id, name) {
		var check;
		check = confirm("##REALLY_DELETE_CATEGORY##: \""+ name +"\"\n");
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
<%include file=footer.tpl%>
<%/strip%>

