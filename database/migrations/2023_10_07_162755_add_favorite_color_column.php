<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


//create/add column in use 
//php artisan migrate
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('users',function($table){
            $table->string("favoriteColor");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('users',function($table){
            $table->dropColumn('favoriteColor');
        });
    }
};

//to drop back use
//php artisan migrate:rollback
//or after migrate:fresh
//php artisan migrate:rollback --step=1
