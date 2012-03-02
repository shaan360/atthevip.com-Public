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
				
				<label for="<?php echo 'movecatsto'; ?>">
					<span><?php echo Yii::t('news', 'Move Categories To'); ?></span>
					<div><small><?php echo Yii::t('news', 'Choose a category to move all subcategories into'); ?></small><br /></div>
					<?php echo CHtml::dropDownList('catsmoveto', (isset($_POST['catsmoveto'])) ? $_POST['catsmoveto'] : '', $parents, array('prompt' => Yii::t('news', '-- Root --'), 'class' => 'chosen' )); ?>
				</label>
				
				<label for="<?php echo 'movepoststo'; ?>">
					<span><?php echo Yii::t('news', 'Move Posts To'); ?></span>
					<div><small><?php echo Yii::t('news', 'Choose a category to move all posts into'); ?></small><br /></div>
					<?php echo CHtml::dropDownList('catsmovetuts', (isset($_POST['catsmovetuts'])) ? $_POST['catsmovetuts'] : '', $parents, array('prompt' => Yii::t('news', '-- Root --'), 'class' => 'chosen' )); ?>	
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