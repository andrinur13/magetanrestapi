<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggaran extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'id_pelanggaran' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'id_data_siswa' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'jenis' => [
				'type' => 'ENUM',
				'constraint' => "'RINGAN', 'SEDANG', 'BERAT', 'SANGAT BERAT'"
			],
			'nama_pelanggaran' => [
				'type' => 'VARCHAR',
				'constraint' => 256
			],
			'hukuman' => [
				'type' => 'TEXT',
				'constraint' => 256
			],
			'created_at' => [
				'type' => 'DATETIME',
			],
			'updated_at' => [
				'type' => 'DATETIME'
			],
			'deleted_at' => [
				'type' => 'DATETIME'
			]
		]);
		$this->forge->addKey('id_pelanggaran', true);
		$this->forge->createTable('pelanggaran');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('pelanggaran');
	}
}
