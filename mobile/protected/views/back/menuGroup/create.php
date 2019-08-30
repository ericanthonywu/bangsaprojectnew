<?php
/* @var $this MenuGroupController */
/* @var $model MenuGroup */

$this->breadcrumbs=array(
	'Menu Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MenuGroup', 'url'=>array('index')),
	array('label'=>'Manage MenuGroup', 'url'=>array('admin')),
);
?>

<h1>Create MenuGroup</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>