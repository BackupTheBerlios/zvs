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
<table width="400" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">##ADMINISTER_BOOKING_CATEGORYS##</p>
		<form id="cat" name="cat" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_bcatid" id="frm_bcatid" value="0">
		<input type="hidden" name="frm_action" id="frm_action" value="new">
		<table border="0" cellspacing="0" cellpadding="3" width="400">
		   <%if $tpl_addnew neq 'true'%>
			<tr>
				<td colspan="4">		  		
		  			<a href="javascript:neu();"><img src="<%$wwwroot%>img/button_neu.gif" width="56" height="24" border="0"></a>
		  		</td>
		  	</tr>		
		   <%/if%>		
			<tr>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>##LABEL##</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>##COLOR##</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>##DESCRIPTION##</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>##DURATION##</strong>
		  		</td>				
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
					&nbsp;
				</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">&nbsp;</td>
		   </tr>		
		   <%if $tpl_addnew eq 'true'%>
			<tr>
				<td class="ListL1">
		  			<input type="text" name="frm_name" id="frm_name" maxlength="128" size="50">&nbsp;
		  		</td>
				<td class="ListL1">
		  			<input type="text" name="frm_color" id="frm_color" size="7" maxlength="7"><a href="javascript:openWindow();"><img src="<%$wwwroot%>img/button_colorchooser.gif" width="16" height="15" border="0"></a>
		  		</td>
				<td class="ListL1">
		  			<textarea name="frm_description" id="frm_description" cols="25" rows="2"></textarea>&nbsp;
		  		</td>
				<td class="ListL1">
		  			<input type="text" name="frm_days" id="frm_days" size="4" maxlength="4">
		  		</td>				
				<td class="ListL1">
					<a href="javascript:savebcat(0);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				</td>
				<td class="ListL1">&nbsp;</td>
		   </tr>
            <%/if%>
			<%section name=bcat loop=$tpl_bcat%>
			<tr>
				<td class="ListL<%$tpl_bcat[bcat].color%>">
					<%if $tpl_editid eq $tpl_bcat[bcat].bcatid%>
					  <input type="text" name="frm_name" id="frm_name" maxlength="128" size="50" value="<%$tpl_bcat[bcat].name%>">
					<%else%>
					  <%$tpl_bcat[bcat].name%>
					<%/if%>
				</td>
				<td class="ListL<%$tpl_bcat[bcat].color%>">
					<%if $tpl_editid eq $tpl_bcat[bcat].bcatid%>
					  <input type="text" name="frm_color" id="frm_color" value="<%$tpl_bcat[bcat].catcolor%>" size="7" maxlength="7">
					  <a href="javascript:openWindow();"><img src="<%$wwwroot%>img/button_colorchooser.gif" width="16" height="15" border="0"></a>
					<%else%>
					  <table>
					  <tr>
					    <td class="colorchooser" bgcolor="<%$tpl_bcat[bcat].catcolor%>"><img src="<%$wwwroot%>img/spacer.gif" width="10" height="10" boder="0"></td>
					  </tr>
					  </table>
					<%/if%>
				</td>
				<td class="ListL<%$tpl_bcat[bcat].color%>">
					<%if $tpl_editid eq $tpl_bcat[bcat].bcatid%>
					  <textarea name="frm_description" id="frm_description" cols="25" rows="2"><%$tpl_bcat[bcat].description%></textarea>
					<%else%>
					  <%$tpl_bcat[bcat].description%>&nbsp;
					<%/if%>
				</td>
				<td class="ListL<%$tpl_bcat[bcat].color%>">
				<%if $tpl_editid eq $tpl_bcat[bcat].bcatid%>
		  			<input type="text" name="frm_days" id="frm_days" size="4" maxlength="4" value="<%$tpl_bcat[bcat].days%>">
				<%else%>
					<%$tpl_bcat[bcat].days%>&nbsp;
				<%/if%>
		  		</td>
				<td class="ListL<%$tpl_bcat[bcat].color%>">
				<%if $tpl_editid eq $tpl_bcat[bcat].bcatid%>
					<a href="javascript:savebcat(<%$tpl_bcat[bcat].bcatid%>);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				<%else%>
					<a href="javascript:editbcat(<%$tpl_bcat[bcat].bcatid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
				<%/if%>
				</td>
				<td class="ListL<%$tpl_bcat[bcat].color%>">
					<%if $tpl_editid neq $$tpl_bcat[bcat].bcatid%>
						<a href="javascript:delbcat(<%$tpl_bcat[bcat].bcatid%>,'<%$tpl_bcat[bcat].name%>');"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0"></a>
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

