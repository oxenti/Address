<?php
use Migrations\AbstractMigration;

class AddCityTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('cities');
        $table
            ->addColumn('state_id', 'integer', [
                'limit' => 11
            ])
            ->addColumn('name', 'string', [
               'default' => null,
               'limit' => 50,
               'null' => false,
            ])
            ->addColumn('uf', 'string', [
               'default' => null,
               'limit' => 5,
               'null' => false,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => 1,
            ])
            ->addColumn('created', 'datetime', [
               'default' => 'CURRENT_TIMESTAMP',
               'limit' => null,
               'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
               'default' => null,
               'limit' => null,
               'null' => true,
            ])
            ->addIndex(
                [
                    'state_id',
                ]
            )
            ->create();

            $table
            ->addForeignKey(
                'state_id',
                'states',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('experiences');
    }
}
