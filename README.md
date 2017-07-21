# package-profiling
PHP Package to make it easy to profile your application and find which functions/areas most time is spent.

## Installation

Install through composer with:

```
composer require irap/profiling
```

## Usage

Below is an example script that demonstrates using this tool:

```
<?php

# Include the autoloader for packages.
require_once(__DIR__ . '/vendor/autoload.php');

function Bar()
{
    \iRAP\Profiling\FunctionAnalyzer::start();
    sleep(3);
    \iRAP\Profiling\FunctionAnalyzer::stop();
}

function Foo()
{
    \iRAP\Profiling\FunctionAnalyzer::start();
    sleep(1);
    Bar();
    \iRAP\Profiling\FunctionAnalyzer::stop();
}

Foo();
print \iRAP\Profiling\FunctionAnalyzer::getResults();
```

This should output something similar to:

```
Foo: 1.0001013278961 seconds
Bar: 3.0002498626709 seconds
```

Notice that even though `Bar` is called from within `Foo`, so `Foo` takes a total of 4 seconds to execute, the result for `Foo` is just 1 second because the tool is showing how much time was taken up doing logic in `Foo` rather than within `Bar` because `Bar` is already being profiled separately. If you wanted the total time taken within `Foo` **including** `Bar`, then one just needs to take the analyzer calls out of the Bar method:

```
<?php

# Include the autoloader for packages.
require_once(__DIR__ . '/vendor/autoload.php');

function Bar()
{
    sleep(3);
}

function Foo()
{
    \iRAP\Profiling\FunctionAnalyzer::start();
    sleep(1);
    Bar();
    \iRAP\Profiling\FunctionAnalyzer::stop();
}

Foo();
print \iRAP\Profiling\FunctionAnalyzer::getResults();
```

Output:

```
Foo: 4.0003681182861 seconds
```


### Profiling Small Sections - Custom Names

If you have a very long function, and want to profile separate parts of it, then you can just provide a custom name to the `start` and `stop` methods like so:

```
require_once(__DIR__ . '/vendor/autoload.php');

function Bar() { sleep(3); }
function Foo() { sleep(1); }

function main()
{
    \iRAP\Profiling\FunctionAnalyzer::start('part1');
    Foo();
    \iRAP\Profiling\FunctionAnalyzer::stop('part1');

    // Profiling part 2
    \iRAP\Profiling\FunctionAnalyzer::start('part2');
    Bar();
    Foo();
    \iRAP\Profiling\FunctionAnalyzer::stop('part2');
}

main();
print \iRAP\Profiling\FunctionAnalyzer::getResults();
```

... which outputs:

```
part1: 1.0000782012939 seconds
part2: 4.0001401901245 seconds
```
