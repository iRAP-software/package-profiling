<?php

class TestGetResultsArray extends AbstractTest
{
    public function getDescription(): string 
    {
        return "Test that we can get the profiling results in array form.";
    }
    
    
    public function run() 
    {
        \iRAP\Profiling\FunctionAnalyzer::start("foo");
        sleep(3);
        \iRAP\Profiling\FunctionAnalyzer::stop("foo");
        
        $results = \iRAP\Profiling\FunctionAnalyzer::getResultsArray();
        
        if (!is_array($results))
        {
            $this->m_passed = false;
            $this->m_errorMessage = "Results was not an array";
        }
        else if(!isset($results['foo']))
        {
            $this->m_passed = false;
            $this->m_errorMessage = "Missing requrired foo index.";
        }
        else if($results['foo'] < 3)
        {
            $this->m_passed = false;
            $this->m_errorMessage = "Duration is not what expected: " . $results['foo'];
        }
        else
        {
            $this->m_passed = true;
        }
    }
}
