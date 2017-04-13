<?php
class MakeShell extends AppShell {

    /**
     * Contains tasks to load and instantiate
     *
     * @var array
     */
    public $tasks = array('TomatoCms.Module', 'TomatoCms.Widget');

    public function main(){
        $this->out("Welcome to TomatoCMS Console!\n\nYou can bake a Module and Widget here. :D");
    }

    /**
     * Gets the option parser instance and configures it.
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser() {
        $parser = parent::getOptionParser();

        $parser->description(
            __d('cake_console',	'The Make script generates module and widgets for your application.' .
                ' If run with no command line arguments, Make guides the user through the class creation process.' .
                ' You can customize the generation process by telling Bake where different parts of your application are using command line arguments.')
        )->addSubcommand('module',
            array(
                'help' => __d('cake_console', 'Make a new Module folder in the path supplied or in current directory if no path is specified.'),
                'parser' => $this->Module->getOptionParser()
            )
        )->addSubcommand('widget',
            array(
                'help' => __d('cake_console', 'Make a new Widget folder in the path supplied or in current directory if no path is specified.'),
                'parser' => $this->Module->getOptionParser()
            )
        );

        return $parser;
    }
}
