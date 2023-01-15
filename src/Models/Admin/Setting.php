<?php

namespace Tripteki\Setting\Models\Admin;

use Tripteki\Setting\Models\Setting as BaseSetting;
use Tripteki\Setting\Scopes\Admin\UnstrictScope;
use Illuminate\Database\Eloquent\Model;

class Setting extends BaseSetting
{
    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UnstrictScope());
    }
};
