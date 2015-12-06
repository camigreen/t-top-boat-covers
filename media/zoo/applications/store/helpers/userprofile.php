<?php defined('_JEXEC') or die('Restricted access');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Shawn
 */
class UserProfileHelper extends AppHelper {

    public function __construct($app) {

        parent::__construct($app);

        $this->table = $this->app->table->userprofile;

    }

    public function getName() {
        return 'userprofile';
    }

    public function getStatus($profile) {
        
        $status = $profile->status;

        return $this->app->status->get('profile',$status);

    }

    public function get($id = null) {
        $user = $this->table->get($id);
        $new = false;

        if(!$user) {
            $new = true;
            $user = $this->app->object->create('userprofile');
        }

        return $user;
    }

    public function all() {

        return $this->table->all();
    }

    public function getCurrent() {

        $user = $this->app->session->get('user');



        if($profile = $this->table->first(array('conditions' => 'user_id = '.$user->id))) {
            $new = false;
        
            // trigger init event
            $this->app->event->dispatcher->notify($this->app->event->create($profile, 'userprofile:init', compact('new')));
        } else {
            $profile = $this->app->object->create('userprofile');
            $profile->setUser($user);
        }
        
        return $profile;
    }

    public function getAccount($user = null) {

        $user = $user ? $user : $this->get();

        if(!$user->id) {
            return false;
        }

        $query = 'SELECT * FROM #__zoo_account_user_map WHERE child = '.$user->id;

        $row = $this->app->database->queryObject($query);

        if(!$row) {
            return false;
        }

        $account = $this->app->account->get($row->parent);

        return $account;

    }

    public function mapUserToAccount($user, $new = false) {
        if(!$account = $user->elements->get('account')) {
            return;
        }
        if($new) {
            $query = 'INSERT INTO #__zoo_account_user_map (parent, child) VALUES ('.$account.','.$user->id.')';
        } else {
            $query = 'UPDATE #__zoo_account_user_map SET parent = '.$account.' WHERE child = '.$user->id;
        }
        $this->app->database->query($query);
    }

    public function getAccountName($user) {
        $id = $user->elements->get('account');
        if($account = $this->app->account->get($id)) {
            return $account->name;
        }
        return;
        
    }

    public function getUserAssignments($options = null) {
        $users = $this->table->getUserAssignments($options);
        $assignments = array();
        foreach($users as $user) {
            if($user->parent) {
                $assignments[$user->parent][$user->id] = $user;
            } else {
                $assignments[0][$user->id] = $user;
            }
        }
        return $assignments;
    }

    public function isDealer($profile = null) {
        if(!$profile) {
            $profile = $this->getCurrent();
        }
        if($profile) {
            return $profile->elements->get('type') == 'dealer' ? true : false;
        }
        return false;
    }


}