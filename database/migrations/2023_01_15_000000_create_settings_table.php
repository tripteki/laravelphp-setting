<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tripteki\Helpers\Contracts\AuthModelContract;

class CreateSettingsTable extends Migration
{
    /**
     * @var string
     */
    protected $provider;

    /**
     * @var string
     */
    protected $keytype;

    /**
     * @var string
     */
    protected $key;

    /**
     * @return void
     */
    public function __construct()
    {
        $model = app(AuthModelContract::class);

        $this->provider = $model->getTable();
        $this->keytype = $model->getKeyType();
        $this->key = foreignKeyName($model);
    }

    /**
     * @return void
     */
    public function up()
    {
        $provider = $this->provider;
        $keytype = $this->keytype;
        $key = $this->key;

        Schema::create("settings", function (Blueprint $table) use ($provider, $keytype, $key) {

            $table->char("key", 255);

            $table->text("value")->nullable(true);

            if ($keytype == "int") $table->unsignedBigInteger($key)->nullable(true)->default(null);
            else if ($keytype == "string") $table->uuid($key)->nullable(true)->default(null);

            $table->timestamp("updated_at")->nullable(true);

            $table->unique([ "key", $key, ]);

            $table->foreign($key)->references("id")->on($provider)->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists("settings");
    }
};
