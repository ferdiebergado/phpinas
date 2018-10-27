<?php

namespace Core\Database;

interface DatabaseInterface
{
    public function row(string $statement, ...$params);
    public function update(string $table, array $changes, $conditions);
}
