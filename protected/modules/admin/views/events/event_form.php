<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('events', 'Events'), array('events/index'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo $label; ?></h2>
			<div class="content">
		
				<?php echo CHtml::form(null, 'post', array('class' => 'styled')); ?>
				<fieldset>
				
				<label for="<?php echo get_class($model) . '_title'; ?>">
					<span><?php echo $model->getAttributeLabel('title'); ?></span>
					<?php echo CHtml::activeTextField($model, 'title', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'title', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_date'; ?>">
					<span><?php echo $model->getAttributeLabel('date'); ?></span>
					<?php $model->date = $model->getEventDate(); ?>
					<?php 
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						    'attribute'=>'date',
						    'model' => $model,
						    // additional javascript options for the date picker plugin
						    'options'=>array(
						        'showAnim'=>'fold',
						    ),
						    'htmlOptions'=>array(
						        'class'=>'textbox'
						    ),
						));
					 ?>
					<?php echo CHtml::error($model, 'date', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_is_public'; ?>">
					<span><?php echo $model->getAttributeLabel('is_public'); ?></span>
					<?php echo CHtml::activeCheckBox($model, 'is_public', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'is_public', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_location'; ?>">
					<span><?php echo $model->getAttributeLabel('location'); ?></span>
					<?php echo CHtml::activeTextField($model, 'location', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'location', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_club_id'; ?>">
					<span><?php echo $model->getAttributeLabel('club_id'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'club_id', Club::model()->getClubsList(), array( 'prompt' => Yii::t('admin', '-- Choose Value --'), 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'club_id', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_description'; ?>">
					<span><?php echo $model->getAttributeLabel('description'); ?></span>
					<?php echo CHtml::activeTextField($model, 'description', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'description', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_cover'; ?>">
					<span><?php echo $model->getAttributeLabel('cover'); ?></span>
					<?php echo CHtml::activeTextField($model, 'cover', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'cover', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_large_cover'; ?>">
					<span><?php echo $model->getAttributeLabel('large_cover'); ?></span>
					<?php echo CHtml::activeTextField($model, 'large_cover', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'large_cover', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_content'; ?>">
					<span><?php echo $model->getAttributeLabel('content'); ?></span>
					<?php echo CHtml::error($model, 'content', array( 'class' => 'input-error' )); ?>
					<div>
						<?php $this->widget('application.widgets.ckeditor.CKEditor', array( 'model' => $model, 'attribute' => 'content', 'editorTemplate' => 'full' )); ?>
					</div>
					<?php echo CHtml::error($model, 'content', array( 'class' => 'input-error' )); ?>
				</label>
				
				<!-- Buttons -->
				<div class="non-label-section">
					<?php echo CHtml::submitButton(Yii::t('admin', 'Submit'), array('class'=>'button medium green float_right')); ?>
					<span><?php echo CHtml::link('Cancel', array('events/index'), array('class' => 'button small')); ?></span>
				</div>
				
				</fieldset>
				<?php echo CHtml::endForm(); ?>
				
			</div>
		</div>
	</div>
	
</div>