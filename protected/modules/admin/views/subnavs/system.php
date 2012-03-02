<?php
$this->widget('zii.widgets.CMenu', array(
	'activeCssClass' => 'active',
    'items' => array(
		array( 
			'label' => Yii::t('admin', 'Settings'), 
			'url' => array('settings/index'), 
			'visible' => checkAccess('op_settings_view'),
		),
)));
?>