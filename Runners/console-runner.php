<?php
/** Enter-point for console-app running by go.sh */

require_once(__DIR__ . '/../vendor/autoload.php');

use Core\App;
use Core\LogDriver;


set_time_limit(0);
try {

    App::init(__DIR__ . "/../config");
    $TASK_DIR = __DIR__ . "/../Console";

    /* route */
    if (isset($argv[1])) {

        $tmp = explode(':', $argv[1]);
        if (sizeof($tmp) == 2) {
            $argv[1] = $tmp[0];
            $argv[] = $tmp[1];
        }

        if (file_exists($TASK_DIR . "/{$argv[1]}.php")) {

            $route = 'Console\\' . $argv[1];
            unset($argv[0], $argv[1]);

            /* Run task */
            new $route($argv);

        } else {
            $show_usage = true;
        }

    } else {
        $show_usage = true;
    }

    if (isset($show_usage)) {

        $tasks = scandir($TASK_DIR);
        array_splice($tasks, array_search('.', $tasks ), 1);
        array_splice($tasks, array_search('..', $tasks ), 1);


        $Usage = LogDriver::createMessage("\n", 0)
            ->messageAppend("Please determine the Task\n")
            ->messageAppend("Usage [warn]./run TaskName[/warn]\n")
            ->messageAppend("[default]---------------------------[/default]\n")
            ->messageAppend("Available tasks:\n");

        foreach ($tasks as $task) {
            if (strrpos($task,'.php') !== false) {
                $Usage->messageAppend("\t[success]" . str_replace('.php', '', $task) . "[/success]\n");
            }
        }
        $Usage->setType("info")->show(false, false);
        exit(1);
    }

} catch (Exception $e) {
    $error = IS_DEBUG
        ? $e->getMessage() . "\n" . nl2br($e->getTraceAsString()) . "\nFile: {$e->getFile()} (line: {$e->getLine()})\n"
        : "Something wrong. Perhaps task with this name doesn't exist\n";
    LogDriver::error($error);
}

exit(0);
