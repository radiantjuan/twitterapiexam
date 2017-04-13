<?PHP
class TomatoCmsModuleLoader{
    private function TomatoCmsModuleLoader(){}

    public static function load(){
        App::uses('Module', 'TomatoCms.Model');
        $moduleModel = new Module();

        $modulesPlugin=array();
        foreach((array)$moduleModel->getModules() as $module){
            Configure::write('Module.'.$module['Module']['package_name'].'.slug', $module['Module']['slug']);
            Configure::write('Module.'.$module['Module']['package_name'].'.package_name', $module['Module']['package_name']);
            try {
                $modulesPlugin[] = $module['Module']['package_name'];
            }catch(MissingPluginException $e){
                CakeLog::alert("Missing Plugin : ". $e->getMessage());
            }
        }
        CakePlugin::load($modulesPlugin,array(
            'bootstrap'     => true,
            'routes'        => true,
            'ignoreMissing' => true
        ));
    }
}