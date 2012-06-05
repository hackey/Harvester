<?php
$this->breadcrumbs=array(
	'Меню'=>array('/site/menu'),
	'Компьютеры',
);

$this->menu=array(
	array('label'=>'Создать компьютер', 'url'=>array('create')),	
	array('label'=>'Компьютеры онлайн', 'url'=>array('scanner')),
);
?>

<h4>Список компьютеров из БД</h4>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('computers-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<p><a id="SH" href="#" onclick="fullView()"> Растянуть </a></p>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-grid',		
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText' => 'Отображены компьютеры с {start} по {end} из {count}',
	'columns'=>array(		
		array(
			'name'=>'name',
			'type'=>'raw',
			'value'=>'CHtml::link($data->name, array("view","id"=>$data->id))',			
		),
		'Department',
		array(
			'name'=>'ip',
			'type'=>'raw',
			'value' =>'long2ip($data->ip)',			
		),
        'user',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
			'visible'=> (Yii::app()->user->isGuest) ? false : true, 
		),		
	),
)); 

Yii::app()->clientScript->registerScript('IndexScript', <<<Script
	
	function fullView() {
		if ($('#SH').text()=='Восстановить') {
			$('aside.three').show()
			$('div.columns').width('70%')			
			$('#SH').text('Растянуть')
		} else {
			$('#SH').text('Восстановить')
			$('aside.three').hide()			
			$('div.columns').width('100%')
		}		
	}
Script
,CClientScript::POS_HEAD);
?>