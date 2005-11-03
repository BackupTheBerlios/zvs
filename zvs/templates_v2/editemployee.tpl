<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="javascript" src="<%$wwwroot%>global/md5.js"  type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--

  function doChallengeResponse() {

  	 var username = document.user.frm_login;
  	 var password = document.user.frm_pass;
  	 var challenge = document.user.challenge;
  	 var response = document.user.response;
  	 var user = document.user;

    response.value = MD5(password.value);
    password.value = "";
    user.submit();
  }
  
  function submitform(){
  	
      var user = document.user;
      user.submit();	
  	
  }

	function edituser(id) {
		document.user.frm_userid.value = id;
		document.user.frm_action.value = "edit";
		document.user.submit();
	}
	
	function deluser(id, name) {
		var check;
		check = confirm("##REALLY_DELETE_USER##: \""+ name +"\"");
		if (check) {
			document.user.frm_userid.value = id;
			document.user.frm_action.value = "del";
			document.user.submit();	
		}
	}	
	
	function saveuser(id){
	   document.user.frm_userid.value=id;	
	   doChallengeResponse();
		document.user.submit();
	}
	
	function neu(){
		document.user.frm_userid.value = 0;
		document.user.frm_action.value = "addnew";
		document.user.submit();
	}

//-->
</script>
<%strip%>
<div class="box750">
	<h2><span>##ADMINISTER_EMPLOYEES##</span></h2>
	<div class="table">
		<form accept-charset="utf-8" id="user" name="user" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_userid" id="frm_userid" value="0"/>
		<input type="hidden" name="frm_action" id="frm_action" value="new"/>
		<input type="hidden" id="challenge" name="challenge" value="<%$tpl_challenge%>"/>
		<input type="hidden" id="response" name="response"  value=""/>		
		   <%if $tpl_addnew neq 'true'%>
		  			&nbsp;<div id="toolbar"><span class="label">##TOOLS##:</span><a href="javascript:neu();" class="dotted">##NEW_CATEGORY##</a></div>
		   <%/if%>			
		<table class="list" width="100%">
			<tr class="ListHeader">		
				<th>##FIRSTNAME##</th>
				<th>##LASTNAME##</th>
				<th>##LOGIN##</th>
				<th>##PASSWORD##</th>
				<th>##HOURLY_WAGE_RATE##</th>
				<th>&nbsp;</th>
			</tr>
	   <%if $tpl_addnew eq 'true'%>
			<tr class="ListHighlight">
				<td><input type="text" name="frm_first" id="frm_first" value=""/></td>
				<td><input type="text" name="frm_last" id="frm_last" value=""/></td>
				<td><input type="text" name="frm_login" id="frm_login" value=""/></td>
				<td><input type="password" name="frm_pass" id="frm_pass" value=""/></td>
				<td><input type="text" name="frm_salary" id="frm_salary" value=""/></td>
				<td><a href="javascript:saveuser(0);"><span class="button">##SAVE##</span></a></td>
		   </tr>
	   <%/if%>
			<%section name=user loop=$tpl_user%>
				<tr <%if $tpl_editid eq $tpl_user[user].userid%>class="ListHighlight"<%else%>class="ListL<%$tpl_user[user].color%>" onMouseOver="this.className='ListHighlight'" onMouseOut="this.className='ListL<%$tpl_user[user].color%>'"<%/if%>>
					<td><%if $tpl_editid eq $tpl_user[user].userid%>
						<input type="text" name="frm_first" id="frm_first" value="<%$tpl_user[user].firstname%>"/>
					<%else%>
						<a href="javascript:edituser(<%$tpl_user[user].userid%>);" class="dotted"><%$tpl_user[user].lastname%></a>
					<%/if%></td>
					<td><%if $tpl_editid eq $tpl_user[user].userid%>
						<input type="text" name="frm_last" id="frm_last" value="<%$tpl_user[user].lastname%>"/>
						<%else%>
						<a href="javascript:edituser(<%$tpl_user[user].userid%>);" class="dotted"><%$tpl_user[user].firstname%></a>
						<%/if%>
						</td>
					<td><%if $tpl_editid eq $tpl_user[user].userid%>
							<input type="text" name="frm_login" id="frm_login" value="<%$tpl_user[user].login%>"/>
						<%else%>
							<%$tpl_user[user].login%>
						<%/if%>					
 					</td>
					<td><%if $tpl_editid eq $tpl_user[user].userid%>
						<input type="password" name="frm_pass" id="frm_pass" value=""/>
						<%else%>
							&nbsp;
						<%/if%>					
 					</td>
					<td><%if $tpl_editid eq $tpl_user[user].userid%>
						<input type="text" name="frm_salary" id="frm_salary" value="<%$tpl_user[user].salary%>">
						<%else%>
							<%$tpl_user[user].salary%>
						<%/if%>					
 					</td> 					
					<td><%if $tpl_editid eq $tpl_user[user].userid%>
							<a href="javascript:saveuser(<%$tpl_user[user].userid%>);"><span class="button">##SAVE##</span></a>						
						<%else%>
							<a href="javascript:deluser(<%$tpl_user[user].userid%>,'<%$tpl_user[user].lastname%>, <%$tpl_user[user].firstname%>');" class="dotted">##DELETE##</a><strong>&nbsp;&raquo;</strong>
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

