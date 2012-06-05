<?php
$this->breadcrumbs=array(
	'Computers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Список компьютеров', 'url'=>array('index')),
	array('label'=>'Управление списком', 'url'=>array('admin')),
);
?>

<h4>Редактирование информации <?php echo $model->name; ?></h4>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>