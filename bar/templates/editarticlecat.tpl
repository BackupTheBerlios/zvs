<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--

	function editarticlecat(id) {
		document.articlecat.frm_articlecatid.value = id;
		document.articlecat.frm_action.value = "edit";
		document.articlecat.submit();
	}
	
	function delarticlecat(id, name) {
		var check;
		check = confirm("Artikelkategorie \""+ name +"\" wirklich löschen?");
		if (check) {
			document.articlecat.frm_articlecatid.value = id;
			document.articlecat.frm_action.value = "del";
			document.articlecat.submit();	
		}
	}	
	
	function savearticlecat(id){
	   document.articlecat.frm_articlecatid.value=id;	
    	document.articlecat.submit();
	}
	
	function neu(){
		document.articlecat.frm_articlecatid.value = 0;
		document.articlecat.frm_action.value = "addnew";
		document.articlecat.submit();
	}

//-->
</script>
<%strip%>
<table width="300" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Artikelkategorien verwalten</p>
		<form id="articlecat" name="articlecat" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_articlecatid" id="frm_articlecatid" value="0">
		<input type="hidden" name="frm_action" id="frm_action" value="new">
		<table border="0" cellspacing="0" cellpadding="3" width="300">
		  <%if $tpl_addnew neq 'true'%>
			<tr>
				<td colspan="5">		  		
		  			<a href="javascript:neu();"><img src="<%$wwwroot%>img/button_neu.gif" width="56" height="24" border="0"></a>
		  		</td>
		  	</tr>		
		   <%/if%>	
		<tr>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>Bezeichnung</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
					&nbsp;
				</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">&nbsp;</td>
		   </tr>				   
			   <%if $tpl_addnew eq 'true'%>
			<tr>
				<td class="ListL1" nowrap>
		  			<input type="text" name="frm_articlecat" id="frm_articlecat" maxlength="255" size="50" value="">&nbsp;
		  		</td>
				<td class="ListL1">
					<a href="javascript:savearticlecat(0);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				</td>
				<td class="ListL1">&nbsp;</td>
		   </tr>
            <%/if%>
			<%section name=article loop=$tpl_article%>
				<%if $tpl_editid neq $tpl_article[article].articlecatid%>
				<tr>
					<td class="ListL<%$tpl_article[article].color%>"><%$tpl_article[article].articlecat%>&nbsp;</td>
					<td class="ListL<%$tpl_article[article].color%>">
					<a href="javascript:editarticlecat(<%$tpl_article[article].articlecatid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
 					</td>
					<td class="ListL<%$tpl_article[article].color%>"><a href="javascript:delarticlecat(<%$tpl_article[article].articlecatid%>,'<%$tpl_article[article].articlecat%>');"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0"></a>
					</td>
				</tr>
				<%else%>
				<tr>
					<td class="ListL<%$tpl_article[article].color%>"><input type="text" name="frm_articlecat" id="frm_articlecat" maxlength="255" size="50" value="<%$tpl_article[article].articlecat%>">&nbsp;</td>
					<td class="ListL<%$tpl_article[article].color%>">
					<a href="javascript:savearticlecat(<%$tpl_article[article].articlecatid%>);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
 					</td>
					<td class="ListL<%$tpl_article[article].color%>">&nbsp;</a>
					</td>

				</tr>
				<%/if%>
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

