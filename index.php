<?php

/* 
 * This is an example to demonstrate the usage of the function_analyzer class
 */

use iRAP\Profiling\FunctionAnalyzer;

require_once 'vendor/autoload.php';

function sleeper()
{
    sleep(1);
}

function Bar()
{
    FunctionAnalyzer::start();
    sleeper();
    sleeper();
    sleeper();
    FunctionAnalyzer::stop();
}

function Foo()
{
    FunctionAnalyzer::start();
    sleeper();
    Bar();
    FunctionAnalyzer::stop();
}

Foo();
echo FunctionAnalyzer::getResults();