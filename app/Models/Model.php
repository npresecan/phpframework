<?php

namespace App\Models;

use Database\Connection;
use PDO;
use Database\Traits\HasTimestamps;
use Database\Traits\SoftDeletes;

abstract class Model {
    use HasTimestamps, SoftDeletes;

    protected static string $table;
    protected static string $primaryKey = 'id'; 
    protected array $attributes = []; 

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }
    
    public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    public function __get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    public function __call(string $name, array $arguments)
    {
        if (str_starts_with($name, 'findBy')) {
            $column = lcfirst(substr($name, 6));
            return $this->findBy($column, $arguments[0]);
        }

        throw new \Exception("Method $name not found");
    }

    public function findBy(string $column, $value): ?self
    {
        $sql = sprintf(
            "SELECT * FROM %s WHERE %s = :value LIMIT 1",
            static::$table,
            $column
        );

        $stmt = Connection::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':value', $value);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        return new static($result);
    }

    public function save(): void
    {
        if (isset($this->attributes[static::$primaryKey]) && $this->attributes[static::$primaryKey]) {
            $this->update();
        } else {
            $columns = array_keys($this->attributes);
            $placeholders = array_map(fn($col) => ":$col", $columns);

            $sql = sprintf(
                "INSERT INTO %s (%s) VALUES (%s)",
                static::$table,
                implode(', ', $columns),
                implode(', ', $placeholders)
            );

            $stmt = Connection::getInstance()->getPDO()->prepare($sql);

            foreach ($this->attributes as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            $this->attributes[static::$primaryKey] = Connection::getInstance()->getPDO()->lastInsertId();
        }
    }

    public function update(): void
    {
        if (empty($this->attributes[static::$primaryKey])) {
            throw new \Exception('Cannot update a model without a primary key.');
        }

        $columns = array_keys($this->attributes);
        $setClause = implode(', ', array_map(fn($col) => "$col = :$col", $columns));

        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s = :primaryKey",
            static::$table,
            $setClause,
            static::$primaryKey
        );

        $stmt = Connection::getInstance()->getPDO()->prepare($sql);

        foreach ($this->attributes as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(':primaryKey', $this->attributes[static::$primaryKey]);
        $stmt->execute();
    }

    public static function find($primaryKey): ?self
    {
        $sql = sprintf(
            "SELECT * FROM %s WHERE %s = :primaryKey LIMIT 1",
            static::$table,
            static::$primaryKey
        );

        $stmt = Connection::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':primaryKey', $primaryKey);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        return new static($result);
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}