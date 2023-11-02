<?php

namespace Tripteki\Setting\Models;

use Tripteki\Setting\Scopes\StrictScope;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = "updated_at";

    /**
     * @var array
     */
    protected $casts =
    [
        "value" => "string",
    ];

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = "string";

    /**
     * @var string
     */
    protected $primaryKey = "key";

    /**
     * @var array
     */
    protected $fillable = [ "key", "value", ];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StrictScope());
    }
};
