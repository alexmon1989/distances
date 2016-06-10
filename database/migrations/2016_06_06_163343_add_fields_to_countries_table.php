<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->enum('distance_unit', ['kilometer', 'mile'])->default('kilometer')->after('code');
            $table->enum('volume_unit', ['liter', 'imp_gallon', 'us_gallon'])->default('liter')->after('distance_unit');
            $table->float('fuel_consumption')->default(10)->after('volume_unit');
            $table->float('fuel_cost')->default(35)->after('fuel_consumption');
            $table->string('currency', 16)->default('us_dollar')->after('fuel_cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('distance_unit');
            $table->dropColumn('volume_unit');
            $table->dropColumn('fuel_consumption');
            $table->dropColumn('fuel_cost');
            $table->dropColumn('currency');
        });
    }
}
