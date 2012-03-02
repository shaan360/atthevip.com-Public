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
					<div><small><?php echo $this->createAbsoluteUrl('/') . '/news/category/#name#'; ?></small></div>
					<?php echo CHtml::activeTextField($model, 'alias', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'alias', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_parentid'; ?>">
					<span><?php echo $model->getAttributeLabel('parentid'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'parentid', $parents, array('prompt' => Yii::t('news', '-- Root --'), 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'parentid', array( 'class' => 'input-error' )); ?>
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
				
				<label for="<?php echo get_class($model) . '_readonly'; ?>">
					<span><?php echo $model->getAttributeLabel('readonly'); ?></span>
					<?php echo CHtml::activeCheckBox($model, 'readonly', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'readonly', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_viewperms'; ?>">
					<span><?php echo $model->getAttributeLabel('viewperms'); ?></span>
					<div><small><?php echo Yii::t('news', 'User roles that can view this category (Defaults to nobody)'); ?></small></div>
					<?php echo CHtml::activeListBox($model, 'viewperms', $roles, array('multiple' => 'multiple', 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'viewperms', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_addpostsperms'; ?>">
					<span><?php echo $model->getAttributeLabel('addpostsperms'); ?></span>
					<div><small><?php echo Yii::t('news', 'User roles that can add news to this category (Defaults to nobody)'); ?></small></div>
					<?php echo CHtml::activeListBox($model, 'addpostsperms', $roles, array('multiple' => 'multiple', 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'addpostsperms', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_addcommentsperms'; ?>">
					<span><?php echo $model->getAttributeLabel('addcommentsperms'); ?></span>
					<div><small><?php echo Yii::t('news', 'User roles that can add comments to this category (Defaults to nobody)'); ?></small></div>
					<?php echo CHtml::activeListBox($model, 'addcommentsperms', $roles, array('multiple' => 'multiple', 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'addcommentsperms', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_addfilesperms'; ?>">
					<span><?php echo $model->getAttributeLabel('addfilesperms'); ?></span>
					<div><small><?php echo Yii::t('news', 'User roles that can add files to this category (Defaults to nobody)'); ?></small></div>
					<?php echo CHtml::activeListBox($model, 'addfilesperms', $roles, array('multiple' => 'multiple', 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'addfilesperms', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_autoaddperms'; ?>">
					<span><?php echo $model->getAttributeLabel('autoaddperms'); ?></span>
					<div><small><?php echo Yii::t('news', 'User roles that can add news this category without the need of manual approval (Defaults to nobody)'); ?></small></div>
					<?php echo CHtml::activeListBox($model, 'autoaddperms', $roles, array('multiple' => 'multiple', 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'autoaddperms', array( 'class' => 'input-error' )); ?>
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