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
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->onDelete('cascade');
            $table->foreignId('staff_id')
                ->constrained('users')
                ->onDelete('cascade');
            // $table->foreignId('jenis_id')
            //     ->constrained('jenis_barangs')
            //     ->onDelete('cascade');
            $table->string('kode_transaksi')->unique();
            $table->integer('jumlah');
            $table->string('qr_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
