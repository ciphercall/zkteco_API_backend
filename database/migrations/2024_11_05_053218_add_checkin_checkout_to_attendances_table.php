<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->timestamp('check_in')->nullable()->after('user_id');
            $table->timestamp('check_out')->nullable()->after('check_in');
            $table->dropColumn('timestamp'); // If you want to replace timestamp with check_in and check_out
        });
    }
    
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['check_in', 'check_out']);
            $table->timestamp('timestamp')->after('user_id'); // Restore original timestamp column if needed
        });
    }
    };
