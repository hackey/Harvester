<?php
$this->breadcrumbs=array(
	'Компьютеры'=>array('index'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Список компьютеров', 'url'=>array('index')),
	array('label'=>'Управление списком', 'url'=>array('admin')),
);
?>

<h4>Создание нового компьютера</h4>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>