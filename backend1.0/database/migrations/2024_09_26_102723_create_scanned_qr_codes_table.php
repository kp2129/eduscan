<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScannedQRCodesTable extends Migration
{
    public function up()
    {
        Schema::create('scanned_qr_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('token');
            $table->timestamp('scanned_at'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('scanned_qr_codes');
    }
}
