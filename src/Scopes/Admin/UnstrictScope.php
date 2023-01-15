<?php

namespace Tripteki\Setting\Scopes\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Tripteki\Setting\Scopes\StrictScope;
use Tripteki\Helpers\Contracts\AuthModelContract;
use Illuminate\Database\Eloquent\Scope as IScope;

class UnstrictScope implements IScope
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->withoutGlobalScope(StrictScope::class)->whereNull(foreignKeyName(app(AuthModelContract::class)));
    }
};
