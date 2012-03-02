<?php
/**
 * Index controller Home page
 */
class IndexController extends SiteBaseController {
	/**
	 * Controller constructor
	 */
    public function init()
    {
        parent::init();
    }

	/**
	 * Index action
	 */
    public function actionindex() {
		// Load facebook
		Yii::import('ext.facebook.facebookLib');
		$facebook = new facebookLib(array( 'appId' => Yii::app()->params['facebookappid'], 'secret' => Yii::app()->params['facebookapisecret'], 'cookie' => true, 'disableSSLCheck' => false ));
		facebookLib::$CURL_OPTS[CURLOPT_CAINFO] = Yii::getPathOfAlias('ext.facebook') . '/ca-bundle.crt';
	
        $this->render('index', array('facebook' => $facebook));
    }
    
    /**
     * Facebook channel action
     *
     */
    public function actionfacebookchannel() {
		 $cache_expire = 60*60*24*365;
		 header("Pragma: public");
		 header("Cache-Control: max-age=".$cache_expire);
		 header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$cache_expire) . ' GMT');
		 
		 echo '<script src="//connect.facebook.net/en_US/all.js"></script>';
		 exit;
    }
}