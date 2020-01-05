<?php

namespace App\Core\Migration;

use yii\db\Expression;
use yii\db\Migration;

abstract class MigrationAbstract extends Migration
{
    /**
     * Setup the binary id column
     * @param int $size
     * @return string
     * @throws \yii\base\NotSupportedException
     */
    public function binaryId(int $size = 16): string
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder("BINARY({$size})");
    }

    /**
     * Setup the UUID column
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function uuid()
    {
        return $this->string(36)->notNull()->unique();
    }

    /**
     * Setup the status column
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function status()
    {
        return $this->smallInteger(1)->notNull()->defaultValue(1);
    }

    /**
     * Setup the deleted column
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function deleted()
    {
        return $this->smallInteger(1)->notNull()->defaultValue(0);
    }

    /**
     * Returns the blame and timed events columns list
     * @return array
     */
    public function blameAndTimedEventsColumns(): array
    {
        return array_merge(
            $this->timedEventsColumns(),
            $this->blameColumns()
        );
    }

    /**
     * Returns the blame columns list
     * @return array
     */
    public function blameColumns(): array
    {
        return [
            'created_by' => $this->string(100)->notNull(),
            'updated_by' => $this->string(100)->defaultValue(new Expression('NULL')),
            'deleted_by' => $this->string(100)->defaultValue(new Expression('NULL')),
        ];
    }

    /**
     * Returns the timed events columns list
     * @return array
     */
    public function timedEventsColumns(): array
    {
        return [
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->defaultValue(new Expression('NULL')),
            'deleted_at' => $this->dateTime()->defaultValue(new Expression('NULL')),
        ];
    }
}