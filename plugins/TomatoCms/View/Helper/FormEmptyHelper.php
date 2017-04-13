<?php
App::uses('FormHelper', 'View/Helper');

class FormEmptyHelper extends FormHelper {

    public function create($model = null, $options = array()) {
        $defaultOptions = array(
            'inputDefaults' => array(
                'div' => false,
                'label' => false,
                'between' => false,
                'seperator' => false,
                'after' => false,
                'error' => false
            )
        );

        if(!empty($options['inputDefaults'])) {
            $options = array_merge($defaultOptions['inputDefaults'], $options['inputDefaults']);
        } else {
            $options = array_merge($defaultOptions, $options);
        }
        return parent::create($model, $options);
    }
}