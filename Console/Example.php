<?php
namespace Console;

use Core\ConsoleDriver;

class Example extends ConsoleDriver
{
    protected $available_params = [
        'some-any-name1-method'           => "\t\t\tif someAnyName1Method exists in class it will be started (must be not private).",
        'some-any-name2-method'           => "\t\t\tif someAnyName2Method exists in class it will be started (must be not private).\n\t\t\t\t\tYou can start several processes with one command,\n\t\t\t\t\tbut they will be executed one after the other in the order of",
        '--set-some-any-name1-variable'   => "=val\tset value for some_any_name1_variable (must be not private)",
        '--set-some-any-nameN-variable'   => "=val\tset value for some_any_nameN_variable (must be not private)\n",
    ];

    protected $some_any_name1_variable;


    /**
     * @return true
     */
    public function init()
    {
        return true;
    }

    /**
     * Function for prepare and validate variables and environment
     * before someMethod will be run by starter.
     * @param array $actions
     * @return bool
     */
    public function validate(array $actions)
    {
        if (!isset($this->some_any_name1_variable)) {
            dump("Validation fail", "--set-some-any-name1-variable=VALUE is required" , 'error');
            return false;
        }

        return true;
    }

    /**
     * @return void
     */
    protected function someAnyName1Method()
    {
        dump("someAnyName1Method() executed" , 'info');
    }

    /**
     * @return void
     */
    protected function someAnyName2Method()
    {
        dump("someAnyName2Method() executed" , 'info');
    }

}
