<?php
/**
 * Class for logging events. Used by the TimeLogger class for profiling.
 *
 */

namespace iRAP\Profiling;

class LogEvent
{
    private $m_message;
    private $m_timestamp;
    
    public function __construct($message)
    {
        $this->m_message = $message;
        $this->m_timestamp = microtime(true);
    }
    
    public function __toString()
    {
        return $this->m_timestamp . ": " . $this->m_message;
    }
    
    public function getTimestamp() 
    { 
        return $this->m_timestamp; 
    }
    
    public function getMessage() 
    { 
        return $this->m_message; 
    }
}