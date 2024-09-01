<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrechosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trechos', function (Blueprint $table) {
            $table->id();
            $table->date('data_referencia');
            $table->unsignedBigInteger('uf_id');
            $table->unsignedBigInteger('rodovia_id');
            $table->float('quilometragem_inicial');
            $table->float('quilometragem_final');
            $table->json('geo')->nullable();
            $table->timestamps();

            $table->foreign('uf_id')->references('id')->on('ufs')->onDelete('cascade');
            $table->foreign('rodovia_id')->references('id')->on('rodovias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trechos');
    }
}
