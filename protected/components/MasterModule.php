<?php
/**
 * Master Module class that represents the parent module
 * for all sub modules, each modules (admin, site, etc...)
 * Should extend from this class as it provides several common
 * operations, tasks and class users
 */
class MasterModule extends CWebModule {
    /**
     * Module constructor - Builds the initial module data
     *
     *
     * @author vadim
     *
     */
    public function init() {
		// Convert application name
		Yii::app()->name = Yii::app()->settings->applicationName != '' ? Yii::app()->settings->applicationName : Yii::app()->name;
		
		// Other settings
		if( count( Yii::app()->params ) ) {
			foreach( Yii::app()->params as $key => $value ) {
				// Skip the ones that does not exists
				if( !Yii::app()->settings->$key ) {
					 continue;
				}
				
				// Add them anyways
				Yii::app()->params[ $key ] = Yii::app()->settings->$key != '' ? Yii::app()->settings->$key : Yii::app()->params[ $key ];
			}
		}
		
		// Convert settings into params
		if( count( Yii::app()->settings->settings ) ) {
			foreach(Yii::app()->settings->settings as $settingKey => $settingValue) {
				Yii::app()->params[ $settingKey ] = $settingValue;
			}
		}
		
        parent::init();
    }

}