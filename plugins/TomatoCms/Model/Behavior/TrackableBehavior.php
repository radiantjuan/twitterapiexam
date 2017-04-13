<?php
App::uses('ModelBehavior', 'Model');

class TrackableBehavior extends ModelBehavior {

    /**
     * Default settings
     */
    protected $_defaults = array(
        'userModel' => 'Users.User',
        'fields' => array(
            'created_by' => 'created_by',
            'updated_by' => 'updated_by',
        ),
    );

    /**
     * Setup
     */
    public function setup(Model $model, $config = array()) {
        $this->settings[$model->alias] = Set::merge($this->_defaults, $config);
    }

    /**
     * Checks wether model has the required fields
     *
     * @return bool True if $model has the required fields
     */
    protected function _hasTrackableFields(Model $model) {
        $fields = $this->settings[$model->alias]['fields'];
        return
            $model->hasField($fields['created_by']) &&
            $model->hasField($fields['updated_by']);
    }


    public function beforeSave(Model $model, $options = array()) {
        if (!$this->_hasTrackableFields($model)) {
            return true;
        }
        $alias = $model->alias;
        $config = $this->settings[$model->alias];
        $user_id = CakeSession::read('Auth.User.id');

        $date = date("Y-m-d H:i:s");
        if( !isset($model->data[ $alias ][ $model->primaryKey ]) ){
            $model->data[ $alias ][ $config['fields']['created_by'] ] = $user_id;
            $model->data[ $alias ][ $config['fields']['updated_by'] ] = $user_id;

            $model->data[ $alias ]['created'] = $date;
            $model->data[ $alias ]['updated'] = $date;
        }else{
            $model->data[ $alias ]['updated'] = $date;
            $model->data[ $alias ][ $config['fields']['updated_by'] ] = $user_id;
        }

        return true;
    }

}
