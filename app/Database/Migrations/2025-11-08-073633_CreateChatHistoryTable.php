<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChatHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
             'user_id'     => ['type' => 'INT', 'constraint' => 11, 'null' => true],
               'message'     => ['type' => 'TEXT'],
                'response'    => ['type' => 'TEXT', 'null' => true],
                 'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
         $this->forge->addKey('id', true);
        $this->forge->createTable('chat_history');
    }

    public function down()
    {
        $this->forge->dropTable('chat_history');
    }
}
