<div align="center"><a href="https://sikessem.com/" title="SIKessEm"><img src="https://github.com/sikessem/sikessem/blob/main/SIKessEm-logo.png" alt="SIKessEm logo"/></a></div>

***

# 🙈 Ignore files by names or paths

The Ignorant library allows you to check if a path or name is ignored in a pattern list or in a pattern dot (.) file.


## Installation

Using [composer](https://getcomposer.org/), you can install Ignorant with the following command:

```bash
composer require sikessem/ignorant
```


## Usage

Explore our .gitignore file:

```php
<?php

use Sikessem\Ignorant\Ignorefile;

require_once "$VENDOR_DIR/autoload.php";

$gitignore = new Ignorefile(__DIR__.'/.gitignore');

$gitignore->contains('/vendor/'); // Returns true
$gitignore->contains('/.phpunit*'); // Returns true

$gitignore->includes('/vendor/autoload.php'); // Returns true
$gitignore->includes('/.phpunit.result.cache'); // Returns true

$gitignore->excludes('src'); // Return true
$gitignore->excludes('/tests/Unit'); // Return true

```

## License

This library is distributed under the [![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://opensource.org/licenses/MIT)


## Security Reports

Please send any sensitive issue to [ske@sikessem.com](mailto:ske@sikessem.com). Thanks!
