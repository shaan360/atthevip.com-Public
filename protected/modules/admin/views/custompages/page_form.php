<?php if( isset( $_POST['preview'] ) ): ?>	
	<div class="container_4">

	<!-- BEGIN PLAIN TEXT EXAMPLE
	 	 The simplest one of all, just some regular ol' text in a panel. -->

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('custompages', 'Preview Page'); ?></h2>
			<div class="content">
				<?php echo $model->content; ?>
			</div>
		</div>
	</div>
	
</div>
	
<?php endif; ?>

<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('settings', 'Custom Pages'), array('custompages/index'), array( 'class' => 'button medium' )); ?>
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
				
				<label for="<?php echo get_class($model) . '_alias'; ?>">
					<span><?php echo $model->getAttributeLabel('alias'); ?></span>
					<div><small><?php echo $this->createAbsoluteUrl('/') . '/#alias#'; ?></small></div>
					<?php echo CHtml::activeTextField($model, 'alias', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'alias', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_tags'; ?>">
					<span><?php echo $model->getAttributeLabel('tags'); ?></span>
					<?php echo CHtml::activeTextField($model, 'tags', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'tags', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_metadesc'; ?>">
					<span><?php echo $model->getAttributeLabel('metadesc'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'metadesc', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'metadesc', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_metakeys'; ?>">
					<span><?php echo $model->getAttributeLabel('metakeys'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'metakeys', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'metakeys', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_visible'; ?>">
					<span><?php echo $model->getAttributeLabel('visible'); ?></span>
					<div><small><?php echo Yii::t('custompages', 'User roles that can access this page (Defaults to everyone)'); ?></small></div>
					<?php echo CHtml::activeListBox($model, 'visible', $roles, array('multiple' => 'multiple', 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'visible', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_status'; ?>">
					<span><?php echo $model->getAttributeLabel('status'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'status', array( 0 => Yii::t('custompages', 'Hidden (Draft)'), 1 => Yii::t('custompages', 'Open (Published)') ), array( 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'status', array( 'class' => 'input-error' )); ?>
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
					<?php echo CHtml::submitButton(Yii::t('admin', 'Submit'), array('class'=>'button medium green float_right', 'name' => 'submit')); ?>
					<?php echo CHtml::submitButton(Yii::t('admin', 'Preview'), array('class'=>'button medium green float_right', 'name' => 'preview')); ?>
					<span><?php echo CHtml::link('Cancel', array('settings/index'), array('class' => 'button small')); ?></span>
				</div>
				
				</fieldset>
				<?php echo CHtml::endForm(); ?>
				
			</div>
		</div>
	</div>
	
</div>