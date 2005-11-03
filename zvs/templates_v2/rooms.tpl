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
		check = confirm("##REALLY_DELETE_ROOM##: \""+ name +"\"");
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
<div class="box750">
	<h2><span>##ADMINISTER_ROOMS##</span></h2>
	<div class="table">
		<form accept-charset="utf-8" id="cat" name="cat" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_roomid" id="frm_roomid" value="0"/>
		<input type="hidden" name="frm_action" id="frm_action" value="new"/>
		   <%if $tpl_addnew neq 'true'%>
		  			&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span><a href="javascript:neu();" class="dotted">##NEW_CATEGORY##</a></div>
		   <%/if%>					
		<table class="list" width="100%">
			<tr class="ListHeader">		
				<th>##LABEL##</th>
				<th>##PERSONS##</th>
				<th>##CATEGORY##</th>
				<th>##INFO##</th>
				<th>&nbsp;</th>
			</tr>
 	   <%if $tpl_addnew eq 'true'%>
			<tr class="ListHighlight">
				<td><input type="text" name="frm_name" id="frm_name" maxlength="128" size="50"/></td>
				<td><input type="text" name="frm_persons" id="frm_persons" maxlength="2" size="2"/></td>
				<td>
		  			<select name="frm_roomcat" id="frm_roomcat">
		  			   <%section name=roomcat loop=$tpl_roomcat%>
                       <option value="<%$tpl_roomcat[roomcat].catid%>"><%$tpl_roomcat[roomcat].name%></option>
                       <%/section%>
	  			    </select>
		  		</td>
				<td>
		  			<textarea name="frm_info" id="frm_info" cols="25" rows="2"></textarea>
		  	</td>                                  		  		
				<td>
					<a href="javascript:saveroom(0);"><span class="button">##SAVE##</span></a>
				</td>
		   </tr>
       <%/if%>
			<%section name=room loop=$tpl_room%>
			<tr <%if $tpl_editid eq $tpl_room[room].roomid%>class="ListHighlight"<%else%>class="ListL<%$tpl_room[room].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_room[room].color%>'"<%/if%>>
				<td>
					<%if $tpl_editid eq $tpl_room[room].roomid%>
					  <input type="text" name="frm_name" id="frm_name" maxlength="128" size="50" value="<%$tpl_room[room].name%>"/>
					<%else%>
					  <a href="javascript:editroom(<%$tpl_room[room].roomid%>);" class="dotted"><%$tpl_room[room].name%></a>
					<%/if%>
				</td>
				<td>
					<%if $tpl_editid eq $tpl_room[room].roomid%>
					  <input type="text" name="frm_persons" id="frm_persons" maxlength="2" size="2" value="<%$tpl_room[room].persons%>"/>
					<%else%>
					  <%$tpl_room[room].persons%>
					<%/if%>
				</td>
				<td>
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
				<td>
					<%if $tpl_editid eq $tpl_room[room].roomid%>
					  <textarea name="frm_info" id="frm_info" cols="25" rows="2"><%$tpl_room[room].info%></textarea>
					<%else%>
					  <%$tpl_room[room].info|strip%>&nbsp;
					<%/if%>
				</td>	                				
				<td>
				<%if $tpl_editid eq $tpl_room[room].roomid%>
					<a href="javascript:saveroom(<%$tpl_room[room].roomid%>);"><span class="button">##SAVE##</span></a>
				<%else%>
						<a href="javascript:delroom(<%$tpl_room[room].roomid%>,'<%$tpl_room[room].name%>');" class="dotted">##DELETE##</a><strong>&nbsp;&raquo;</strong>
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

