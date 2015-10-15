<?php
use Migrations\AbstractMigration;

class AddAddressTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('addresses');
        $table
            ->addColumn('city_id', 'integer', [
                'limit' => 11
            ])->addColumn('user_id', 'integer', [
                'limit' => 11
            ])
            ->addColumn('street', 'string', [
               'default' => null,
               'limit' => 45,
               'null' => false,
            ])
            ->addColumn('neighborhood', 'string', [
               'default' => null,
               'limit' => 45,
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
                    'city_id',
                ]
            )
            ->create();
            $table
            ->addForeignKey(
                'city_id',
                'cities',
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
        $this->dropTable('addresses');
    }
}
