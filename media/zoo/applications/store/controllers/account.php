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
class AccountController extends AppController {

    
    public function __construct($default = array()) {
        parent::__construct($default);

        // set table
        $this->table = $this->app->table->account;

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
        $this->registerTask('upload', 'upload');
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

        $options = array();
        $search = $this->app->request->get('search', 'string');
        if($search != 'all') {
            $conditions = "type = '$search'";
            $options['conditions'] = $conditions;
        }
        $options['conditions'] = isset($options['conditions']) ? $options['conditions']." AND state != 3" : "state != 3";

        $this->accounts = $this->app->table->account->all($options);
        $this->title = "Accounts";
        $this->record_count = count($this->accounts);

        $layout = 'search';
        $this->getView()->addTemplatePath($this->template->getPath().'/accounts');

        $this->getView()->addTemplatePath($this->template->getPath())->setLayout($layout)->display();
    }

    public function viewProfile() {
        $aid = $this->app->customer->get()->id;
        $this->app->request->set('aid', $aid);
        $this->edit();
    }

    public function upload() {
        $path = 'media/zoo/applications/store/images/';
        $this->app->document->setMimeEncoding('application/json');
        $file_parts = explode('.',$_FILES['files']['name'][0]);
        $file_ext = array_pop($file_parts);
        $uuid = $this->app->request->get('uuid','word', null);
        $uuid = $uuid ? $uuid : $this->app->utility->generateUUID();
        $file = $path.$uuid.'.'.$file_ext;
        JFile::upload($_FILES['files']['tmp_name'][0], $file);
        $result = array(
            'file' => '/'.$file,
            'UUID' => $uuid, 

        );
        echo json_encode($result);
    }

    public function edit() {


        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }

        $aid = $this->app->request->get('aid', 'int');
        $edit = $aid > 0;
        if($edit) {
            if(!$this->account = $this->table->get($aid)) {
                $this->app->error->raiseError(500, JText::sprintf('Unable to access an account with the id of %s', $aid));
                return;
            }
            $type = $this->account->type;
            $this->title = 'Edit '.$this->account->getClassName().' Account';
        } else {
            $type = $this->app->request->get('type', 'string');
            $this->account = $this->app->account->create($type);
            $this->title = $type == 'default' ? "Create a New $template Account" : "Create a New $type Account";

        }

        $this->form = $this->app->form->create(array($this->template->getPath().'/accounts/config.xml', compact('type')));
        $this->form->setValues($this->account);
        $layout = 'edit';
        $this->type = $type;
        $this->groups = $this->form->getGroups();
         
        $this->getView()->addTemplatePath($this->template->getPath().'/accounts')->addTemplatePath($this->app->path->path('views:configuration/tmpl/'));

        $this->getView()->addTemplatePath($this->template->getPath())->setLayout($layout)->display();

    }

    public function add () {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
        $this->title = 'Choose an Account Type';
        $layout = 'add';

        $this->getView()->addTemplatePath($this->template->getPath().'/accounts');

        $this->getView()->addTemplatePath($this->template->getPath())->setLayout($layout)->display();
    }

    public function save() {

        // check for request forgeries
        $this->app->session->checkToken() or jexit('Invalid Token');

        // init vars
        
        $aid = $this->app->request->get('aid', 'int');
        $post = $this->app->request->get('post:', 'array', array());
        $type = $this->app->request->get('type', 'string', 'default');
        echo 'Post</br>';
        var_dump($post);
        //return;

        if($aid) {
            $account = $this->table->get($aid);
        } else {
            $account = $this->app->account->create($type);
        }

        $account->bind($post);
        echo 'Bind</br>';
        var_dump($account);
        //return;

        $account->save();
        echo 'Save</br>';
        var_dump($account);
        //return;

        $msg = 'The account was saved successfully.';
        $link = $this->baseurl;
        switch ($this->getTask()) {
            case 'apply' :
                $link .= '&task=edit&aid='.$account->id.'&type='.$account->type;
                break;
            case 'save2new':
                $link .= '&task=add';
                break;
        }

        $this->setRedirect($link, $msg);
    }

    public function delete() {
        // check for request forgeries
        $this->app->session->checkToken() or jexit('Invalid Token');

        // init vars
        $aid = $this->app->request->get('aid', 'int');

        $account = $this->app->account->get($aid);
        $account->delete();
        $msg = 'The account was deleted successfully.';
        $this->setRedirect($this->baseurl, $msg);

    }

}