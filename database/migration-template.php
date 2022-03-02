<?php

/**
 * This view is used by console/controllers/MigrateController.php.
 *
 * The following variables are available in this view:
 */

/* @var $className string the new migration class name without namespace */
/* @var $namespace string the new migration class namespace */

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use App\Shared\Infra\Migration\MigrationAbstract;

/**
 * Class <?= $className . "\n" ?>
 */
class <?= $className ?> extends MigrationAbstract
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTableWithDefaultColumns('table_name', [
            'id' => $this->binaryColumn()->notNull(),
            'uuid' => $this->uuid()->notNull(),
            'active' => $this->status()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTableCascade('table_name');
    }
}
