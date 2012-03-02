
<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('settings', 'Groups'), array('settings/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('settings', 'Add Setting'), array('settings/addsetting', 'cid' => $_GET['id']), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/system', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('settings', 'Configure Settings'); ?></h2>
			<div class="content">


			<?php echo CHtml::form(null, 'post', array('class' => 'styled')); ?>
			<fieldset>
			
			<?php if( count($settings) ): ?>
				
				<?php foreach($settings as $row): ?>
				
					<label for="setting_<?php echo $row->id; ?>">
						<span title="<?php echo CHtml::encode($row->description); ?>">
							<?php echo CHtml::encode($row->title); ?>
							<?php if( $row->value && $row->default_value != $row->value ): ?>
								<span class='span-red'><?php echo Yii::t('settings', ' (Changed)'); ?></span>
							<?php endif; ?>
						</span>
						
						<div><small><?php echo CHtml::encode($row->description); ?></small></div>
						
						<?php if($row->type == 'editor'): ?>
							<div><?php $this->parseSetting( $row ); ?></div>
						<?php else: ?>
							<?php $this->parseSetting( $row ); ?>
						<?php endif; ?>
						
						<!-- Icons -->
							<?php if( $row->value && $row->default_value != $row->value ): ?>
								<a href="<?php echo $this->createUrl('settings/revertsetting', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('admin', 'Revert setting value to the default value.'); ?>" class='icon-button revert tooltip'><?php echo Yii::t('settings', 'Revert'); ?></a>
							<?php endif; ?>
							 <a href="<?php echo $this->createUrl('settings/editsetting', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('admin', 'Edit this setting'); ?>" class='icon-button edit tooltip'><?php echo Yii::t('settings', 'Edit'); ?></a>
							 <a href="<?php echo $this->createUrl('settings/deletesetting', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('admin', 'Delete this setting!'); ?> "class='icon-button delete tooltip deletelink'><?php echo Yii::t('settings', 'Delete'); ?></a>
					</label>
				
				
				<?php endforeach; ?>	
				
			<!-- Buttons -->
			<div class="non-label-section">
				<?php echo CHtml::submitButton(Yii::t('admin', 'Submit'), array('name' => 'submit', 'class'=>'button medium green float_right')); ?>
				<span><?php echo CHtml::link('Cancel', array('settings/index'), array('class' => 'button small')); ?></span>
			</div>
			
			<?php else: ?>
				<p><?php echo Yii::t('settings', 'No Settings Found.'); ?></p>
			<?php endif; ?>
			
			</fieldset>
			<?php echo CHtml::endForm(); ?>	
				
			</div>
		</div>
	</div>
	
</div>