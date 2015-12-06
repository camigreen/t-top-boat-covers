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
class StatusHelper extends AppHelper {
    
    protected $account = array(
        1 => 'ACCOUNT_STATUS_ACTIVE',
        2 => 'ACCOUNT_STATUS_SUSPENDED',
        3 => 'ACCOUNT_STATUS_TRASHED'
    );

    protected $profile = array(
        1 => 'PROFILE_STATUS_ACTIVE',
        2 => 'PROFILE_STATUS_SUSPENDED',
        3 => 'PROFILE_STATUS_TRASHED'
    );

    protected $order;

    public function get($class, $state) {
        $state = (int) $state;
        $states = $this->$class;
        if(isset($states[$state])) {
            return JText::_($states[$state]);
        }
        return 'Status Unknown';

    }

    public function getArray($class) {
        return $this->$class;

    }

    public function getList($class) {
        return $this->app->data->create($this->$class);
    }

    public function getSelect($class, $name = 'state', $attr = array(), $default = 0) {
        $states = $this->$class;
        $options[] = $this->app->html->_('select.option', '0', '-' . JText::_('Select') . '-');
        foreach ($states as $key => $value) {
            $options[] = $this->app->html->_('select.option', $key, JText::_($value));
        }

        return $this->app->html->_('select.genericlist', $options, $name, $attr, 'value', 'text',$default);

    }
    
}
