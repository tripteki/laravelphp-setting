<?php

namespace Tripteki\Setting\Repositories\Eloquent\Admin;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Tripteki\Setting\Models\Admin\Setting;
use Tripteki\Setting\Contracts\Repository\Admin\ISettingRepository;
use Tripteki\RequestResponseQuery\QueryBuilder;

class SettingRepository implements ISettingRepository
{
    /**
     * @param array $querystring|[]
     * @return mixed
     */
    public function all($querystring = [])
    {
        $querystringed =
        [
            "limit" => $querystring["limit"] ?? request()->query("limit", 10),
            "current_page" => $querystring["current_page"] ?? request()->query("current_page", 1),
        ];
        extract($querystringed);

        $content = QueryBuilder::for(Setting::class)->
        defaultSort("key")->
        allowedSorts([ "key", "value", ])->
        allowedFilters([ "key", "value", ])->
        paginate($limit, [ "*", ], "current_page", $current_page)->appends(empty($querystring) ? request()->query() : $querystringed);

        return $content;
    }

    /**
     * @param int|string $identifier
     * @param array $querystring|[]
     * @return mixed
     */
    public function get($identifier, $querystring = [])
    {
        $content = Setting::findOrFail($identifier);

        return $content;
    }

    /**
     * @param int|string $identifier
     * @param array $data
     * @return mixed
     */
    public function update($identifier, $data)
    {
        $content = Setting::findOrFail($identifier);

        DB::beginTransaction();

        try {

            $content->update($data);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create($data)
    {
        $content = null;

        DB::beginTransaction();

        try {

            $content = Setting::create($data);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $identifier
     * @return mixed
     */
    public function delete($identifier)
    {
        $content = Setting::findOrFail($identifier);

        DB::beginTransaction();

        try {

            $content->delete();

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }
};
