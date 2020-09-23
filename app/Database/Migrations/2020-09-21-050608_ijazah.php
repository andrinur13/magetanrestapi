<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ijazah extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'id_ijazah' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'id_data_siswa' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'link_ijazah' => [
				'type' => 'TEXT',
				'constraint' => 512
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
		$this->forge->addKey('id_ijazah', true);
		$this->forge->createTable('ijazah');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('ijazah');
	}
}
