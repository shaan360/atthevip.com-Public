<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('news', 'News Index'), array('news/index'), array( 'class' => 'button medium' )); ?>
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
				
				<label for="<?php echo get_class($model) . '_description'; ?>">
					<span><?php echo $model->getAttributeLabel('description'); ?></span>
					<?php echo CHtml::activeTextArea($model, 'description', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'description', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_alias'; ?>">
					<span><?php echo $model->getAttributeLabel('alias'); ?></span>
					<div><small><?php echo $this->createAbsoluteUrl('/') . '/news/#alias#'; ?></small></div>
					<?php echo CHtml::activeTextField($model, 'alias', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'alias', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_catid'; ?>">
					<span><?php echo $model->getAttributeLabel('catid'); ?></span>
					<div><small><?php echo Yii::t('news', 'Choose a category for this post'); ?></small><br /></div>
					<?php echo CHtml::activeDropDownList($model, 'catid', $parents, array('prompt' => Yii::t('news', '-- Root --'), 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'catid', array( 'class' => 'input-error' )); ?>
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
				
				<label for="<?php echo get_class($model) . '_status'; ?>">
					<span><?php echo $model->getAttributeLabel('status'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'status', array( 0 => Yii::t('news', 'Hidden (Draft)'), 1 => Yii::t('news', 'Open (Published)') ), array( 'class' => 'textbox' )); ?>
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
					<span><?php echo CHtml::link('Cancel', array('news/index'), array('class' => 'button small')); ?></span>
				</div>
				
				</fieldset>
				<?php echo CHtml::endForm(); ?>
				
			</div>
		</div>
	</div>
	
</div>