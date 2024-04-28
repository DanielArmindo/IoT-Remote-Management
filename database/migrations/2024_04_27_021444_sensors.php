<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensores', function (Blueprint $table) {
            $table->id('cod_sensor');
            $table->string('nome', 50)->unique();
            $table->integer('valor');
            $table->string('data_hora', 20)->nullable();
            $table->text('log')->nullable();
        });

        Schema::create('produto', function (Blueprint $table) {
            $table->bigInteger('cod_produto')->primary(); // Alterado para bigIncrements
            $table->string('nome', 50)->unique();
            $table->integer('quantidade');
            $table->float('preco');
            $table->text('descricao');
            $table->text('img')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });


        Schema::create('vendas', function (Blueprint $table) {
            $table->bigIncrements('cod_venda');
            $table->unsignedBigInteger('cod_utilizador');
            $table->bigInteger('cod_produto');

            $table->foreign('cod_utilizador')->references('id')->on('users');
            $table->foreign('cod_produto')->references('cod_produto')->on('produto');

            $table->integer('quantidade');
            $table->double('preco');
            $table->string('estado', 15);
        });

        //Delete products and pictures folders from storage
        $destinationPath = 'public/products';
        $destinationPath02 = 'public/pictures';
        if (Storage::exists($destinationPath)) {
            Storage::deleteDirectory($destinationPath);
        }

        if (Storage::exists($destinationPath02)) {
            Storage::deleteDirectory($destinationPath02);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensores');
        Schema::dropIfExists('vendas');
        Schema::dropIfExists('produto');

        //Delete products and pictures folders from storage
        $destinationPath = 'public/products';
        $destinationPath02 = 'public/pictures';
        if (Storage::exists($destinationPath)) {
            Storage::deleteDirectory($destinationPath);
        }

        if (Storage::exists($destinationPath02)) {
            Storage::deleteDirectory($destinationPath02);
        }
    }
};
