<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AboutUs extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => 128
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 128
			],
			'subject' => [
				'type' => 'TEXT',
				'constraint' => 256
			],
			'messages' => [
				'type' => 'TEXT',
				'constraint' => 2048
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
		$this->forge->addKey('id', true);
		$this->forge->createTable('about_us');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('about_us');
	}
}
