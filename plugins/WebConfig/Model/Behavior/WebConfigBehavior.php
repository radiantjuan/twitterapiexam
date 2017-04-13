<?PHP
class WebConfigBehavior extends ModelBehavior {
  public function beforeValidate(Model $model, $options=array()){

      if( $model->data[$model->alias]['type'] != 'image' ){
          $model->Behaviors->UploadValidator->settings[$model->alias]['fileField'] = array('value_image');
          $model->Behaviors->SThreeUpload->settings[$model->alias]['fileField'] = array('value_image');

          unset($model->data[$model->alias]['value_image']);

          $validator = $model->validator();

          $f = "value_".$model->data[$model->alias]['type'];

          $validator[$f] = array();
          $validator[$f]['notBlank'] = array(
            "rule"          => "notBlank",
            "message"       => "This is required",
          );

      }

      return true;
  }
}
