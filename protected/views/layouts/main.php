<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="ru"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="ru"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="ru"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="ru"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />
	<meta name="language" content="ru" />
	<meta name="description" content="" />
	<meta name="author" content="Tkachenko Evgeniy" />	
	<?php
    $cs = Yii::app()->clientScript;
    $cs->registerCssFile(Yii::app()->baseUrl . '/css/foundation.css');
    $cs->registerCssFile(Yii::app()->baseUrl . '/css/main.css');
	?>
	<!--[if IE ]>
		<link rel="stylesheet" type="text/css" href="/css/ie.css">
	<![endif]-->	
	<link rel="shortcut icon" href="/favicon.ico">
	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<header class="row">	
		<p>
		<h3 class="left headerTitle">
		Инвентаризация сети <a href="http://10.178.4.2/" title="сайт ВТС" >ВТС</a>
		</h3>
		<nav class="right">
			<?php 			
			$this->widget('zii.widgets.CMenu',array(
				'items'=>array(				
					array('url'=>array('/site/menu'), 'linkOptions'=>array('class'=>'menu ico')),
					array('url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest, 'linkOptions'=>array ('class'=>' loginOFF ico')),
					array('url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest, 'linkOptions'=>array('class'=>'loginON ico')),
					array('label'=>Yii::app()->user->name,'url'=>array('/user/profile'), 'visible'=>!Yii::app()->user->isGuest,'linkOptions'=>array('class'=>'headerTitle user-name')),					
				),
				'itemCssClass'=>'left'				
			)); 
			?>	
		</nav>
		<p>
</header>

<div class="row">
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
		'tagName'=>'ul',
		'separator'=>'&nbsp;&nbsp;/&nbsp;&nbsp;',
		// 'htmlOptions'=>array('class'=>'breadcrumbs'),
	)); ?>	
</div>


<div class="row">
	<div class="panel">
		
		<?php echo $content; ?>	
	
		<footer class="row">	
			<p>
			<hr />			
			Информация на этом сайте предназначена только для <?php echo CHtml::link('зарегистрированных пользователей',array('/user/registration')); ?> .<br/>Чтобы получить доступ, обратитесь в <a href="http://10.178.4.2/str_asu1.html">Лабораторию АСУ</a>, филиал &laquo;Витебские тепловые сети&raquo;, РУП &laquo;Витебскэнерго&raquo; 
			<p>2010 - <?php echo date("Y") ?></p>
			</p>
		</footer>
		
	</div>
</div>
<?php 
$cs->registerCoreScript('jquery');
$cs->registerScriptFile(Yii::app()->baseUrl .'/javascripts/modernizr.foundation.js');
$cs->registerScriptFile(Yii::app()->baseUrl .'/javascripts/foundation.js');
$cs->registerScriptFile(Yii::app()->baseUrl .'/javascripts/app.js');
?>
</body>
</html>
