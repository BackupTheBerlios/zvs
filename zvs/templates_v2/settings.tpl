<%strip%>
<%include file=header.tpl%>
<div class="box400">
	<h2><span>##CATEGORIES##</span></h2>
	<div class="table">
	<ul class="buttonlist">
		<li><a href="<%$wwwroot%>category.php">##GUESTS##</a></li>
		<li><a href="<%$wwwroot%>roomcategory.php">##ROOMS##</a></li>
		<li><a href="<%$wwwroot%>bookingcat.php">##BOOKING##</a></li>
		<li><a href="<%$wwwroot%>paytypes.php">##PAYMENT##</a></li>
	</ul>
	</div>
</div>
<br/>
<div class="box400">
	<h2><span>##SYSTEM_SETTINGS##</span></h2>
	<div class="table">
	<ul class="buttonlist">
		<li><a href="<%$wwwroot%>rooms.php">##ROOMS##</a></li>
		<li><a href="<%$wwwroot%>season.php">##SEASON##</a></li>
		<li><a href="<%$wwwroot%>price.php">##ROOM_PRICES##</a></li>
		<li><a href="<%$wwwroot%>article.php">##ARTICLE##</a></li>
		<li><a href="<%$wwwroot%>edituser.php">##USER##</a></li>
		<li><a href="<%$wwwroot%>editemployee.php">##EMPLOYEES##</a></li>
		<li><a href="<%$wwwroot%>systemsettings.php">##SYSTEM##</a></li>
		<li><a href="<%$wwwroot%>database.php">##DATABASE##</a></li>
	</ul>
	</div>
</div>
<%include file=footer.tpl%>
<%/strip%>

