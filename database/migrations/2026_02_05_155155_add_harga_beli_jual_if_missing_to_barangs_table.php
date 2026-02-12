<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tambah kolom harga_beli dan harga_jual jika belum ada (untuk database yang lama)
        if (!Schema::hasColumn('barangs', 'harga_beli') || !Schema::hasColumn('barangs', 'harga_jual')) {
            Schema::table('barangs', function (Blueprint $table) {
                if (!Schema::hasColumn('barangs', 'harga_beli')) {
                    $table->decimal('harga_beli', 15, 2)->nullable()->after('deskripsi');
                }

                if (!Schema::hasColumn('barangs', 'harga_jual')) {
                    // letakkan setelah harga_beli jika ada, kalau tidak setelah deskripsi
                    $afterColumn = Schema::hasColumn('barangs', 'harga_beli') ? 'harga_beli' : 'deskripsi';
                    $table->decimal('harga_jual', 15, 2)->nullable()->after($afterColumn);
                }
            });

            // Jika masih ada kolom lama 'harga', copy nilainya ke harga_jual dan harga_beli
            if (Schema::hasColumn('barangs', 'harga')) {
                \DB::statement('UPDATE barangs SET harga_jual = COALESCE(harga_jual, harga), harga_beli = COALESCE(harga_beli, harga)');
            }
        }

        // Hapus kolom lama 'harga' jika masih ada (agar INSERT tidak error "Field 'harga' doesn't have a default value")
        if (Schema::hasColumn('barangs', 'harga')) {
            Schema::table('barangs', function (Blueprint $table) {
                $table->dropColumn('harga');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Untuk keamanan di production, kita tidak menghapus kolom apa pun di down()
        // agar tidak menghilangkan data harga.
    }
};
