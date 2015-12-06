<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/*
    Class: DefaultController
        Site controller class
*/
class UserController extends AppController {

    
    public function __construct($default = array()) {
        parent::__construct($default);


        // get application
        $this->application = $this->app->zoo->getApplication();

        // get Joomla application
        $this->joomla = $this->app->system->application;

        // get params
        $this->params = $this->joomla->getParams();

        // get pathway
        $this->pathway = $this->joomla->getPathway();

        // set base url
        $this->baseurl = $this->app->link(array('controller' => $this->controller), false);

        $this->cUser = $this->app->user->get();

        // registers tasks
        $this->registerTask('apply', 'save');
        $this->registerTask('edit', 'edit');
        $this->registerTask('save2new', 'save');
        $this->registerTask('cancel', 'display');
        $this->registerTask('view', 'edit');
        $this->registerTask('select', 'display');
        // $this->taskMap['display'] = null;
        // $this->taskMap['__default'] = null;
    }
    
    /*
            Function: display
                    View method for MVC based architecture

            Returns:
                    Void
    */
    public function display($cachable = false, $urlparams = false) {

        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }

        $this->title = 'User Search';

        $this->profiles = $this->app->table->userprofile->all(array('conditions' => array('status != 4')));

        $layout = 'search';

        $this->getView()->addTemplatePath($this->template->getPath().'/user')->setLayout($layout)->display();
    }

    public function edit() {


        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }

        $uid = $this->app->request->get('uid', 'int');


        if($uid) {
            $this->profile = $this->app->userprofile->get($uid);
            $type = $this->profile->elements->get('type');
            $this->title = 'Edit User';
        } else {
            $type = $this->app->request->get('type', 'string');
            $this->profile = $this->app->userprofile->get();
            $this->title = 'New User';
        }
        $this->account = $this->profile->getAccount();
        $this->user = $this->profile->getUser();

        $this->form = $this->app->form->create(array($this->template->getPath().'/user/config.xml', compact('type')));
        $this->form->setValues($this->user);

        $layout = 'edit';

        $this->getView()->addTemplatePath($this->template->getPath().'/user')->setLayout($layout)->display();

    }

    public function add () {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
        $this->title = 'Choose a User Type';
        $layout = 'add';

        $this->getView()->addTemplatePath($this->template->getPath().'/user');

        $this->getView()->addTemplatePath($this->template->getPath())->setLayout($layout)->display();
    }

    public function save() {

        // check for request forgeries
        $this->app->session->checkToken() or jexit('Invalid Token');

        // init vars
        $now        = $this->app->date->create();
        $cUser = $this->app->user->get()->id;
        $uid = $this->app->request->get('uid', 'int');
        $post = $this->app->request->get('post:', 'array', array());
        $tzoffset   = $this->app->date->getOffset();
        $new = $uid < 1;
        $type = $this->app->request->get('type', 'string');

        if($uid) {
            $profile = $this->app->userprofile->get($uid);
        } else {
            $profile = $this->app->userprofile->get();
        }

        $profile->bind($post);

        // var_dump($post);
        // return;

        $profile->save();

        if(isset($post['assigned']['account'])) {
            if($post['assigned']['account'] != 0) {
                $map[] = $profile->id;
                $this->app->account->mapProfilesToAccount($post['assigned']['account'], $map);    
            } else {
                $profile->removeAccountMap();
            }
            
        }


        // $_groups = JUserHelper::getUserGroups($profile->id);
        // $emp_groups = array(10, 11);
        // $groups = array();

        // foreach($_groups as $group) {
        //     if(!in_array($group, $emp_groups)) {
        //         $groups[] = $group;
        //     }
        // }
        // $groups[] = $profile['group'];


        //JUserHelper::setUserGroups($profile->id, $groups);

        if($new || !$profile->created || !$profile->created_by) {
            $profile->created = $now->toSQL();
            $profile->created_by = $cUser;
        }

        // Set Modified Date
        $profile->modified = $now->toSQL();
        $profile->modified_by = $cUser;

        $profile->save();

        $msg = $profile->getUser()->name.' has been successfully saved.';
        $link = $this->baseurl;
        switch ($this->getTask()) {
            case 'apply' :
                $link .= '&task=edit&uid='.$profile->id;
                break;
            case 'save2new':
                $link .= '&task=add';
                break;
        }

        $this->setRedirect($link, $msg);

    }

    public function delete() {
        $uid = $this->app->request->get('uid', 'int');
        $profile = $this->app->userprofile->get($uid);

        $msg = $profile->getUser()->name.' was deleted successfully';

        if($profile->getUser()->superadmin) {
            $msg = 'The user is a super admin and cannot be deleted.';
        }
        
        $profile->status = 4; 
        $profile->getUser()->set('block', 1);


        $profile->save();
        
        $link = $this->baseurl;

        $this->setRedirect($link, $msg);

    }

    public function resetPassword() {

        $uid = $this->app->request->get('uid','int');

        if(!$user = $this->app->user->get($uid)) {
            return $this->app->error->raiseError(500, JText::_('An error occured while resetting the password.'));
        }
        $new_pwd = JUserHelper::genRandomPassword();
        $user->password = JUserHelper::hashPassword($new_pwd);
        $user->requireReset = 1;
        $user->save();
        $email = $this->app->mail->create();
        $email->setSubject("Password Reset");
        $email->setBody($new_pwd);
        $email->addRecipient($user->email);
        $email->Send();

        $msg = "The users password has been reset.\n The user should receive an email to change thier password.";
        $link = $this->baseurl.'&task=edit&uid='.$uid;
        $this->setRedirect($link,$msg);


    }
}