<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection{
    private static ?Connection $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php'; 

        try {
            $this->pdo = new PDO(
                'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], 
                $config['username'], 
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            throw new \Exception('Database connection failed.');
        }
    }

    public static function getInstance(): Connection
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    public function fetchAssoc(string $query, array $params = []): ?array
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement->fetch() ?: null;
    }

    public function fetchAssocAll(string $query, array $params = []): array
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    public function insert(string $table, array $data): int
    {
        if (empty($data)) {
            throw new \Exception("Insert data cannot be empty.");
        }

        $values = [];
        if (isset($data[0]) && is_array($data[0])) {
            $columns = array_keys($data[0]);
            $placeholders = '(' . implode(',', array_fill(0, count($columns), '?')) . ')';
            $query = sprintf(
                'INSERT INTO %s (%s) VALUES %s',
                $table,
                implode(',', $columns),
                implode(',', array_fill(0, count($data), $placeholders))
            );
            
            foreach ($data as $row) {
                if (array_keys($row) !== $columns) {
                    throw new \Exception("All rows must have the same columns.");
                }
                $values = array_merge($values, array_values($row));
            }
        } else {
            $columns = array_keys($data);
            $placeholders = implode(',', array_fill(0, count($data), '?'));
            $query = sprintf(
                'INSERT INTO %s (%s) VALUES (%s)',
                $table,
                implode(',', $columns),
                $placeholders
            );

            $values = array_values($data);
        }

        $statement = $this->pdo->prepare($query);
        $statement->execute($values);

        return $this->pdo->lastInsertId();
    }


    public function update(string $table, array $data, array $conditions): int
    {
        if (empty($data) || empty($conditions)) {
            throw new \Exception("Update data or conditions cannot be empty.");
        }

        $setClause = implode(',', array_map(fn($col) => "$col = ?", array_keys($data)));
        $whereClause = implode(' AND ', array_map(fn($col) => "$col = ?", array_keys($conditions)));

        $query = sprintf(
            'UPDATE %s SET %s WHERE %s',
            $table,
            $setClause,
            $whereClause
        );

        $values = array_merge(array_values($data), array_values($conditions));

        $statement = $this->pdo->prepare($query);
        $statement->execute($values);

        return $statement->rowCount();
    }
}