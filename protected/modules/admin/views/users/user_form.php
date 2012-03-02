<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/management', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('users', 'Users'), array('users/index'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo $label; ?></h2>
			<div class="content">
		
				<?php echo CHtml::form(null, 'post', array('class' => 'styled')); ?>
				<fieldset>
				
				<label for="<?php echo get_class($model) . '_username'; ?>">
					<span><?php echo $model->getAttributeLabel('username'); ?></span>
					<?php echo CHtml::activeTextField($model, 'username', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'username', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_email'; ?>">
					<span><?php echo $model->getAttributeLabel('email'); ?></span>
					<?php echo CHtml::activeTextField($model, 'email', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'email', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_password'; ?>">
					<span><?php echo $model->getAttributeLabel('password'); ?></span>
					<?php echo CHtml::activeTextField($model, 'password', array( 'class' => 'textbox' )); ?>
					<?php echo CHtml::error($model, 'password', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo get_class($model) . '_role'; ?>">
					<span><?php echo $model->getAttributeLabel('role'); ?></span>
					<?php echo CHtml::activeDropDownList($model, 'role', $items[ CAuthItem::TYPE_ROLE ], array( 'prompt' => Yii::t('global', '-- Choose Value --'), 'class' => 'chosen' )); ?>
					<?php echo CHtml::error($model, 'role', array( 'class' => 'input-error' )); ?>
				</label>
				
				<label for="<?php echo 'roles'; ?>">
					<span><?php echo Yii::t('users', 'Other Assigned Roles');; ?></span>
					<?php echo CHtml::listBox('roles', isset($_POST['roles']) ? $_POST['roles'] : isset($items_selected[ CAuthItem::TYPE_ROLE ]) ? $items_selected[ CAuthItem::TYPE_ROLE ] : '', $items[ CAuthItem::TYPE_ROLE ], array( 'size' => 20, 'multiple' => 'multiple', 'class' => 'chosen' )); ?>
				</label>
				
				<label for="<?php echo 'tasks'; ?>">
					<span><?php echo Yii::t('users', 'Other Assigned Tasks');; ?></span>
					<?php echo CHtml::listBox('tasks', isset($_POST['tasks']) ? $_POST['tasks'] : isset($items_selected[ CAuthItem::TYPE_TASK ]) ? $items_selected[ CAuthItem::TYPE_TASK ] : '', $items[ CAuthItem::TYPE_TASK ], array( 'size' => 20, 'multiple' => 'multiple', 'class' => 'chosen' )); ?>
				</label>
				
				<label for="<?php echo 'operations'; ?>">
					<span><?php echo Yii::t('users', 'Other Assigned Operations');; ?></span>
					<?php echo CHtml::listBox('operations', isset($_POST['operations']) ? $_POST['operations'] : isset($items_selected[ CAuthItem::TYPE_OPERATION ]) ? $items_selected[ CAuthItem::TYPE_OPERATION ] : '', $items[ CAuthItem::TYPE_OPERATION ], array( 'size' => 20, 'multiple' => 'multiple', 'class' => 'chosen' )); ?>
				</label>
				
				<!-- Buttons -->
				<div class="non-label-section">
					<?php echo CHtml::submitButton(Yii::t('admin', 'Submit'), array('class'=>'button medium green float_right')); ?>
					<span><?php echo CHtml::link('Cancel', array('users/index'), array('class' => 'button small')); ?></span>
				</div>
				
				</fieldset>
				<?php echo CHtml::endForm(); ?>
				
			</div>
		</div>
	</div>
	
</div>
