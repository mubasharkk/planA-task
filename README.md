# Coding Task
<details>
<summary>Details</summary>

Let's say that we have a data collection system that requires the creation of models (entities) dynamically based on some csv files provided by the customers. We need to write a template parser that takes an array like the one below, with the type of data collection, and generates a model (entity) class file with the name of the file and path, class name, namespace and table name based on the params in the array: 

```php
[ 
	'scope' => [ 
		'indirect-emissions–owned', 
		'electricity', 
	],
	 'name' => 'meeting-rooms',
] 
```

In this case, the name and the path of the file to be created should be: `Models/IndirectEmissionsOwned/Electricity/MeetingRooms.php`

The namespace should be: `App\Models\IndirectEmissionsOwned\Electricity`

The name of the class should be: `MeetingRooms`

The name of the table should be: `meeting-rooms` 

And this is the template we should parse: 

```php
<?php 
namespace {namespace}; 

use Illuminate\Database\Eloquent\Model; 

class {class_name} extends Model { 

	const TABLE_NAME = {table_name}; 

	public function getTableName(): string {

		 return self::TABLE_NAME;
	} 
} 
```

This task shouldn't take more than 3 hours. Please let us know how long it takes you so we can improve it. You don't need to write any presentation layer, just the code to process the parameters, parse the template, and generate the file, as well as the unit tests. 

Try to write the code as clean as possible. We'll evaluate the application of the relevant coding principles, the coding standards and how scalable, testable and readable the code is. 

When you are done just create a private repo in your own github account and share it with us. Please provide a readme file with an explanation of your implementation and instructions on how to test that it works.
</details>

# Solution

* The solution is built without using any framework.
* Uses custom **PHP** with composer autoloader. 
* Minimum requirement is **PHP 8.2**.
* `illuminate/database` is only added for IDE display purpose, so it doesn't show any error. 
* There is a test csv file `dataModels.csv` added for initial execution and test case verification, you can change and test it as you
  like. There is a assumption made for the scope array to be separated with a pipe char `|` .
  * Example row: `indirect-emissions-owned|electricity,meeting-rooms`
  * First row is considered as headers in the CSV file.
* There are a things in the class `DataModelGenerator` that can be improved and 
additional validation can be added. It is still extendable/scalable.
* As the task is simple, I tried to keep it simple.

## Files
Following are the files that contains the complete functionality:

* [app/Services/DataModelGenerator.php](https://github.com/mubasharkk/planA-task/blob/main/app/Services/DataModelGenerator.php)
  * Generates each ModelClass from a given template.
* [app/Services/ModelsParserService.php](https://github.com/mubasharkk/planA-task/blob/main/app/Services/ModelsParserService.php)
  * A service class that validates csv data & generate `DataModelGenerator` class objects.

## Execution

Installing composer for `phpunit` tests and autoload generation.

```
composer install
```

#### Executing index.php with dummy file `dataModels.csv`

```
php index.php
```

## Testing

Solution uses `phpunit`.

```
./vendor/bin/phpunit tests/Unit/CSVModelServiceTest.php

./vendor/bin/phpunit tests/Unit/DataModelTest.php
```

### Git CI Workflow

https://github.com/mubasharkk/planA-task/actions/workflows/php.yml