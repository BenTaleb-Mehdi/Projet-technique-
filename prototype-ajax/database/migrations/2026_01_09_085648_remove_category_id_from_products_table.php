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
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key first if it exists (assuming constraint name convention)
            // $table->dropForeign(['category_id']); 
            // Or just dropConstrainedForeignId if supported, or just column if constraint isn't issue yet.
            // Safest is distinct steps if we aren't sure of constraint name, but generic is fine.
            
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
             $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
        });
    }
};
