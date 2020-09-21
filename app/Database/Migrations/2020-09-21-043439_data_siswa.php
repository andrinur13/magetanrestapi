<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataSiswa extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'id_data_siswa' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'nisn' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'nik' => [
				'type' => 'VARCHAR',
				'constraint' => '100'
			],
			'nama' => [
				'type' => 'VARCHAR',
				'constraint' => '128'
			],
			'tgl_lahir' => [
				'type' => 'DATE',
			],
			'alamat' => [
				'type' => 'TEXT',
				'constraint' => '256'
			],
			'lulus' => [
				'type' => 'BOOLEAN'
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
		$this->forge->addKey('id_data_siswa', true);
		$this->forge->createTable('data_siswa');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('data_siswa');
	}
}
