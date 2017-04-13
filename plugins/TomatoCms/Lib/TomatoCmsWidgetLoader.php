<?PHP
class TomatoCmsWidgetLoader{
    private function TomatoCmsWidgetLoader(){}

    public static function load(){
        App::uses('Widget', 'TomatoCms.Model');
        $widgetModel = new Widget();

        $widgetPlugin=array();
        foreach((array)$widgetModel->getActiveWidgets() as $widget){
            Configure::write('Widget.'.$widget['Widget']['package_name'].'.package_name', $widget['Widget']['package_name']);
            try {
                $widgetPlugin[]=$widget['Widget']['package_name'];
            }catch(MissingPluginException $e){
                CakeLog::alert("Missing Widget : ". $e->getMessage());
            }
        }
        CakePlugin::load($widgetPlugin,array(
            'bootstrap'     => true,
            'routes'        => true,
            'ignoreMissing' => true
        ));
    }
}