<?php
/**
 * Class for aggregating log events and outputting the result.
 *
 */

namespace iRAP\Profiling;

class TimeLogger
{
    private static $s_events = array();
    
    public static function log($message)
    {
        self::$s_events[] = new LogEvent($message);
    }
    
    public static function output()
    {
        $cachedTime = self::$s_events[0]->getTimestamp();
        
        foreach (self::$s_events as $event)
        {
            $timeDiff = $event->getTimestamp() - $cachedTime;
            $cachedTime = $event->getTimestamp();
            
            print $timeDiff . " " . $event->getMessage() . PHP_EOL;
        }
    }
}