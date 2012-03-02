<?php
$this->widget('zii.widgets.CMenu', array(
	'activeCssClass' => 'active',
    'items' => array(
		array( 
			'label' => Yii::t('admin', 'Custom Pages'), 
			'url' => array('custompages/index'), 
			'visible' => checkAccess('op_custompages_view'),
		),
		array( 
			'label' => Yii::t('admin', 'News'), 
			'url' => array('news/index'), 
			'visible' => checkAccess('op_news_view'),
		),
		array( 
			'label' => Yii::t('admin', 'Media'), 
			'url' => array('media/index'), 
			'visible' => checkAccess('op_media_view'),
		),
		array( 
			'label' => Yii::t('admin', 'Clubs'), 
			'url' => array('clubs/index'), 
			'visible' => checkAccess('op_clubs_view'),
		),
		array( 
			'label' => Yii::t('admin', 'Galleries'), 
			'url' => array('gallery/index'), 
			'visible' => checkAccess('op_gallery_view'),
		),
		array( 
			'label' => Yii::t('admin', 'Events'), 
			'url' => array('events/index'), 
			'visible' => checkAccess('op_events_view'),
		),
)));
?>