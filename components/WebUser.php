<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class WebUser extends CWebUser
{
    /**
     * Overrides a Yii method that is used for roles in controllers (accessRules).
     *
     * @param string $operation Name of the operation required (here, a role).
     * @param mixed $params (opt) Parameters for this operation, usually the object to access.
     * @return bool Permission granted?
     */
    public function checkAccess($operation, $params=array())
    {
        if (empty($this->id)) {
            // Not identified => no rights
            return false;
        }
        $role = $this->getState("type");

        if ($role ==='superUser') { //管理员
            return true; // admin role has access to everything
        }
        // allow access if the operation request is the current user's role
        return ($operation === $role);
    }
    
    public function isSuperUser()
    {
        return $this->getState('type') === 'superUser';
    }
    
    public function isAllAccess()
    {
        return $this->getState('type') === 'userAllAccessPassHolder';
    }
    
    public function isSubscriber()
    {
        return $this->getState('type') === 'userSubscriber';
    }
    
    public function isRegistered()
    {
    	return $this->getState('type') === 'userRegistered';
    }
}
