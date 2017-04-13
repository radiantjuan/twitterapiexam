<?php
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');

class WidgetTask extends AppShell {

    public $path = null;

    public $widgetName;

    public function execute() {
        $this->path = Configure::read('TomatoCms.UserWidgetPluginsPath')  . DS;

        if (isset($this->args[0])) {
            $this->widgetName = Inflector::camelize($this->args[0]);

            if($this->isWidgetExist($this->widgetName)==FALSE) return false;

            $this->_interactive(Inflector::camelize($this->args[0]));
        } else {
            return $this->_interactive();
        }
    }

    private function isWidgetExist($widgetName){
        $pluginPath = $this->path . $widgetName;
        if (is_dir($pluginPath)) {
            $this->out(__d('cake_console', 'Widget: %s already exists, no action taken', $widgetName));
            $this->out(__d('cake_console', 'Path: %s', $pluginPath));
            return false;
        }
        return true;
    }

    /**
     * Interactive interface
     *
     * @param string $plugin The plugin name.
     * @return void
     */
    protected function _interactive($plugin = null) {
        while ($plugin === null) {
            $plugin = $this->in(__d('cake_console', 'Enter the name of the WIDGET in CamelCase format'));
        }
        $this->widgetName = $plugin;

        if (!$this->bake($plugin)) {
            $this->error(__d('cake_console', "An error occurred trying to bake: %s in %s", $plugin, $this->path . $plugin));
        }
    }

    public function bake($plugin) {
        if($this->isWidgetExist($this->widgetName)==FALSE) return false;

        $this->hr();
        $this->out(__d('cake_console', "<info>Widget Name:</info> %s", $this->widgetName));
        $this->out(__d('cake_console', "<info>Widget Directory:</info> %s", $this->path . $plugin));
        $this->hr();

        $looksGood = $this->in(__d('cake_console', 'Look okay?'), array('y', 'n', 'q'), 'y');

        if (strtolower($looksGood) === 'y') {
            $Folder = new Folder($this->path . $plugin);
            $directories = array(
                'Config' . DS . 'Schema',
                'Model' . DS . 'Behavior',
                'Model' . DS . 'Datasource',
                'Console' . DS . 'Command' . DS . 'Task',
                'Controller' . DS . 'Component',
                'Lib',
                'View' . DS . $plugin,
                'View' . DS . 'Helper',
                'Test' . DS . 'Case' . DS . 'Controller' . DS . 'Component',
                'Test' . DS . 'Case' . DS . 'View' . DS . 'Helper',
                'Test' . DS . 'Case' . DS . 'Model' . DS . 'Behavior',
                'Test' . DS . 'Fixture',
                'Vendor',
                'webroot'
            );

            foreach ($directories as $directory) {
                $dirPath = $this->path . $plugin . DS . $directory;
                $Folder->create($dirPath);
                new File($dirPath . DS . 'empty', true);
            }

            foreach ($Folder->messages() as $message) {
                $this->out($message, 1, Shell::VERBOSE);
            }

            $errors = $Folder->errors();
            if (!empty($errors)) {
                foreach ($errors as $message) {
                    $this->error($message);
                }
                return false;
            }

            $controllerFileName = $plugin . 'AppController.php';
            $out = "<?php\n";
            $out .= "App::uses('AppController', 'Controller');\n\n";
            $out .= "class {$plugin}AppController extends AppController {\n\n";
            $out .= "}\n";
            $this->createFile($this->path . $plugin . DS . 'Controller' . DS . $controllerFileName, $out);

            $controllerFileName = $plugin . 'Controller.php';
            $out = "<?php\n\n";
            $out .= "App::uses('{$plugin}AppController', '{$plugin}.Controller');\n\n";
            $out .= "class {$plugin}Controller extends {$plugin}AppController {\n\n";
            $out .= "\tpublic function render_widget(){\n";
            $out .= "\t\tif( \$this->request->is('requested') ){\n";
            $out .= "\t\t\t\$this->layout = false;\n";
            $out .= "\t\t\t\$this->render('render_widget');\n";
            $out .= "\t\t}\n";
            $out .= "\t}\n\n";
            $out .= "\tpublic function admin_index(){\n";
            $out .= "\t}\n\n";
            $out .= "}\n";
            $this->createFile($this->path . $plugin . DS . 'Controller' . DS . $controllerFileName, $out);

            $modelFileName = $plugin . 'AppModel.php';
            $out = "<?php\n";
            $out .= "App::uses('AppModel', 'Model');\n\n";
            $out .= "class {$plugin}AppModel extends AppModel {\n\n";
            $out .= "}\n";
            $this->createFile($this->path . $plugin . DS . 'Model' . DS . $modelFileName, $out);

            $controllerIndex = $this->path . $plugin . DS . 'View' . DS . $plugin . DS . 'render_widget.ctp';
            $this->createFile($controllerIndex, $plugin . " index");

            $controllerIndex = $this->path . $plugin . DS . 'View' . DS . $plugin . DS . 'admin_index.ctp';
            $this->createFile($controllerIndex, $plugin . " admin_index");

            $this->createFile($this->path . $plugin . DS . 'Config' . DS . 'bootstrap.php', "");

            $out = '<?PHP
$plugin = Inflector::humanize(Configure::read(\'Widget.'.$plugin.'.package_name\'));
$defaultController = $plugin;
$prefix      = \'admin\';

Router::connect(
    "/{$prefix}/{$plugin}", array(
        \'plugin\'     => $plugin,
        \'controller\' => $defaultController,
        \'action\'     => \'index\',
        \'prefix\'     => $prefix,
        $prefix      => true
    )
);
Router::connect(
    "/{$prefix}/{$plugin}/:controller", array(
        \'plugin\'     => $plugin,
        \'action\'     => \'index\',
        \'prefix\'     => $prefix,
        $prefix      => true
    )
);
Router::connect(
    "/{$prefix}/{$plugin}/:controller/:action/*", array(
        \'plugin\'     => $plugin,
        \'prefix\'     => $prefix,
        $prefix      => true
    )
);



Router::connect(
    "/{$plugin}", array(
        \'plugin\'     => $plugin,
        \'controller\' => $defaultController,
        \'action\'     => \'index\'
    )
);
Router::connect(
    "/{$plugin}/:controller", array(
        \'plugin\' => $plugin,
        \'action\' => \'index\'
    )
);
Router::connect(
    "/{$plugin}/:controller/:action/*", array(
        \'plugin\' => $plugin
    )
);

Configure::delete(\'Widget.'.$plugin.'.package_name\');';
            $this->createFile($this->path . $plugin . DS . 'Config' . DS . 'routes.php', $out);

            $this->hr();
            $this->out(__d('cake_console', '<success>Created:</success> %s in %s', $plugin, $this->path . $plugin), 2);
        }

        return true;
    }

    public function getOptionParser() {
        $parser = parent::getOptionParser();

        $parser->description(
            __d('cake_console',	'Create the directory structure, AppModel and AppController classes for a new module. ' .
                'Can create module in any of your bootstrapped plugin paths.')
        )->addArgument('name', array(
            'help' => __d('cake_console', 'CamelCased name of the plugin to create.')
        ));

        return $parser;
    }
}