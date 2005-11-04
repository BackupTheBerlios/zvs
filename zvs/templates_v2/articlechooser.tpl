<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2005 of Christian Ehret
-->
	<title>zvs: <%$tpl_title%></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<meta name="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css" media="screen">@import "<%$wwwroot%>css/global.css";</style>
<script language="JavaScript" type="text/javascript">
<!--
   function windowclose()
   {
     window.opener.location = "<%$tpl_opener%>";
     self.close();
   }
   function add()
   {
   	document.article.frm_action.value="add";
	document.article.submit();
	}
   function del()
   {
   	document.article.frm_action.value="del";
	document.article.submit();
	}	
	function check()
	{
		if (document.article.frm_person.checked == true || document.article.frm_children.checked == true || document.article.frm_children2.checked == true || document.article.frm_children3.checked == true)
		{
			document.article.frm_price_type.checked = true;
		}
	}	
function changePP(arg)
{

    if (arg == true) {
         if (document.getElementById)
         {
              document.getElementById('ppoptions').style.visibility = 'visible';
         }
         else
         {
              document.layers['ppoptions'].visibility = 'show';
         }
    }
    else
    {
         if (document.getElementById)
         {
              document.getElementById('ppoptions').style.visibility = 'hidden';
         }
         else
         {
              document.layers['ppoptions'].visibility = 'hidden';
         }
    }
}

//-->
</script>
</head>
<%strip%>
<body onLoad="changePP(true);">
<div class="popup350">
	<h2><span>##ARTICLE## ##TO_CHOOSE##</span></h2>
	<div class="table">
		<form accept-charset="utf-8" id="article" name="article" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_id" id="frm_id" value="<%$tpl_id%>"/>
		<input type="hidden" name="frm_action" id="frm_action" value="add"/>
		<input type="hidden" name="frm_type" id="frm_type" value="<%$tpl_type%>"/>
		<select name="frm_article" id="frm_article">
			<%section name=art loop=$tpl_article%>
				<option value="<%$tpl_article[art].articleid%>"><%$tpl_article[art].article%></option>
			<%/section%>
		</select>
		<br/>
		<input type="radio" name="frm_price_type" id="frm_price_type" value="PP" checked="checked" onclick="changePP(true);"/> ##PER_PERSON##
		<br/>
		<input type="radio" name="frm_price_type" id="frm_price_type" value="PR" onclick="changePP(false);"/> ##PER_ROOM##

		<div id="ppoptions" style="position:relative; left:0px; top:0px; width:200px; height:25px; z-index:1; visibility: hidden;">
			<input type="checkbox" name="frm_included" id="frm_included" value="yes" checked="checked"/> ##INCLUDED_IN_PRICE##
			<br/>
			<input type="checkbox" name="frm_person" id="frm_person" value="true" onclick="check();"/> ##ADULT##
			<br/>
			<input type="checkbox" name="frm_children" id="frm_children" value="true" onclick="check();"/> <%$tpl_children_field1%>
			<br/>
			<input type="checkbox" name="frm_children2" id="frm_children2" value="true" onclick="check();"/> <%$tpl_children_field2%>
			<br/>
			<input type="checkbox" name="frm_children3" id="frm_children3" value="true" onclick="check();"/> <%$tpl_children_field3%>
			<br/>												
		</div>
		<a href="javascript:add()" class="dotted">##ADD##</a><strong>&nbsp;&raquo;</strong>
		&nbsp;&nbsp;
		<a href="javascript:del()" class="dotted">##REMOVE##</a><strong>&nbsp;&raquo;</strong>
		</form>
		</div>
</div>		
	<%/strip%>
	<%if $tpl_submitted eq 'true'%>
	<script language="JavaScript" type="text/javascript">
	<!--
		windowclose();
	//-->
	</script>
	<%/if%>
	</body>
</html>
