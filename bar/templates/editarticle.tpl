<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--

	function editarticle(id) {
		document.article.frm_articleid.value = id;
		document.article.frm_action.value = "edit";
		document.article.submit();
	}
	
	function delarticle(id, name) {
		var check;
		check = confirm("Artikel \""+ name +"\" wirklich löschen?");
		if (check) {
			document.article.frm_articleid.value = id;
			document.article.frm_action.value = "del";
			document.article.submit();	
		}
	}	
	
	function savearticle(id){
	   document.article.frm_articleid.value=id;	
    	document.article.submit();
	}
	
	function neu(){
		document.article.frm_articleid.value = 0;
		document.article.frm_action.value = "addnew";
		document.article.submit();
	}


	function saveperiod(){
		document.article.frm_action.value = "saveupdatePeriod";
		document.article.submit();
	}
	
//-->
</script>
<%strip%>
<table width="700" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
	<form id="article" name="article" action="<%$SCRIPT_NAME%>" method="post">
	<input type="hidden" name="frm_theperiodid" id="frm_theperiodid" value="<%$tpl_theperiod%>">
    <p class="SubheadlineYellow">Artikel verwalten</p>
	<table border="0">
	<tr>
	<td>
	<select name="frm_period" id="frm_period" onchange="document.article.frm_action.value='changeperiod';document.article.submit();">
	<option value="-1">neue Preisliste erstellen</option>
	<%section name="period" loop=$tpl_period%>
    <option value="<%$tpl_period[period].periodid%>" <%if $tpl_period[period].periodid eq $tpl_theperiod%>selected="selected"<%/if%>><%$tpl_period[period].period%></option>
	<%/section%>
	</select></td>
	<td>Bezeichnung:&nbsp;<input type="text" name="frm_perioddesc" id="frm_perioddesc" maxlength="50" size="20" value="<%$tpl_selectedPeriod.period%>"></td>
	<td><%if $tpl_selectedPeriod.active%><input type="hidden" name="frm_periodact" id="frm_periodact" value="true"> <%/if%>aktuell:&nbsp;<input type="checkbox" name="frm_periodact<%if $tpl_selectedPeriod.active%>_dummy<%/if%>" id="frm_periodact<%if $tpl_selectedPeriod.active%>_dummy<%/if%>" value="true" <%if $tpl_selectedPeriod.active%>checked="checked" disabled="disabled"<%/if%>></td>
	<%if $tpl_theperiod eq -1%><td>
	<select name="frm_cpyperiod" id="frm_cpyperiod">
	<option value="-1">keine Artikel kopieren</option>
	<%section name="period" loop=$tpl_period%>
    <option value="<%$tpl_period[period].periodid%>"><%$tpl_period[period].period%></option>
	<%/section%>
	</select>	
	</td>
	<%else%>
	<td><input type="hidden" name="frm_cpyperiod" id="frm_cpyperiod" value="-1"></td>
	<%/if%>
	<td><a href="javascript:saveperiod();"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a></td>
	</tr>
	</table>
	<br>
		<input type="hidden" name="frm_articleid" id="frm_articleid" value="0">
		<input type="hidden" name="frm_action" id="frm_action" value="new">
		<table border="0" cellspacing="0" cellpadding="3" width="680">
		  <%if $tpl_addnew neq 'true' and $tpl_theperiod neq -1%>
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
		  			<strong>Preis</strong>
		  		</td>	
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>Hotkey</strong>
		  		</td>	
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>Artikelkategorie</strong>
		  		</td>				                  	  		
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
					&nbsp;
				</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">&nbsp;</td>
		   </tr>				   
			   <%if $tpl_addnew eq 'true'%>
			<tr>
				<td class="ListL1" nowrap>
		  			<input type="text" name="frm_description" id="frm_description" maxlength="255" size="50" value="">&nbsp;
		  		</td>
				<td class="ListL1" nowrap>
		  			<input type="text" name="frm_price" id="frm_price" maxlength="6" size="6" value="0.00"> EUR&nbsp;
		  		</td>
				<td class="ListL1">
		  			ALT+<input type="text" name="frm_hotkey" id="frm_hotkey" maxlength="1" size="1" value="">
		  		</td>
				<td class="ListL1">
				<select name="frm_cat" id="frm_cat">
																			<%section name=cat loop=$tpl_cat%>
																				<option value="<%$tpl_cat[cat].articlecatid%>" <%if $tpl_article[article].catid eq $tpl_cat[cat].articlecatid%>selected<%/if%>><%$tpl_cat[cat].articlecat%></option>
																			<%/section%>
																			</select>
				</td>
				<td class="ListL1">
					<a href="javascript:savearticle(0);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				</td>
				<td class="ListL1">&nbsp;</td>
		   </tr>
            <%/if%>
			<%section name=article loop=$tpl_article%>
				<%if $tpl_editid neq $tpl_article[article].articleid%>
				<tr>
					<td class="ListL<%$tpl_article[article].color%>"><%$tpl_article[article].description%>&nbsp;</td>
					<td class="ListL<%$tpl_article[article].color%>" nowrap><%$tpl_article[article].price%>&nbsp;EUR&nbsp;</td>
					<td class="ListL<%$tpl_article[article].color%>" nowrap>ALT+<%$tpl_article[article].hotkey%>&nbsp;</td>
					<td class="ListL<%$tpl_article[article].color%>" nowrap><%$tpl_article[article].cat%>&nbsp;</td>
					<td class="ListL<%$tpl_article[article].color%>">
					<a href="javascript:editarticle(<%$tpl_article[article].articleid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
 					</td>
					<td class="ListL<%$tpl_article[article].color%>"><a href="javascript:delarticle(<%$tpl_article[article].articleid%>,'<%$tpl_article[article].description%>');"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0"></a>
					</td>
				</tr>
				<%else%>
				<tr>
					<td class="ListL<%$tpl_article[article].color%>"><input type="text" name="frm_description" id="frm_description" maxlength="255" size="50" value="<%$tpl_article[article].description%>">&nbsp;</td>
					<td class="ListL<%$tpl_article[article].color%>" nowrap><input type="text" name="frm_price" id="frm_price" maxlength="6" size="6" value="<%$tpl_article[article].price%>"> EUR&nbsp;</td>
					<td class="ListL<%$tpl_article[article].color%>" nowrap>ALT+<input type="text" name="frm_hotkey" id="frm_hotkey" maxlength="1" size="1" value="<%$tpl_article[article].hotkey%>">&nbsp;</td>
					<td class="ListL<%$tpl_article[article].color%>" nowrap><select name="frm_cat" id="frm_cat">
																			<%section name=cat loop=$tpl_cat%>
																				<option value="<%$tpl_cat[cat].articlecatid%>" <%if $tpl_article[article].catid eq $tpl_cat[cat].articlecatid%>selected<%/if%>><%$tpl_cat[cat].articlecat%></option>
																			<%/section%>
																			</select>&nbsp;</td>
					<td class="ListL<%$tpl_article[article].color%>">
					<a href="javascript:savearticle(<%$tpl_article[article].articleid%>);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
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

