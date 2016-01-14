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
        // $this->registerTask('edit', 'edit');
        // $this->registerTask('save2new', 'save');
        $this->registerTask('cancel', 'search');
        // $this->registerTask('upload', 'upload');
    }
    
    /*
            Function: display
                    View method for MVC based architecture

            Returns:
                    Void
    */
    public function display($cachable = false, $urlparams = false) {

        
    }

    public function gateway() {
        if (!$this->app->customer->isAccountAdmin() && !$this->app->customer->isStoreAdmin()) {
            return $this->app->error->raiseError(500, JText::_('You are not authorized to view this page.<p><a href="/">Click Here</a> to return to the home page.</p>'));
        }
        $task = $this->getTask();
    }

    public function search() {

        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }

        $options = array();
        $search = $this->app->request->get('s', 'string', $this->app->session->get('return'));
        $this->app->session->set('return', $search);

        switch($search) {
            case "all-users":
                $title = "User Accounts";
                $conditions[] = "substring_index(type,'.',1) = 'user'";
                break;
            case "all":
                $title = "All Accounts";
                break;
            case "oem": 
                $title = "OEM Accounts";
                $conditions[] = "type = '$search'";
                break;
            case "dealership":
                $title = "Dealership Accounts";
                $conditions[] = "type = '$search'";
                break;
            default:
            $title = 'Accounts';
            $conditions[] = "type = '$search'";
        }

        $conditions[] = 'state != 3';
        $conditions[] = "type != 'store'";

        if($this->app->customer->isStoreAdmin()) {
            $options['conditions'] = implode(' AND ', $conditions);
            $this->accounts = $this->app->table->account->all($options);
        } else {
            $parent = $this->app->customer->getParent();
            $this->accounts = $this->app->account->getUsersByParent($parent, $conditions);
        }
        
        $this->title = $title;
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

    public function viewParentProfile() {
        $aid = $this->app->customer->get()->getParentAccount()->id;
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
            $parent = $this->app->request->get('p', 'int', null);
            if($parent) {
                $args['related']['parent'] = $parent;
            }
            $this->account = $this->app->account->create($type);
            

        }
        $parts = explode('.',$type,2);
        $count = count($parts);
        $kind = '';
        if($count == 1) {
            list($class) = $parts;
        } else {
            list($class, $kind) = $parts;
        }
        $this->title = $type == 'default' ? "Create a New $template Account" : 'Create a New '.ucfirst($class).' Account';
        $this->form = $this->app->form->create(array($this->template->getPath().'/accounts/config.xml', compact('type')));
        $this->form->setValues($this->account);
        $layout = 'edit';
        $this->partialLayout = $type;
        $this->groups = $this->form->getGroups();
        $this->form->setValue('canEdit', $this->account->canEdit());
        $this->getView()->addTemplatePath($this->template->getPath().'/accounts')->addTemplatePath($this->app->path->path('views:configuration/tmpl/'));

        $this->getView()->addTemplatePath($this->template->getPath())->setLayout($layout)->display();

    }

    public function edit2() {


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
        $xml = simplexml_load_file($this->template->getPath().'/accounts/config2.xml');
        $this->form = JForm::getInstance('com_zoo.new.'.$type, $xml->asXML());
        $this->form->bind(array('test' => 'test'));
        $layout = 'edit2';
        $this->type = $type;
         
        $this->getView()->addTemplatePath($this->template->getPath().'/accounts');

        $this->getView()->addTemplatePath($this->template->getPath())->setLayout($layout)->display();

    }



    public function add () {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
        if(!$this->app->customer->isStoreAdmin()) {
            $this->app->request->set('parent', $this->app->customer->getParent()->id);
            $link = $this->baseurl.'&task=edit&aid='.$account->id.'&type='.'user.'.$this->app->customer->getParent()->type;
            $this->setRedirect($link);
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
            default:
                if($this->app->customer->isAccountAdmin()) {
                    $link .= '&task=search';
                } else {
                    $link = '/';
                }
                
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