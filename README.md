# package-profiling

PHP Package to make it easy to profile your application and find which functions/areas most time is spent.

### Install

To use this package you need to clone this repo and then move it to your project vendor directory.

```
$ git clone https://github.com/iRAP-software/package-profiling.git
```

### Usage

```
use iRAP\Profiling\FunctionAnalyzer;

function Bar()
{
    FunctionAnalyzer::start();
    sleep(3);
    FunctionAnalyzer::stop();
}
Bar();

echo FunctionAnalyzer::getResults(); // Bar: 3.0001389980316 seconds  
```