<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->string('serial_number')->nullable();
            $table->integer('stok')->default(0);
            // $table->string('qr_code')->nullable();
            $table->timestamp('tanggal')->nullable();
            $table->timestamps();

            $table->foreignId('kategori_barang_id')
                ->constrained('kategori_barangs')
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
