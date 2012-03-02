<?php
/**
 * Contact Us Controller
 */
class ContactusController extends SiteBaseController {
	/**
	 * initialize
	 */
    public function init()
    {
        parent::init();
    }

	/**
	 * List of available actions
	 */
	public function actions()
	{
	   return array(
	      'captcha' => array(
	         'class' => 'CCaptchaAction',
	         'backColor' => 0xFFFFFF,
		     'minLength' => 3,
		     'maxLength' => 7,
			 'testLimit' => 3,
			 'padding' => array_rand( range( 2, 10 ) ),
	      ),
	   );
	}

	/**
	 * Show Form
	 */
    public function actionIndex() {
		$model = new ContactUsForm;
		$sent = false;
		if( isset($_POST['ContactUsForm']) )
		{
			$model->attributes = $_POST['ContactUsForm'];
			if( $model->validate() )
			{
				// Do we need to email?
				if( getParam('incoming_email', 'info@atthevip.com') )
				{
					// Build Message
					$message = Yii::t('contactus', "New Contact Us Form Submitted<br /><br />
													By: {name}<br />
													Email: {email}<br />
													Phone: {phone}<br />
													Subject: {subject}<br />
													========================<br />
													{msg}<br />
													========================<br /><br />
													Regards, the {team} Team.", array(
														 								'{name}' => $model->name,
																						'{email}' => $model->email,
																						'{phone}' => $model->phone,
																						'{subject}' => $model->subject,
																						'{msg}' => $model->message,
																						'{team}' => Yii::app()->name,
														 							  ));
					$email = Yii::app()->email;
					$email->subject = Yii::t('contactus', 'New Contact Us Form: {subject}', array( '{subject}' => $model->subject ));
					$email->to = getParam('incoming_email', 'info@atthevip.com');
					$email->from = getParam('incoming_email', 'info@atthevip.com');
					$email->replyTo = $model->email;
					$email->message = $message;
					$email->send();
				}
				
				Yii::app()->user->setFlash('success', Yii::t('contactus', 'Thank You. The form submitted successfully.') );
				$model = new ContactUsForm;
				$sent = true;
			}
		}
	
        $this->render('index', array( 'sent' => $sent, 'model' => $model ));
    }
}