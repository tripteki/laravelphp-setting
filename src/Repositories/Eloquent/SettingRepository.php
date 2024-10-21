<?php

namespace Tripteki\Setting\Repositories\Eloquent;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Tripteki\Setting\Models\Setting;
use Tripteki\Setting\Scopes\StrictScope;
use Tripteki\Setting\Events\Keying;
use Tripteki\Setting\Events\Keyed;
use Tripteki\Repository\AbstractRepository;
use Tripteki\Setting\Contracts\Repository\ISettingRepository;

class SettingRepository extends AbstractRepository implements ISettingRepository
{
    /**
     * @param array $querystring|[]
     * @return mixed
     */
    public function all($querystring = [])
    {
        $user = $this->user; $content = null;

        $content = $user->load("sets")->loadCount("sets");

        return $content;
    }

    /**
     * @param int|string $identifier
     * @param array $data
     * @return mixed
     */
    public function update($identifier, $data)
    {
        $user = $this->user; $content = null;

        DB::beginTransaction();

        try {

            $content = $user->sets()->withoutGlobalScope(StrictScope::class);
            $contented = $content->find($identifier);

            if ($contented) {

                $content->update([ "value" => $data["value"], ]);
                $content = $content->first();

            } else {

                $content = $content->create([ "key" => $identifier, "value" => $data["value"], ]);
            }

            DB::commit();

            event(new Keyed($content));

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setup($key, $value)
    {
        return $this->update($key, [ "value" => $value, ]);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function setdown($key)
    {
        return $this->update($key, [ "value" => null, ]);
    }
};
