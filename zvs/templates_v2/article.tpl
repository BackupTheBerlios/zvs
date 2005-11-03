<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--
   
	function editart(id) {
		document.article.frm_articleid.value = id;
		document.article.frm_action.value = "edit";
		document.article.submit();	
	}
	
	function delart(id, name) {
		var check;
		check = confirm("##REALLY_DELETE_ARTICLE##: \""+ name +"\" \n");
		if (check) {
			document.article.frm_articleid.value = id;
			document.article.frm_action.value = "del";
			document.article.submit();	
		}
	}	
	
	function saveart(id){
	   document.article.frm_articleid.value=id;	
		document.article.submit();
	}
	
	function neu(){
		document.article.frm_articleid.value = 0;
		document.article.frm_action.value = "addnew";
		document.article.submit();
	}

//-->
</script>
<%strip%>
<div class="box750">
	<h2><span>##ARTICLE## ##ADMINISTER##</span></h2>
	<div class="table">
		<form accept-charset="utf-8" id="article" name="article" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_articleid" id="frm_articleid" value="0"/>
		<input type="hidden" name="frm_action" id="frm_action" value="new"/>
		   <%if $tpl_addnew neq 'true'%>
		  			&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span><a href="javascript:neu();" class="dotted">##NEW_CATEGORY##</a></div>
		   <%/if%>			
		<table border="0" cellspacing="0" cellpadding="3" width="600">
		<table class="list" width="100%">
			<tr class="ListHeader">		
				<th>##DESCRIPTION##</th>
				<th>##NET_PRICE##</th>
				<th>##VAT_SHORT##</th>
				<th>##GROSS##</th>
				<th>&nbsp;</th>
			</tr>	
	   <%if $tpl_addnew eq 'true'%>
			<tr class="ListHighlight">
				<td><input type="text" name="frm_name" id="frm_name" maxlength="128" size="50" value=""/></td>
				<td>&nbsp;</td>
				<td><input type="text" name="frm_mwst" id="frm_mwst" size="5" value=""/></td>
				<td><input type="text" name="frm_brutto" id="frm_brutto" size="8" value=""/></td>				
				<td><a href="javascript:saveart(0);"><span class="button">##SAVE##</span></a></td>
		   </tr>
      <%/if%>
			<%section name=art loop=$tpl_article%>
			<tr <%if $tpl_editid eq $tpl_article[art].articleid%>class="ListHighlight"<%else%>class="ListL<%$tpl_article[art].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_article[art].color%>'"<%/if%>>
				<td>
					<%if $tpl_editid eq $tpl_article[art].articleid%>
					  <input type="text" name="frm_name" id="frm_name" maxlength="128" size="50" value="<%$tpl_article[art].article%>"/>
					<%else%>
					  <a href="javascript:editart(<%$tpl_article[art].articleid%>);" class="dotted"><%$tpl_article[art].article%></a>
					<%/if%>
				</td>
				<td>
					<%if $tpl_editid eq $tpl_article[art].articleid%>
					&nbsp;
					<%else%>
					  <%$tpl_article[art].price_netto%>
					<%/if%>
				</td>
				<td>
					<%if $tpl_editid eq $tpl_article[art].articleid%>
					  <input type="text" name="frm_mwst" id="frm_mwst" size="5" value="<%$tpl_article[art].mwst%>"/>
					<%else%>
					  <%$tpl_article[art].mwst%>
					<%/if%>
				</td>
				<td>
					<%if $tpl_editid eq $tpl_article[art].articleid%>
					  <input type="text" name="frm_brutto" id="frm_brutto" size="8" value="<%$tpl_article[art].price_brutto%>"/>
					<%else%>
					  <%$tpl_article[art].price_brutto%>
					<%/if%>
				</td>				
				<td>
				<%if $tpl_editid eq $tpl_article[art].articleid%>
					<a href="javascript:saveart(<%$tpl_article[art].articleid%>);"><span class="button">##SAVE##</span></a>
				<%else%>
					<a href="javascript:delart(<%$tpl_article[art].articleid%>,'<%$tpl_article[art].article%>');" class="dotted">##DELETE##</a><strong>&nbsp;&raquo;</strong>
					<%/if%>
				</td>
			</tr>
			<%/section%>
		</table>
		</form>
	</div>
</div>
</table>

<%include file=footer.tpl%>
<%/strip%>

// 