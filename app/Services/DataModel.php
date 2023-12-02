<?php

namespace App\Services;

use App\Exceptions\InvalidModelParams;
use App\Exceptions\ModelAlreadyExist;

class DataModel
{

    const CLASS_NAME_REGEX = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff-]*$/';

    private array $root = ['app', 'models'];

    /** @var string */
    private $template = __DIR__.'/Templates/EloquentModel.txt';

    /** @var string */
    private string $namespace;

    /** @var string */
    private string $className;

    /** @var string */
    private string $tableName;

    /**
     * @param  string[]  $namespace
     * @param  string    $className
     */
    public function __construct(
        array   $namespace,
        string  $className,
        ?string $template = null
    ) {
        $this->namespace = $this->prepareNamespace($namespace);
        $this->className = $this->convertToCamelCase($className);
        $this->tableName = str_replace('-', '_', $className);

        //        print_r([$this->namespace, $this->className, $this->tableName]);  die("\n");

        // additional exception can be thrown here if template doesn't exist
        if ($template && file_exists(__DIR__."Templates/{$template}.txt")) {
            $this->template = $template;
        }
    }

    private function prepareNamespace(array $namespace): string
    {
        $namespace = array_merge($this->root, $namespace);

        $namespace = array_map(function ($namespaceItem) {
            return $this->convertToCamelCase($namespaceItem);
        }, $namespace);

        return implode('\\', $namespace);
    }

    private function convertToCamelCase(string $name)
    {
        if (!preg_match(self::CLASS_NAME_REGEX, $name)) {
            throw new InvalidModelParams($name);
        }

        $camelCase = preg_replace_callback('/-([a-z])/', function ($match) {
            return strtoupper($match[1]);
        }, strtolower($name));

        return ucfirst($camelCase);
    }

    public function generate(): bool|int
    {
        $content = str_replace(
            ['{namespace}', '{class_name}', '{table_name}'],
            [$this->namespace, $this->className, $this->tableName],
            file_get_contents($this->template)
        );

        $class = implode('\\', [$this->namespace, $this->className]);

        if (class_exists($class)) {
            throw new ModelAlreadyExist($class);
        }

        $path = __DIR__ . '/../../' . lcfirst(str_replace('\\', '/', $this->namespace));

        mkdir($path, 0755, true);

        return file_put_contents("{$path}/{$this->className}.php", $content);
    }
}