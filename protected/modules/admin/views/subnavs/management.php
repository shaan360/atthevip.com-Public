<?php
$this->widget('zii.widgets.CMenu', array(
	'activeCssClass' => 'active',
    'items' => array(
		array( 
			'label' => Yii::t('admin', 'Users'), 
			'url' => array('users/index'), 
			'visible' => checkAccess('op_users_view'),
		),
		array( 
			'label' => Yii::t('admin', 'Roles'), 
			'url' => array('roles/index'), 
			'visible' => checkAccess('op_roles_view'),
		),
)));
?>