<?php
/* @var $this CategoryController */
/* @var $data Category */
if($data->active==1){
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('страница категории по id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('список тегов товаров присутствующих в категории и список тегов отсутствующих в категории по id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('viewTags', 'id'=>$data->id)); ?>
	<br />

</div>
<?php
}
?>
