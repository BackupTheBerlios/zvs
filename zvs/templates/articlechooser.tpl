<%strip%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>
<HEAD>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2004 of Christian Ehret
-->
<title>zvs: <%$tpl_title%></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
<%/strip%>
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
<%strip%>
</HEAD>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0" onLoad="changePP(true);">
<br>
<table width="380" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
	<%if $tpl_submitted eq 'true'%>
	<%/strip%>
	<script language="JavaScript" type="text/javascript">
	<!--
		windowclose();
	//-->
	</script>
	<%strip%>
	<%/if%>
    <p class="SubheadlineYellow">##ARTICLE## ##TO_CHOOSE##</p>
		<form id="article" name="article" action="<%$SCRIPT_NAME%>" method="post">
		<input type="hidden" name="frm_id" id="frm_id" value="<%$tpl_id%>">
		<input type="hidden" name="frm_action" id="frm_action" value="add">
		<input type="hidden" name="frm_type" id="frm_type" value="<%$tpl_type%>">
		<table border="0">
		<tr>
			<td valign="top">
				<select name="frm_article" id="frm_article">
				<%section name=art loop=$tpl_article%>
					<option value="<%$tpl_article[art].articleid%>"><%$tpl_article[art].article%></option>
				<%/section%>
				</select>
			</td>
			<td valign="top">
			<input type="radio" name="frm_price_type" id="frm_price_type" value="PP" checked="checked" onclick="changePP(true);"> Pro Person
			<br>
			<input type="radio" name="frm_price_type" id="frm_price_type" value="PR" onclick="changePP(false);"> Pro Zimmer
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div id="ppoptions" style="position:relative; left:0px; top:0px; width:200px; height:25px; z-index:1; visibility: hidden;">
								<input type="checkbox" name="frm_included" id="frm_included" value="yes" checked="checked"> ##INCLUDED_IN_PRICE##
								<br>
								<input type="checkbox" name="frm_person" id="frm_person" value="true" onclick="check();"> ##ADULT##
								<br>
								<input type="checkbox" name="frm_children" id="frm_children" value="true" onclick="check();" > <%$tpl_children_field1%>
								<br>
								<input type="checkbox" name="frm_children2" id="frm_children2" value="true" onclick="check();"> <%$tpl_children_field2%>
								<br>
								<input type="checkbox" name="frm_children3" id="frm_children3" value="true" onclick="check();"> <%$tpl_children_field3%>
								<br>												
				</div>
			</td>
		</tr>

		<tr>
			<td>
				<a href="javascript:add()"><img src="<%$wwwroot%>img/shutter_plus.gif" border="0" width="13" height="13" alt="hinzuf&uuml;gen"></a>
				&nbsp;
				<a href="javascript:del()"><img src="<%$wwwroot%>img/shutter_minus.gif" border="0" width="13" height="13" alt="entfernen"></a>
			</td>
		</tr>
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
</body>
</html>
<%/strip%>
