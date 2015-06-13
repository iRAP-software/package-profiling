<?php

/* 
 * This is an example to demonstrate the usage of the function_analyzer class
 */

namespace iRAP\Profiling;

require_once(__DIR__ . '/FunctionLog.php');
require_once(__DIR__ . '/FunctionAnalyzer.php');

function sleeper()
{
    sleep(1);
}

function Bar()
{
    \iRAP\Profiling\FunctionAnalyzer::start();
    sleeper();
    sleeper();
    sleeper();
    \iRAP\Profiling\FunctionAnalyzer::stop();
}

function Foo()
{
    \iRAP\Profiling\FunctionAnalyzer::start();
    sleeper();
    Bar();
    \iRAP\Profiling\FunctionAnalyzer::stop();
}

Foo();
print \iRAP\Profiling\FunctionAnalyzer::getResults();