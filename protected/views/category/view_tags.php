<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Update Product', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Product', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>View Category #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'active',
	),
)); ?>

<br>
Теги товаров присутствующих в категории:
<br>
<?php 
		if(!empty($listTags)) {
			foreach($listTags as $tag) {				
					echo ' <i>'.$tag.'</i><br>';				
			}
		}
?>
<br>
Теги товаров отсутствующих в категории:
<br>
<?php 
		if(!empty($listNoTags)) {
			foreach($listNoTags as $tagNo) {				
					echo ' <i>'.$tagNo.'</i><br>';				
			}
		}
?>
