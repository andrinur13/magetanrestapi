<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Prestasi extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'id_prestasi' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'id_data_siswa' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'tingkat' => [
				'type' => 'ENUM',
				'constraint' => "'DESA', 'KECAMATAN', 'KABUPATEN', 'PROVINSI', 'NASIONAL', 'INTERNASIONAL'"
			],
			'penyelenggara' => [
				'type' => 'VARCHAR',
				'constraint' => 256
			],
			'nama_kegiatan' => [
				'type' => 'VARCHAR',
				'constraint' => 256
			],
			'hasil' => [
				'type' => 'VARCHAR',
				'constraint' => 256
			],
			'piagam' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => TRUE
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
		$this->forge->addKey('id_prestasi', true);
		$this->forge->createTable('prestasi');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('prestasi');
	}
}
