<?php

/**
 * Data structure for the function_anazlyer class
 *
 */

namespace iRAP\Profiling;

class FunctionLog
{
    private $m_functionName;
    private $m_totalTime;
    private $m_cachedTimestamp;
    private $m_isOpen=false;
    
    public function __construct($functionName)
    {
        $this->m_functionName = $functionName;
    }
    
    public function open() 
    {
        if (!$this->m_isOpen)
        {
            $this->m_cachedTimestamp = microtime($asFloat=true);
        }
    }
    
    public function close() 
    {
        $this->m_totalTime += microtime($asFloat=true) - $this->m_cachedTimestamp;
    }
    
    
    public function getTotalTime() { return $this->m_totalTime; }
    public function getName() { return $this->m_functionName; }
}