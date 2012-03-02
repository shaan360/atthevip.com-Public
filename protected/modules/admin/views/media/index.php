<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('media', 'Media Manager'), array('media/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('media', 'Rackspace Files'), array('media/rackspace'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">
	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('media', 'Media Manager'); ?></h2>
			<div class="content">
				<div id="elfinder"></div>
			</div>
		</div>
	</div>
</div>

<?php $this->widget('application.widgets.elfinder.FinderWidget', array('path' => getUploadsPath(), 'url' => getUploadsUrl(), 'action' => $this->createUrl('media/elfinder.connector'))); ?>