<?php

declare(strict_types=1);

namespace App\Shared\Migration;

use yii\db\Expression;
use yii\db\ColumnSchemaBuilder;

trait Columns
{
    /**
     * Setup the binary id column
     * @param int $length
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function binaryColumn(int $length = 16): ColumnSchemaBuilder
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder("BINARY({$length})");
    }

    /**
     * Setup the UUID column
     * @return ColumnSchemaBuilder
     */
    public function uuid(): ColumnSchemaBuilder
    {
        return $this->string(36)->unique();
    }

    /**
     * Setup the status column
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function status(): ColumnSchemaBuilder
    {
        return $this->smallInteger(1)->notNull()->defaultValue(1);
    }

    /**
     * Setup the deleted column
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function deleted(): ColumnSchemaBuilder
    {
        return $this->smallInteger(1)->notNull()->defaultValue(0);
    }

    /**
     * Setup the enum column
     * @param array $types
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function enum(array $types): ColumnSchemaBuilder
    {
        $parse = "'" . \implode("', '", $types) . "'";
        return $this->getDb()->getSchema()->createColumnSchemaBuilder("ENUM({$parse})");
    }

    /**
     * Returns the blame and timed events columns list
     * @return array
     */
    public function blameAndTimestampColumns(): array
    {
        return array_merge(
            $this->timestampColumns(),
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
    public function timestampColumns(): array
    {
        return [
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('CURRENT_TIMESTAMP')),
            'updated_at' => $this->dateTime()->defaultValue(new Expression('NULL')),
            'deleted_at' => $this->dateTime()->defaultValue(new Expression('NULL')),
        ];
    }

    /**
     * Returns the array with the address columns
     * @param bool $required
     * @return array
     */
    public function addressColumns(bool $required = true)
    {
        $street = $this->string(100);
        $number = $this->string(10);
        $neighborhood = $this->string(100);
        $zip = $this->string(8);

        if ($required) {
            $street->notNull();
            $number->notNull();
            $neighborhood->notNull();
            $zip->notNull();
        }

        return [
            'address_street' => $street,
            'address_number' => $number,
            'address_neighborhood' => $neighborhood,
            'address_zip' => $zip,
            'address_complement' => $this->string(100),
        ];
    }
}
