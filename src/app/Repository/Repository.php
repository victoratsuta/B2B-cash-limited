<?php

namespace App\Repository;

use App\Core\DB;
use App\Exceptions\ValidationException;
use PDO;

abstract class Repository
{
    /**
     * @var string
     */
    public $table;

    /**
     * @var DB
     */
    public $db;


    public function __construct()
    {
        $this->db = DB::getDBConnect();
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws ValidationException
     */
    public function find(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        if (!$result) {
            throw new ValidationException('No result was found');
        } else {
            return $result;
        }
    }

    /**
     * @param array  $collection
     * @param string $table
     */
    public function massInsert(array $collection, string $table = null)
    {
        $table = $table ?: $this->table;
        $keys = [];
        $question_marks = [];
        $insert_values = [];

        foreach ($collection as $item) {
            $item = (array)$item;
            $keys = array_keys($item);
            $question_marks[] = '(' . $this->placeholders('?', sizeof($item)) . ')';
            $insert_values = array_merge($insert_values, array_values($item));
        }

        $sql = "INSERT INTO {$table} (" . implode(",", $keys) . ") VALUES " .
            implode(',', $question_marks);

        $stmt = $this->db->prepare($sql);
        $stmt->execute($insert_values);
    }

    /**
     * @param string $text
     * @param int    $count
     * @param string $separator
     *
     * @return string
     */
    private function placeholders(string $text, int $count = 0, string $separator = ","): string
    {
        $result = array();
        if ($count > 0) {
            for ($x = 0; $x < $count; $x++) {
                $result[] = $text;
            }
        }

        return implode($separator, $result);
    }

    /**
     *
     */
    public function truncate(): void
    {
        $sql = "DELETE FROM {$this->table}";
        $q = $this->db->prepare($sql);

        $q->execute();
    }

    /**
     * @return array
     */
    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $q = $this->db->query($sql);

        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int[] $ids
     *
     * @return array
     * @throws ValidationException
     */
    public function allByIds(array $ids): array
    {
        $in = str_repeat('?,', count($ids) - 1) . '?';

        try {
            $sql = "SELECT * FROM {$this->table} WHERE id IN ($in)";
            $stm = $this->db->prepare($sql);
            $stm->execute($ids);
            return $stm->fetchAll();

        } catch (\Exception $e) {
            throw new ValidationException('No item was found');
        }
    }
}