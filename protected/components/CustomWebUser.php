<?php
/**
 * Custom user class
 */
class CustomWebUser extends CWebUser
{
	/**
	 * @var object
	 */
	private $_model = null;
	
	/**
	 * This is here since there is a bug with cookies
	 * that have been saved to a domain name such as
	 * .domain.com so all subdomains can access it as well
	 * @see http://code.google.com/p/yii/issues/detail?id=856
	 */
   public function logout($destroySession = true) {
      if ($this->allowAutoLogin && isset($this->identityCookie['domain'])) {
         $cookies = Yii::app()->getRequest()->getCookies();

         if (null !== ($cookie = $cookies[$this->getStateKeyPrefix()])) {
            $originalCookie = new CHttpCookie($cookie->name, $cookie->value);
            $cookie->domain = $this->identityCookie['domain'];
            $cookies->remove($this->getStateKeyPrefix());
            $cookies->add($originalCookie->name, $originalCookie);
         }

		               
      } 
      
      
       // Remove Roles
		$assigned_roles = Yii::app()->authManager->getRoles(Yii::app()->user->id);
		if(!empty($assigned_roles)) {
	      $auth=Yii::app()->authManager;
	      foreach($assigned_roles as $n=>$role) {
	          if($auth->revoke($n,Yii::app()->user->id))
	          Yii::app()->authManager->save();
	      }
	  	}         
                
      parent::logout($destroySession);
   }
   
   public function login($identity, $duration=0) {
		parent::login($identity, $duration);
		
		$auth=Yii::app()->authManager;
        if(!$auth->isAssigned(Yii::app()->user->role, Yii::app()->user->id)) {
            if($auth->assign(Yii::app()->user->role, Yii::app()->user->id)) {
                Yii::app()->authManager->save();
            }
        }
   }
   
   /**
    * Check if we have the access keys in the db
    *
    */
   public function checkAccess($operation, $params=array()) {
   		// First make sure we haven't already added it
		// without looking in the db
		$missingRoles = Yii::app()->cache->get('missing_roles');
		if($missingRoles === false) {
			// Init
			$missingRoles = array();
		}
		
		// Do we have that roles in the array
		if(!in_array($operation, $missingRoles)) {
			// We don't so look up the db
			$roleExists = AuthItem::model()->find('name=:name', array(':name'=>$operation));
			if(!$roleExists) {
				// Figure out the type first
				if(strpos($operation, 'op_') !== false) {
					$type = CAuthItem::TYPE_OPERATION;
				} elseif(strpos($operation, 'task_') !== false) {
					$type = CAuthItem::TYPE_TASK;
				} else {
					$type = CAuthItem::TYPE_ROLE;
				}
			
				// Create new auth item
				Yii::app()->authManager->createAuthItem( $operation, $type, $operation, null, null );
			}
			
			
			$missingRoles[$operation] = $operation;
			
			// Save
			Yii::app()->cache->set('missing_roles', $missingRoles);
		}
   		
   		return parent::checkAccess($operation, $params);
   		
   		// For now
   		//return true;
   }

	/**
	 * @return string - User role
	 */
    public function getRole() {
        if($user = $this->getModel()) {
            return $user->role;
        }
    }

	/**
	 * @return object - Users AR Object
	 */
    private function getModel() {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = Users::model()->findByPk($this->id);
        }
        return $this->_model;
    }

}