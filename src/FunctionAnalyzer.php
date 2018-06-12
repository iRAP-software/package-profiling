<?php

/**
 * Class for analyzing how long is spent inside individual functions. Note that this class will
 * NEVER result in a total time exceeding the time it took to execute the entire script. This is
 * becuase when "opening" a nested function, the time is NOT recorded within the parent analyzed
 * parent function. However if a nested function is not "opened" then time spent within that
 * function will be considered as part of the parent.
 *
 */

namespace iRAP\Profiling;


class FunctionAnalyzer
{
    private static $s_functionStack = array(); # stack of opened functions that havent been closed
    private static $s_functionLogs = array(); # array of function_log classes.
    
    
    /**
     * Start the "stopwatch" for the specified function
     * @param String $name - optionally specify a name for what we are timing. By default we will
     *                       pull the function name from the debug backtrace
     * @return void
     */
    public static function start($name=null)
    {
        if ($name === null)
        {
            $trace=debug_backtrace();
            $caller = array_shift($trace);
            $caller = array_shift($trace);
            $name = $caller['function'];
        }
        
        if (isset($caller['class']))
        {
            $name = $caller['class'] . '-' . $name;
        }
        
        if (!isset(self::$s_functionLogs[$name]))
        {
            self::$s_functionLogs[$name] = new FunctionLog($name);
        }
        
        # See if there is already an open function this is nested within, if so stop its stopwatch
        $stackSize = count(self::$s_functionStack);
        
        if ($stackSize > 0)
        {
            $parentFunctionName = self::$s_functionStack[$stackSize-1];
            self::$s_functionLogs[$parentFunctionName]->close();
        }
        
        # Start the stopwatch for this function and add it to the stack
        self::$s_functionLogs[$name]->open();
        self::$s_functionStack[] = $name;
    }
    
    
    /**
     * Stop the "stopwatch" for the specified function because we have reached the end of the
     * function.
     * @param String $name - optionally specify a name for what we are timing. By default we will
     *                       pull the function name from the debug backtrace
     * @return void
     * @throws Exception if that function was never started.
     */
    public static function stop($name=null)
    {
        if ($name === null)
        {
            $trace = debug_backtrace();
            $caller = array_shift($trace);
            $caller = array_shift($trace);
            $name = $caller['function'];
        }
        
        if (isset($caller['class']))
        {
            $name = $caller['class'] . '-' . $name;
        }
        
        if (!isset(self::$s_functionLogs[$name]))
        {
            throw new \Exception('Trying to end a function log that hasnt started: ' . $name);
        }
        
        self::$s_functionLogs[$name]->close();
        
        # Remove the function from the end of the stack
        array_pop(self::$s_functionStack);
        
        # If we just closed a nested function, restart the parents stopwatch.
        $stackSize = count(self::$s_functionStack);
        
        if ($stackSize > 0)
        {
            $name = self::$s_functionStack[$stackSize-1];
            self::$s_functionLogs[$name]->open();
        }
    }
    
    
    /**
     * Return the results as a string with a line for each
     * @param void
     * @return String
     */
    public static function getResults()
    {
        $results = "";
        
        foreach (self::$s_functionLogs as $functionLog)
        {
            $results .= $functionLog->getName() . ": " . $functionLog->getTotalTime() . ' seconds' .
                        PHP_EOL;
        }
        
        return $results;
    }
    
    
    /**
     * Get the results in array form (name/duration pairs)
     * @return array
     */
    public static function getResultsArray()
    {
        $resultsArray = array();
        
        foreach (self::$s_functionLogs as $functionLog)
        {
            $resultsArray[$functionLog->getName()] = $functionLog->getTotalTime();
        }
        
        return $resultsArray;
    }
}
