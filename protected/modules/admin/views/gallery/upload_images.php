<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('gallery', 'Gallery'), array('gallery/index'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">
	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('media', "Upload images to gallery '{name}'", array('{name}' => $row->name)); ?></h2>
			<div class="content">
			
				<?php 
					$this->widget('ext.jumploader.jumploaderwidget', array( 
                        'uploadUrlAction' => $this->createUrl('gallery/uploadimages', array('gallery_id' => $row->id)), // The uploader action that will handle the uploaded files, each file will send a request to this action
                        'width'=>'100%', // sets the applet width
                        'allowedExtensions' => getParam('object_types') ? explode(',', getParam('object_types')) : array( 'jpg', 'jpeg', 'gif', 'png' ), // array of allowed extensions to upload (without the prefix dot ( . ) )
                        'height'=>600, // sets the applet height
                        //'debugMode' => 'DEBUG', // enable debug allowed options are 'INFO', 'DEBUG', 'WARN', 'ERROR', 'FATAL', You can views those logs in the Java console. Defaults to false.
                        'maxFileSize' => getParam('object_max_size') ? getParam('object_max_size') : '-1', // string that represents the maximum size of a single file uploaded, Examples: '10MB', '1024KB', '2GB' etc. Defaults to '-1' which means unlimited.
                     	'appletOptions' => array(
                        	'uc_imageEditorEnabled' => false,
                            'uc_uploadScaledImages' => true,
                            'uc_uploadScaledImagesNoZip' => true,
                            'uc_scaledInstanceNames' => getParam('objects_sizes') ? getParam('objects_sizes') : 'tiny,small,medium,large',
                            'uc_scaledInstanceDimensions' => getParam('objects_dim') ? getParam('objects_dim') : '50x50xcrop,100x100xcrop,200x200xcrop,700x700xcover',
                            'uc_scaledInstanceQualityFactors' => getParam('objects_quality') ? getParam('objects_quality') : '500,700,800,900',
                            'uc_deleteTempFilesOnRemove' => true,
                            'uc_directoriesEnabled' => true,
                            //'uc_scaledInstanceWatermarkNames' => $row->club && $row->club->watermark ? 'null,null,null,largeWatermark' : 'null,null,null,null',
                            //'largeWatermark' => 'halign=right;valign=bottom;opacityPercent=100;imageUrl=' . ( $row->club && $row->club->watermark ? $row->club->watermark : '' ),
                        ),
                     ));
				?>
			
			</div>
		</div>
	</div>
</div>