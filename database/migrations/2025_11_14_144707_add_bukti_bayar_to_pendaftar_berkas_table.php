<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddBuktiBayarToPendaftarBerkasTable extends Migration
{
    public function up()
    {
        // Untuk MySQL
        DB::statement("ALTER TABLE pendaftar_berkas MODIFY COLUMN jenis ENUM('IJAZAH','RAPOR','KIP','KKS','AKTA','KK','BUKTI_BAYAR','LAINNYA') NOT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE pendaftar_berkas MODIFY COLUMN jenis ENUM('IJAZAH','RAPOR','KIP','KKS','AKTA','KK','LAINNYA') NOT NULL");
    }
}