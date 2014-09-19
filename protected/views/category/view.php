<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'View Category Tags', 'url'=>array('viewTags', 'id'=>$model->id)),
	array('label'=>'Update Category', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Category', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
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
Список товаров:
<br>
<?php if(!empty($listProduct)) {
	foreach($listProduct as $key => $product) {
		echo ' <i>'.$product.'</i>';
		
		?> (<b>Теги:</b> <?php 
		if(!empty($listTags[$key])) {
			foreach($listTags[$key] as $keyTags=> $tags) {
					echo ' <i>'.$tags.'</i>';				
			}
		}

		?> 	<b>Другие категории:</b> <?php 
		if(!empty($listCategory[$key])) {
			foreach($listCategory[$key] as $keyCategory=> $category) {
				if($keyCategory!=$model->id) {
					echo ' <i>'.$category.'</i>';
				}
			}
		}		
		?>)<br><?php
	}
} ?>
