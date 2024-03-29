<?php
/* @var $this ModuleNewsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Berita',
);
?>
<div class="form-group" style="overflow:hidden;">
	<h1>Berita</h1>
	<div class="pull-right">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div>
	<a class="btn btn-default" href="<?php echo Yii::app()->createUrl('news/create'); ?>">Tambah Berita</a>
</div>
	<?php 
		$messages = Yii::app()->user->getFlashes();
		foreach($messages as $key => $message):?>
		<div class="alert alert-dismissable alert-<?php echo $key; ?>">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?php echo $message; ?>
		</div>
	<?php endforeach; ?>
	<?php $this->renderPartial('_news', array('model'=>$model)); ?>