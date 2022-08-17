<?php

use App\Services\Video\VideoStatus;
use App\Services\Video\VideoType;
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
        Schema::table('videos', function (Blueprint $table) {
            $table->string('status')->default(VideoStatus::STOPPED->value);
            $table->string('source');
            $table->string('type')->default(VideoType::DEVICE->value);
            $table->string('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('source');
            $table->dropColumn('type');
            $table->dropColumn('slug');
        });
    }
};
