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
		check = confirm("##ARTICLE## \""+ name +"\" ##REALLY_DELETE##?\n");
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
<table width="600" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">##ARTICLE## ##ADMINISTER##</p>
		<form id="article" name="article" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_articleid" id="frm_articleid" value="0">
		<input type="hidden" name="frm_action" id="frm_action" value="new">
		<table border="0" cellspacing="0" cellpadding="3" width="600">
		   <%if $tpl_addnew neq 'true'%>
			<tr>
				<td colspan="4">		  		
		  			<a href="javascript:neu();"><img src="<%$wwwroot%>img/button_neu.gif" width="56" height="24" border="0"></a>
		  		</td>
		  	</tr>		
		   <%/if%>		
			<tr>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>##DESCRIPTION##</strong>
		  		</td>			
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>##NET_PRICE##</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>##VAT_SHORT##</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>##GROSS##</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
					&nbsp;
				</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">&nbsp;</td>
		   </tr>		
		   <%if $tpl_addnew eq 'true'%>
			<tr>
				<td class="ListL1">
		  			<input type="text" name="frm_name" id="frm_name" maxlength="128" size="50" value="">&nbsp;
		  		</td>
				<td class="ListL1">
		  			&nbsp;
		  		</td>
				<td class="ListL1">
		  			<input type="text" name="frm_mwst" id="frm_mwst" size="5" value="">&nbsp;
		  		</td>
				<td class="ListL1">
		  			<input type="text" name="frm_brutto" id="frm_brutto" size="8" value="">&nbsp;
		  		</td>				
				<td class="ListL1">
					<a href="javascript:saveart(0);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				</td>
				<td class="ListL1">&nbsp;</td>
		   </tr>
            <%/if%>
			<%section name=art loop=$tpl_article%>
			<tr>
				<td class="ListL<%$tpl_article[art].color%>">
					<%if $tpl_editid eq $tpl_article[art].articleid%>
					  <input type="text" name="frm_name" id="frm_name" maxlength="128" size="50" value="<%$tpl_article[art].article%>">
					<%else%>
					  <%$tpl_article[art].article%>&nbsp;
					<%/if%>
				</td>
				<td class="ListL<%$tpl_article[art].color%>">
					<%if $tpl_editid eq $tpl_article[art].articleid%>
					&nbsp;
					<%else%>
					  <%$tpl_article[art].price_netto%>&nbsp;
					<%/if%>
				</td>
				<td class="ListL<%$tpl_article[art].color%>">
					<%if $tpl_editid eq $tpl_article[art].articleid%>
					  <input type="text" name="frm_mwst" id="frm_mwst" size="5" value="<%$tpl_article[art].mwst%>">
					<%else%>
					  <%$tpl_article[art].mwst%>&nbsp;
					<%/if%>
				</td>
				<td class="ListL<%$tpl_article[art].color%>">
					<%if $tpl_editid eq $tpl_article[art].articleid%>
					  <input type="text" name="frm_brutto" id="frm_brutto" size="8" value="<%$tpl_article[art].price_brutto%>">
					<%else%>
					  <%$tpl_article[art].price_brutto%>&nbsp;
					<%/if%>
				</td>				
				<td class="ListL<%$tpl_article[art].color%>">
				<%if $tpl_editid eq $tpl_article[art].articleid%>
					<a href="javascript:saveart(<%$tpl_article[art].articleid%>);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				<%else%>
					<a href="javascript:editart(<%$tpl_article[art].articleid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
				<%/if%>
				</td>
				<td class="ListL<%$tpl_article[art].color%>">
					<%if $tpl_editid neq $tpl_article[art].articleid%>
						<a href="javascript:delart(<%$tpl_article[art].articleid%>,'<%$tpl_article[art].article%>');"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0"></a>
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

// 