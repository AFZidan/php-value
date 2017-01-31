# Value
Modern replacement for PHP’s [`gettype`](https://php.net/gettype) function.

- [Installation](#installation)
- [Usage](#usage)

## Installation
Open a terminal, enter your project directory and execute the following command
 to add this package to your dependencies:

```bash
$ composer require fleshgrinder/value
```

This command requires you to have Composer installed globally, as explained in
 the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the
 Composer documentation.

## Usage
The `Value` class currently contains a single static method called `getValue`
 and constants with the names of each of PHP’s types, corresponding to the
 values returned by the `getValue` method. There are currently no plans to
 extend this API and the following functionality is considered feature complete
 unless new types are added or old ones are removed.

```php
<?php

use Fleshgrinder\Core\Value;

$closed_resource = tmpfile();
fclose($closed_resource);

$values = [
	[],
	true,
	1.0,
	1,
	null,
	new stdClass,
	new DateTimeImmutable,
	tmpfile(),
	$closed_resource,
	'string'
];

foreach ($values as $value) {
	echo Value::getType($value) , "\n";
}

```

The above will output the following:

```text
array
boolean
float
integer
null
stdClass
DateTimeImmutable
string
resource
closed resource
```

This output corresponds to the available constants in the class with the
 exception for the concrete class names:

```php
<?php

use Fleshgrinder\Core\Value;

echo Value::TYPE_ARRAY;             // array
echo Value::TYPE_BOOL;              // boolean
echo Value::TYPE_CLOSED_RESOURCE;   // closed resource
echo Value::TYPE_FLOAT;             // float
echo Value::TYPE_INT;               // integer
echo Value::TYPE_NULL;              // null
echo Value::TYPE_OBJECT;            // object
echo Value::TYPE_RESOURCE;          // resource
echo Value::TYPE_STRING;            // string

```

The method comes in very handy during the creation of error messages. One of
 the most repeated patterns in the PHP world is the following:

```php
$type = is_object($arg) ? get_class($arg) : gettype($arg);
```

Which is not only cumbersome but also produces inconsistent type names due to
 PHP’s inconsistent `gettype` function. This can be replaced with the method
 provided by this library.

```php
$type = Value::getType($arg);
```

The method never throws anything and does not emit errors and showed to be
 faster and lighter than PHP’s built-in `gettype` function. The reasons for this
 are beyond my understanding but micro benchmarking with tight loops showed
 exactly that. Whether this holds true in real world applications is a different
 question but completely irrelevant, since
 [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself) is the most
 important principle of all principles and this tiny library is meant to
 provide exactly that without compromises or dependencies.

I tried to get this change into PHP core but it was rejected, see
 [PHP RFC: `var_type`](https://wiki.php.net/rfc/var_type) and the linked
 resources at the bottom for more details.
