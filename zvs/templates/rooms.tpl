<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--

	function editroom(id) {
		document.cat.frm_roomid.value = id;
		document.cat.frm_action.value = "edit";
		document.cat.submit();	
	}
	
	function delroom(id, name) {
		var check;
		check = confirm("Zimmer \""+ name +"\" wirklich löschen?");
		if (check) {
			document.cat.frm_roomid.value = id;
			document.cat.frm_action.value = "del";
			document.cat.submit();	
		}
	}	
	
	function saveroom(id){
	   document.cat.frm_roomid.value=id;	
		document.cat.submit();
	}
	
	function neu(){
		document.cat.frm_roomid.value = 0;
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
    <p class="SubheadlineYellow">Zimmer verwalten</p>
		<form id="cat" name="cat" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_roomid" id="frm_roomid" value="0">
		<input type="hidden" name="frm_action" id="frm_action" value="new">
		<table border="0" cellspacing="0" cellpadding="3" width="750">
		   <%if $tpl_addnew neq 'true'%>
			<tr>
				<td colspan="4">		  		
		  			<a href="javascript:neu();"><img src="<%$wwwroot%>img/button_neu.gif" width="56" height="24" border="0"></a>
		  		</td>
		  	</tr>		
		   <%/if%>		
			<tr>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>Bezeichnung</strong>
		  		</td>
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>Personen</strong>
		  		</td>	
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>Kategorie</strong>
		  		</td>	                  	  		
				<td class="ListL<%if $tpl_addnew eq 'true'%>0<%else%>1<%/if%>">
		  			<strong>Info</strong>
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
		  			<input type="text" name="frm_persons" id="frm_persons" maxlength="2" size="2">&nbsp;
		  		</td>
				<td class="ListL1">
		  			<select name="frm_roomcat" id="frm_roomcat">
		  			   <%section name=roomcat loop=$tpl_roomcat%>
                       <option value="<%$tpl_roomcat[roomcat].catid%>"><%$tpl_roomcat[roomcat].name%></option>
                       <%/section%>
	  			    </select>
		  		</td>
				<td class="ListL1">
		  			<textarea name="frm_info" id="frm_info" cols="25" rows="2"></textarea>
		  		</td>                                  		  		
				<td class="ListL1">
					<a href="javascript:saveroom(0);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				</td>
				<td class="ListL1">&nbsp;</td>
		   </tr>
            <%/if%>
			<%section name=room loop=$tpl_room%>
			<tr>
				<td class="ListL<%$tpl_room[room].color%>">
					<%if $tpl_editid eq $tpl_room[room].roomid%>
					  <input type="text" name="frm_name" id="frm_name" maxlength="128" size="50" value="<%$tpl_room[room].name%>">
					<%else%>
					  <%$tpl_room[room].name%>
					<%/if%>
				</td>
				<td class="ListL<%$tpl_room[room].color%>">
					<%if $tpl_editid eq $tpl_room[room].roomid%>
					  <input type="text" name="frm_persons" id="frm_persons" maxlength="2" size="2" value="<%$tpl_room[room].persons%>">
					<%else%>
					  <%$tpl_room[room].persons%>
					<%/if%>
				</td>
				<td class="ListL<%$tpl_room[room].color%>">
					<%if $tpl_editid eq $tpl_room[room].roomid%>
    		  			<select name="frm_roomcat" id="frm_roomcat">
    		  			   <%section name=roomcat loop=$tpl_roomcat%>
                           <option value="<%$tpl_roomcat[roomcat].catid%>" <%if $tpl_roomcat[roomcat].catid eq $tpl_room[room].roomcatid%>selected<%/if%>><%$tpl_roomcat[roomcat].name%></option>
                           <%/section%>
    	  			    </select>
                    <%else%>
					  <%$tpl_room[room].catname%>&nbsp;
					<%/if%>
				</td>	 				
				<td class="ListL<%$tpl_room[room].color%>">
					<%if $tpl_editid eq $tpl_room[room].roomid%>
					  <textarea name="frm_info" id="frm_info" cols="25" rows="2"><%$tpl_room[room].info%></textarea>
					<%else%>
					  <%$tpl_room[room].info|strip%>&nbsp;
					<%/if%>
				</td>	                				
				<td class="ListL<%$tpl_room[room].color%>">
				<%if $tpl_editid eq $tpl_room[room].roomid%>
					<a href="javascript:saveroom(<%$tpl_room[room].roomid%>);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
				<%else%>
					<a href="javascript:editroom(<%$tpl_room[room].roomid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
				<%/if%>
				</td>
				<td class="ListL<%$tpl_room[room].color%>">
					<%if $tpl_editid neq $$tpl_room[room].roomid%>
						<a href="javascript:delroom(<%$tpl_room[room].roomid%>,'<%$tpl_room[room].name%>');"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0"></a>
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

