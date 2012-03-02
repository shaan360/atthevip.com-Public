<?php

class ActiveRecord extends CActiveRecord {
	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'created_date',
				'updateAttribute' => null,
				'timestampExpression' => 'time()',
			),
			'CreatedUserBehavior' => array(
				'class' => 'application.behaviors.CreatedUserBehavior',
				'createAttribute' => 'created_user',
				'updateAttribute' => null,
				'userExpression' => 'Yii::app()->hasComponent("user") && Yii::app()->user ? Yii::app()->user->id : 0',
			),
		);
	}
}