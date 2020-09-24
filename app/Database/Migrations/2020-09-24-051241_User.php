<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'id_user' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true
			],
			'id_user_type' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => '128',	
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => '128',
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => '128',
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => '256',
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => TRUE
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => TRUE
			],
			'deleted_at' => [
				'type' => 'DATETIME',
				'null' => TRUE
			]
		]);

		$this->forge->addKey('id_user', true);
		$this->forge->createTable('user');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('user');
	}
}
