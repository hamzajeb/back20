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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->integer('quantite');
            $table->integer('prix');
            $table->string('image1');
            $table->string('image2');
            $table->string('image3');
            $table->text('detail');
            $table->text('description');
            $table->bigInteger('sous_categorie_id')->unsigned();
            $table->foreign('sous_categorie_id')->references('id')->on('sous_categories')
            ->onDelete('cascade');
            $table->integer('is_promo')->default(0);
            $table->integer('chrono_sec')->default(0);
            $table->integer('chrono_min')->default(0);
            $table->integer('chrono_hour')->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produits');
    }
};
