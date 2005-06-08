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
		check = confirm("##USER## \""+ name +"\" ##REALLY_DELETE##?");
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
<table width="300" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">##ADMINISTER_EMPLOYEES##</p>
		<form id="user" name="user" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_userid" id="frm_userid" value="0">
		<input type="hidden" name="frm_action" id="frm_action" value="new">
		<input type="hidden" id="challenge" name="challenge" value="<%$tpl_challenge%>">
		<input type="hidden" id="response" name="response"  value="">		
		<table border="0" cellspacing="0" cellpadding="3" width="300">
		   <%if $tpl_addnew eq 'true'%>
			<tr>
				<td class="ListL1" colspan="3">
					<table border="0" cellpadding="3" cellspacing="0">
						<tr>
							<td><b>##FIRSTNAME##:</b> </td>
							<td><input type="text" name="frm_first" id="frm_first" value=""></td>
						</tr>
						<tr>
							<td><b>##LASTNAME##:</b> </td>
							<td><input type="text" name="frm_last" id="frm_last" value=""></td>
						</tr>
						<tr>
							<td><b>##LOGIN##:</b> </td>
							<td><input type="text" name="frm_login" id="frm_login" value=""></td>
						</tr>
						<tr>
							<td><b>##PASSWORD##:</b> </td>
							<td><input type="password" name="frm_pass" id="frm_pass" value=""></td>
						</tr>	
						<tr>
							<td><b>##HOURLY_WAGE_RATE##:</b> </td>
							<td><input type="text" name="frm_salary" id="frm_salary" value=""></td>
						</tr>													
						<tr>
						<td colspan="2" align="right"><a href="javascript:saveuser(0);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
						</td>
					</table>		  		</td>				
				<td class="ListL1">&nbsp;</td>
		   </tr>
		   <%else%>
			<tr>
				<td colspan="3">		  		
		  			<a href="javascript:neu();"><img src="<%$wwwroot%>img/button_neu.gif" width="56" height="24" border="0"></a>
		  		</td>
		  	</tr>		   
		   <%/if%>

			<%section name=user loop=$tpl_user%>
				<%if $tpl_editid neq $tpl_user[user].userid%>
				<tr>
					<td class="ListL<%$tpl_user[user].color%>"><%$tpl_user[user].lastname%>&nbsp;</td>
					<td class="ListL<%$tpl_user[user].color%>"><%$tpl_user[user].firstname%>&nbsp;</td>
					<td class="ListL<%$tpl_user[user].color%>">
					<a href="javascript:edituser(<%$tpl_user[user].userid%>);"><img src="<%$wwwroot%>img/button_bearbeiten.gif" width="98" height="24" border="0"></a>
 					</td>
					<td class="ListL<%$tpl_user[user].color%>"><a href="javascript:deluser(<%$tpl_user[user].userid%>,'<%$tpl_user[user].lastname%>, <%$tpl_user[user].firstname%>');"><img src="<%$wwwroot%>img/button_loeschen.gif" width="80" height="24" border="0"></a>
					</td>
				</tr>
				<%else%>
				<tr>
					<td class="ListL<%$tpl_user[user].color%>" colspan="4">
					<table border="0" cellpadding="3" cellspacing="0">
						<tr>
							<td><b>##FIRSTNAME##:</b> </td>
							<td><input type="text" name="frm_first" id="frm_first" value="<%$tpl_user[user].firstname%>"></td>
						</tr>
						<tr>
							<td><b>##LASTNAME##:</b> </td>
							<td><input type="text" name="frm_last" id="frm_last" value="<%$tpl_user[user].lastname%>"></td>
						</tr>
						<tr>
							<td><b>##LOGIN##:</b> </td>
							<td><input type="text" name="frm_login" id="frm_login" value="<%$tpl_user[user].login%>"></td>
						</tr>
						<tr>
							<td><b>##PASSWORD##:</b> </td>
							<td><input type="password" name="frm_pass" id="frm_pass" value=""></td>
						</tr>	
						<tr>
							<td><b>##HOURLY_WAGE_RATE##:</b> </td>
							<td><input type="text" name="frm_salary" id="frm_salary" value="<%$tpl_user[user].salary%>"></td>
						</tr>												
						<tr>
						<td colspan="2" align="right"><a href="javascript:saveuser(<%$tpl_user[user].userid%>);"><img src="<%$wwwroot%>img/button_save.gif" width="87" height="24" border="0"></a>
						</td>
					</table>
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

