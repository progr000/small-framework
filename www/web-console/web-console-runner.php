<?php
/** Enter-point for running console-app through http */

require_once(__DIR__ . '/../../vendor/autoload.php');

use Core\App;
use Core\LogDriver;

set_time_limit(0);
LogDriver::beginConsole();

try {

    App::init(__DIR__ . "/../../config");
    $TASK_DIR = __DIR__ . "/../../Console";

    /* route */
    if (isset($_GET['task'])) {

        $tmp = explode(':', $_GET['task']);
        if (sizeof($tmp) == 2) {
            $_GET['task'] = $tmp[0];
            $_GET[$tmp[1]] = null;
        }

        if (file_exists($TASK_DIR . "/{$_GET['task']}.php")) {

            $route = 'Console\\' . $_GET['task'];
            unset($_GET['task']);
            $arguments = [];
            foreach ($_GET as $k => $v) {
                if (empty($v)) $arguments[] = $k;
                else $arguments[] = "{$k}={$v}";
            }

            /* Run task */
            new $route($arguments);

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
            ->messageAppend("Usage [warn]" . $_SERVER['SCRIPT_NAME'] . "?task=TaskName[/warn]\n")
            ->messageAppend("[default]---------------------------[/default]\n")
            ->messageAppend("Available tasks:\n");

        foreach ($tasks as $task) {
            if (strrpos($task,'.php') !== false) {
                $Usage->messageAppend("\t[success]" . str_replace('.php', '', $task) . "[/success]\n");
            }
        }
        $Usage->setType("info")->show(false, false);
    }

} catch (Exception $e) {
    $error = IS_DEBUG
        ? $e->getMessage() . "\n" . nl2br($e->getTraceAsString()) . "\nFile: {$e->getFile()} (line: {$e->getLine()})\n"
        : "Something wrong. Perhaps task with this name doesn't exist\n";
    LogDriver::error($error);
}

LogDriver::endConsole();
