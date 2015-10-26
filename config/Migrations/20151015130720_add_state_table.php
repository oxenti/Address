<?php
use Migrations\AbstractMigration;

class AddStateTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('states');
        $table
            ->addColumn('name', 'string', [
               'default' => null,
               'limit' => 75,
               'null' => false,
            ])
            ->addColumn('uf', 'string', [
               'default' => null,
               'limit' => 5,
               'null' => false,
            ])
            ->addColumn('country_id', 'integer', [
                'limit' => 11
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
                    'country_id',
                ]
            )
            ->create();
            $table
            ->addForeignKey(
                'country_id',
                'countries',
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
        $this->dropTable('states');
    }
}
