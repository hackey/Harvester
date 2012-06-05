<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'computers-form',	
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array('class'=>'nice custom'),
)); ?>

	<div class="alert-box">Поля отмеченые <span class="highlight">*</span> обязательны к заполнению.</div>

	<?php echo $form->errorSummary($model,null,null,$htmlOptions=array('class'=>'alert-box')); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>20,'class'=>'input-text')); ?>
		<?php echo $form->error($model,'name',$htmlOptions=array('class'=>'alert-box error')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ip'); ?>
		<?php 
		$model->ip=long2ip($model->ip);
		echo $form->textField($model,'ip',array('size'=>11,'maxlength'=>11,'class'=>'input-text')); ?>
		<?php echo $form->error($model,'ip',$htmlOptions=array('class'=>'alert-box error')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Domain'); ?>
		<?php echo $form->textField($model,'Domain',array('size'=>60,'maxlength'=>63,'class'=>'input-text')); ?>
		<?php echo $form->error($model,'Domain',$htmlOptions=array('class'=>'alert-box error')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Department'); ?>
		<?php 
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'id'=>'Computers_Department',
				'model'=>$model,
				'name'=>'Computers[Department]',
				'value'=>$model->Department,
				'source'=>$this->createUrl('Computers/SuggestDepartments'),
				// additional javascript options for the autocomplete plugin
				'options'=>array(
						'showAnim'=>'fold',
				),
				'htmlOptions'=>array('class'=>'input-text'),
			));
		?>
		<?php echo $form->error($model,'Department',$htmlOptions=array('class'=>'alert-box error')); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'user'); ?>
		<?php echo $form->textField($model,'user',array('maxlength'=>100,'class'=>'input-text')); ?>
		<?php echo $form->error($model,'user',$htmlOptions=array('class'=>'alert-box error')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Изменить',array('class'=>'button nice white')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->