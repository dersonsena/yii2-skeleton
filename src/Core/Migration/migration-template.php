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

use App\Core\Migration\MigrationAbstract;

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
        // set the table columns
        $columns = [
            'id' => $this->primaryKey(),
            'status' => $this->status(),
            'deleted' => $this->deleted()
        ];

        $this->createTable(
            '{{%table_name}}',
            array_merge($columns, $this->blameAndTimedEventsColumns()),
            'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%table_name}}');
    }
}