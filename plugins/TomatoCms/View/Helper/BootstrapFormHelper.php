<?php
App::uses('FormHelper', 'View/Helper');

/**
 * BootstrapFormHelper.
 *
 * Applies styling-rules for Bootstrap 3
 *
 * To use it, just save this file in /app/View/Helper/BootstrapFormHelper.php
 * and add the following code to your AppController:
 *   	public $helpers = array(
 *		    'Form' => array(
 *		        'className' => 'BootstrapForm'
 *	  	  	)
 *		);
 *
 * @link https://gist.github.com/Suven/6325905
 */


class BootstrapFormHelper extends FormHelper {

    public function create($model = null, $options = array()) {
        $defaultOptions = array(
            'inputDefaults' => array(
                'div' => array(
                    'class' => 'form-group'
                ),
                'label' => array(
                    'class' => 'col-md-2 control-label'
                ),
                'between' => '<div class="col-md-6">',
                'after' => '</div>',
                'class' => 'form-control input-sm',
                'error' => array(
                    'attributes' => array(
                        'class' => 'help-block',
                        'wrap'  => 'span'
                    )
                )
            ),
            'class' => 'form-horizontal form-box',
            'role' => 'form',
        );

        if(!empty($options['inputDefaults'])) {
            $options['inputDefaults'] = array_merge($defaultOptions['inputDefaults'], $options['inputDefaults']);
        } else {
            $options = array_merge($defaultOptions, $options);
        }
        return parent::create($model, $options);
    }

    // Remove this function to show the fieldset & language again
    public function inputs($fields = null, $blacklist = null, $options = array()) {
        $options = array_merge(array('fieldset' => false), $options);
        return parent::inputs($fields, $blacklist, $options);
    }

    public function submit($caption = null, $options = array()) {
        $defaultOptions = array(
            'class' => 'btn btn-primary',
            'div' =>  'form-group',
            'before' => '<div class="col-lg-offset-2 col-lg-10">',
            'after' => '</div>',
        );
        $options = array_merge($defaultOptions, $options);
        return parent::submit($caption, $options);
    }

    public function input($fieldName, $options = array()) {
        $this->setEntity($fieldName);
        $options = $this->_parseOptions($options);

        if (isset($options['label']) && is_string($options['label'])) {
            $option['text'] = $options['label'];
            $options['label'] = array_merge($option, $this->_inputDefaults['label']);
        }
        else if (isset($options['label']['text']) && !isset($options['label']['class'])) {
            $options['label'] = array_merge($options['label'], $this->_inputDefaults['label']);
        }

        $divOptions = $this->_divOptions($options);
        unset($options['div']);

        if ($options['type'] === 'radio' && isset($options['options'])) {
            $radioOptions = (array)$options['options'];
            unset($options['options']);
        }

        $label = $this->_getLabel($fieldName, $options);
        if ($options['type'] !== 'radio') {
            unset($options['label']);
        }

        $error = $this->_extractOption('error', $options, null);
        unset($options['error']);

        $errorMessage = $this->_extractOption('errorMessage', $options, true);
        unset($options['errorMessage']);

        $selected = $this->_extractOption('selected', $options, null);
        unset($options['selected']);

        if ($options['type'] === 'datetime' || $options['type'] === 'date' || $options['type'] === 'time') {
            $dateFormat = $this->_extractOption('dateFormat', $options, 'MDY');
            $timeFormat = $this->_extractOption('timeFormat', $options, 12);
            unset($options['dateFormat'], $options['timeFormat']);
        }

        $type = $options['type'];
        $out = array('before' => $options['before'], 'label' => $label, 'between' => $options['between'], 'after' => $options['after']);
        $format = $this->_getFormat($options);

        unset($options['type'], $options['before'], $options['between'], $options['after'], $options['format']);

        $out['error'] = null;
        if ($type !== 'hidden' && $error !== false) {
            $errMsg = $this->error($fieldName, $error);
            if ($errMsg) {
                $divOptions = $this->addClass($divOptions, 'has-error');
                if ($errorMessage) {
                    $out['error'] = $errMsg;
                }
            }
        }

        if ($type === 'radio' && isset($out['between'])) {
            $options['between'] = $out['between'];
            $out['between'] = null;
        }
        $out['input'] = $this->_getInput(compact('type', 'fieldName', 'options', 'radioOptions', 'selected', 'dateFormat', 'timeFormat'));

        $output = '';
        foreach ($format as $element) {
            $output .= $out[$element];
        }

        if (!empty($divOptions['tag'])) {
            $tag = $divOptions['tag'];
            unset($divOptions['tag']);
            $output = $this->Html->tag($tag, $output, $divOptions);
        }
        return $output;
    }
}