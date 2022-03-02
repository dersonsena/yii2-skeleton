<?php

declare(strict_types=1);

namespace App\Shared\Migration;

use yii\db\Migration;

abstract class MigrationAbstract extends Migration
{
    use ValuesGenerators;
    use Columns;

    /**
     * The abstraction of the create table process. This routine create the PK index
     * @param string $tableName
     * @param array $specificColumns
     * @param bool $createPK
     */
    public function createTableWithDefaultColumns(string $tableName, array $specificColumns, bool $createPK = true)
    {
        $columns = array_merge($specificColumns, $this->blameAndTimestampColumns());
        $this->createSimpleTable($tableName, $columns, $createPK);
    }

    /**
     * @param string $tableName
     * @param array $columns
     * @param bool $createPK
     */
    public function createSimpleTable(string $tableName, array $columns, bool $createPK = true)
    {
        $this->createTable(
            "{{%{$tableName}}}",
            $columns,
            'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
        );

        if ($createPK) {
            $this->addPrimaryKeyColumn($tableName);
        }
    }

    /**
     * Abstract the method of the add the primary key column
     * @param string $tableName
     * @param string $column
     */
    public function addPrimaryKeyColumn(string $tableName, string $column = 'id')
    {
        $this->addPrimaryKey("pk_{$tableName}_id", "{{%$tableName}}", $column);
    }

    /**
     * @param string $table
     * @throws \yii\db\Exception
     */
    public function dropTableCascade(string $table)
    {
        $this->dropForeignKeysFrom($table);

        $table = "{{%{$table}}}";
        parent::dropTable($table);
    }

    /**
     * @param string $table
     * @throws \yii\db\Exception
     */
    public function dropForeignKeysFrom(string $table)
    {
        $tableNameSanitized = preg_replace('/[^a-zA-Z0-9]/', '', $table);
        $databaseName = $this->db->createCommand("SELECT DATABASE()")->queryScalar();

        $foreignKeys = $this->db->createCommand("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE REFERENCED_TABLE_SCHEMA = '{$databaseName}'
            AND TABLE_NAME = '{$tableNameSanitized}'
        ")->queryAll();

        if (empty($foreignKeys)) {
            return;
        }

        foreach ($foreignKeys as $data) {
            $this->dropForeignKey($data['CONSTRAINT_NAME'], $table);
        }
    }
}
