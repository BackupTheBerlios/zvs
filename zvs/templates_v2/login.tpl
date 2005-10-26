<%include file=header.tpl%>
<%strip%>

<form accept-charset="utf-8" id="login" name="login" action="<%$tpl_url%>" method="post" onSubmit="doChallengeResponse(); return false;">
<%$tpl_hiddenfields%>
<input type="hidden" id="challenge" name="challenge" value="<%$tpl_challenge%>"/>
<input type="hidden" id="response" name="response"  value=""/>

<fieldset class="w400">
	<legend>##LOGIN##</legend>
	<label for="username">##LOGINNAME##</label>
	<input type="text" id="username" name="username" maxlength="128" value="<%$tpl_login%>" onKeyPress="next_onkeypress();" class="text" tabindex="1"/>
	<br/> 
	<label for="password">##PASSWORD##</label>
	<input type="password" id="password" name="password" maxlength="32" onKeyPress="login_onkeypress();" value="" class="text" tabindex="2"/><br/> 
	<%if $tpl_issetuname eq "true" %>
		<span class="error">##LOGIN_ERROR##</span>
	<%/if%>
	<p class="right"><input type="submit" value="##LOGIN## &raquo;" class="right"/></p>
</fieldset>
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
// -->
</script>
<%include file=footer.tpl%>

 
