<?php

namespace Tripteki\Setting\Traits;

use Tripteki\Setting\Models\Setting;

trait SettingTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function sets()
    {
        return $this->hasMany(Setting::class);
    }
};
