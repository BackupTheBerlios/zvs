<%strip%>
<%include file=header.tpl%>
<%/strip%>
<script language="javascript" src="<%$wwwroot%>global/md5.js"  type="text/javascript"></script>
<script language="javascript"  type="text/javascript">

<!--

  function doChallengeResponse() {

  	 var username = document.login.username;
  	 var password = document.login.password;
  	 var challenge = document.login.challenge;
  	 var response = document.login.response;
  	 var login = document.login;
    str = username.value + ":" +
          MD5(password.value) + ":" +
          challenge.value;

    response.value = MD5(str);
    password.value = "";
    login.submit();
  }
  
  function submitform(){
  	
      var login = document.login;
      login.submit();	
  	
  }

  function login_onkeypress()
  {
    if(window.event.keyCode==13)
    {
    	var login = document.login;
      login.submit();
    }
  }
  
  function next_onkeypress()
  {
    if(window.event.keyCode==13)
    {
    	var login = document.login;
      login.password.focus();
    }
  }  
  
  function next()
  {
     	var login = document.login;
      login.password.focus();
    
  }   
// -->

</script>
<%strip%>

<form id="login" name="login" action="<%$tpl_url%>" method="post" onSubmit="doChallengeResponse(); return false;">
<%$tpl_hiddenfields%>
<table width="100%" height="80%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td align="center" valign="center">
	<p  class="SubheadlineYellow">Login</p>
		<table width="250" border="0" cellspacing="0" cellpadding="0" class="Box">
		  <tr>
		    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
		    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
		    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
		  </tr>
		  <tr>
		    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
		    <td width="100%">
				<table border=0 align="center" cellspacing=0 cellpadding=4>
				 <tr valign=top align=left>
				  <td><strong>Benutzername</strong></td>
				  <td align="left"><select id="username" name="username" onChange="next();" style="width=100%">
				  					<%section name="emp" loop="$tpl_employees"%>
									<option value="<%$tpl_employees[emp].login%>" <%if $tpl_employees[emp].login eq $tpl_login%>selected="selected"<%/if%> ><%$tpl_employees[emp].login%></option>
									<%/section%>
				  					</select></td>
				 </tr>
				 <tr valign=top align=left>
				  <td><strong>Passwort</strong></td>
				  <td align="left"><input type="password" id="password" name="password" size="32" maxlength="32" onKeyPress="login_onkeypress();" value=""></td>
				 </tr>
				
				 <tr>
				  <td class="DefText">&nbsp;</td>
				  <td align=right>
				  <a href="javascript:submitform();"><img src="<%$wwwroot%>img/button_weiter.gif" width="73" height="24" alt="Login" border="0" id="loginfrm"></a>
				  </td>
				 </tr>
				
				
				<% if $tpl_issetuname eq "true" %>
				  <tr>
				   <td colspan=2 class="DefError">Entweder war der Benutzername oder das Passwort falsch.</td>
				  </tr>
				
				 <%/if%>
				</table>
				<input type="hidden" id="challenge" name="challenge" value="<%$tpl_challenge%>">
				<input type="hidden" id="response" name="response"  value="">
		
		
		    </td>
		   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
		  </tr>
		  <tr>
		    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
		    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
		    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
		  </tr>
		</table>

		</td>
	</tr>
</table>

</form>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--
  // Activate the appropriate input form field.
  var username = document.login.username;
  var password = document.login.password;

  if (username.value == '') {
    username.focus();
  } else {
    password.focus();
  }

// -->
</script>

<%strip%>
<%include file=footer.tpl%>
<%/strip%>
 
