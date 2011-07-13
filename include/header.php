<div id="window_mes" class="window">
</div>
<div class="modal">
	<div class="title_modal">
		<div id="title_text"></div>
		<a href=# class="title_modal_icon" id="close_a"></a>
	</div>
		<div id="modal_window" class="window2">
	</div>
</div>
<script type="text/javascript"> 
$(document).ready(function () {
 	$('a.header_button').click(function () {		
		$('.header_dialog-overlay, .header_dialog-box').hide();		
		return false;
	});

	$(window).resize(function () {
		if (!$('.header_dialog-box').is(':hidden')) login();		
	});
	$('#loading').hide();
});
 
function login() {
	var maskHeight = $(document).height();  
	var maskWidth = $(window).width();
	var dialogTop =  200;  
	var dialogLeft = (maskWidth/2) - ($('.header_dialog-box').width()/2); 
	
	$('.header_dialog-overlay').css({height:maskHeight, width:maskWidth}).show();
	$('.header_dialog-box').css({top:dialogTop, left:dialogLeft}).show();		
}

</script> 

<div class="header_dialog-overlay"></div> 

<div class="header_dialog-box"> 
	<a href="#" class="header_button ico"></a> 
	<div class="header_dialog-content">
		<div class="dialog-message">
		<?php 	require_once("include/login_form.php");	?>
		</div> 
	</div> 
</div> 

<div class="main_header">
	<div class="header_parent">
			<div class="header_child">
			<p>HARVESTER</p>
			</div>
			<div class="header_ico">
			<a href="home" class="home ico" title="На главную"></a>
			<a href="menu" class=" menu ico"  title="Меню"></a>
			<a href="javascript:login()" <?php if (isset($_SESSION[user])){ ?> class="loginON ico" title="Выход" <?php; } else ?> class="loginOFF ico" title="Вход" <?php;  ?> ></a>
			<span class="header_user"><?php if (isset($_SESSION[user])) {echo"<a href=\"index.php?content=panel_admin\">$_SESSION[user] </a>";} else echo"Гость";?></span>
			</div>
	</div>
	<div id="loading"></div><div id="sm"></div>
</div>

