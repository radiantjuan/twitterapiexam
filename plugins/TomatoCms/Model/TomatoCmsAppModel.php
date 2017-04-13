<?php

App::uses('Model', 'Model');

class TomatoCmsAppModel extends Model {

    /*
     *
     * Model::saveAll() Callback
     * Reference : http://andy-carter.com/blog/cakephp-aftersaveall-callback
     * */

    public function implementedEvents() {
        $events = parent::implementedEvents();
        $events['Model.afterSaveAll'] = array(
            'callable' => 'afterSaveAll',
            'passParams' => true
        );
        return $events;
    }

    public function saveAll($data = array(), $options = array()) {
        $defaults = array(
            'callbacks' => true
        );
        $options = array_merge($defaults, $options);
        $success = parent::saveAll($data, $options);
        if ($success && ($options['callbacks'] === true || $options['callbacks'] === 'afterAll')) {
            $event = new CakeEvent('Model.afterSaveAll',
            $this, array($options));
            $this->getEventManager()->dispatch($event);
        }
        return $success;
    }

    public function afterSaveAll($options){}


    /**
    Extended Validators
     */
    public function alphaNumericDashUnderscore($check) {
        $value = array_values($check);
        $value = $value[0];

        return preg_match('|^[0-9a-zA-Z_\-]*$|', $value);
    }

    public function extendedSlug($check) {
        $value = array_values($check);
        $value = $value[0];
        return preg_match('/^[0-9a-zA-Z_\-\/]*$/', $value);
    }
}
