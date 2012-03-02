<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('gallery', 'Gallery'), array('gallery/index'), array( 'class' => 'button medium' )); ?>
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
				
				<label for="<?php echo get_class($model) . '_name'; ?>">
					<span><?php echo $model->getAttributeLabel('name'); ?></span>
					<?php echo CHtml::activeTextField($model, 'name', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'name', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_event_date'; ?>">
					<span><?php echo $model->getAttributeLabel('event_date'); ?></span>
					<?php $model->event_date = $model->getEventDate(); ?>
					<?php 
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						    'attribute'=>'event_date',
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
					<?php echo CHtml::error($model, 'event_date', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_is_public'; ?>">
					<span><?php echo $model->getAttributeLabel('is_public'); ?></span>
					<?php echo CHtml::activeCheckBox($model, 'is_public', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'is_public', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_watermark_logo'; ?>">
					<span><?php echo $model->getAttributeLabel('watermark_logo'); ?></span>
					<?php echo CHtml::activeCheckBox($model, 'watermark_logo', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'watermark_logo', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_watermark_club_logo'; ?>">
					<span><?php echo $model->getAttributeLabel('watermark_club_logo'); ?></span>
					<?php echo CHtml::activeCheckBox($model, 'watermark_club_logo', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'watermark_club_logo', array( 'class' => 'input-error' )); ?>
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
				
				<label for="<?php echo get_class($model) . '_event_id'; ?>">
					<span><?php echo $model->getAttributeLabel('event_id'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'event_id', Event::model()->getEventListByClub(), array( 'prompt' => Yii::t('admin', '-- Choose Value --'), 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'event_id', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_container_id'; ?>">
					<span><?php echo $model->getAttributeLabel('container_id'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'container_id', MediaContainer::model()->getContainerList(), array( 'prompt' => Yii::t('admin', '-- Create New Container --'), 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'container_id', array( 'class' => 'input-error' )); ?>
				</label>
				
				
				<label for="<?php echo get_class($model) . '_presented_by'; ?>">
					<span><?php echo $model->getAttributeLabel('presented_by'); ?></span>
					<?php echo CHtml::activeTextField($model, 'presented_by', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'presented_by', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_taken_by'; ?>">
					<span><?php echo $model->getAttributeLabel('taken_by'); ?></span>
					<?php echo CHtml::activeTextField($model, 'taken_by', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'taken_by', array( 'class' => 'input-error' )); ?>
				</label>
				
				<!-- Buttons -->
				<div class="non-label-section">
					<?php echo CHtml::submitButton(Yii::t('admin', 'Submit'), array('class'=>'button medium green float_right')); ?>
					<span><?php echo CHtml::link('Cancel', array('gallery/index'), array('class' => 'button small')); ?></span>
				</div>
				
				</fieldset>
				<?php echo CHtml::endForm(); ?>
				
			</div>
		</div>
	</div>
	
</div>