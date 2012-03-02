<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/management', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('users', 'Users'), array('users/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('users', 'Add User'), array('users/adduser'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<div class="container_4">

	<!-- BEGIN PLAIN TEXT EXAMPLE
	 	 The simplest one of all, just some regular ol' text in a panel. -->

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo $model->username; ?></h2>
			<div class="content">				
				<table width="100%">
					
					<tr>
						<td><b><?php echo Yii::t('users', 'Username'); ?></b> </td>
						<td><?php echo $model->username; ?></td>
						
						<td><b><?php echo Yii::t('users', 'Email'); ?></b> </td>
						<td><?php echo $model->email; ?></td>
					</tr>
		
					<tr>
						<td><b><?php echo Yii::t('users', 'Joined'); ?></b> </td>
						<td><?php echo dateTime($model->joined); ?></td>
						
						<td><b><?php echo Yii::t('users', 'Role'); ?></b> </td>
						<td><?php echo $model->role; ?></td>
					</tr>
					
					<tr>
						<td><b><?php echo Yii::t('users', 'IP'); ?></b> </td>
						<td><?php echo $model->ipaddress; ?></td>
						
						<td><b><?php echo Yii::t('users', 'Options'); ?></b> </td>
						<td>
							<a href="<?php echo $this->createUrl('users/edituser', array( 'id' => $model->id )); ?>" title="<?php echo Yii::t('users', 'Edit this member'); ?>" class='icon-button edit tooltip'><?php echo Yii::t('users', 'Edit'); ?></a>
							 <a href="<?php echo $this->createUrl('users/deleteuser', array( 'id' => $model->id )); ?>" title="<?php echo Yii::t('users', 'Delete this member!'); ?> "class='icon-button delete tooltip deletelink'><?php echo Yii::t('users', 'Delete'); ?></a>
						</td>
					</tr>
					
				</table>
			</div>
		</div>
	</div>
	
</div>
