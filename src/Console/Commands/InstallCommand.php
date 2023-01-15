<?php

namespace Tripteki\Setting\Console\Commands;

use Tripteki\Helpers\Contracts\AuthModelContract;
use Tripteki\Helpers\Helpers\ProjectHelper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = "adminer:install:setting";

    /**
     * @var string
     */
    protected $description = "Install the setting stack";

    /**
     * @var \Tripteki\Helpers\Helpers\ProjectHelper
     */
    protected $helper;

    /**
     * @param \Tripteki\Helpers\Helpers\ProjectHelper $helper
     * @return void
     */
    public function __construct(ProjectHelper $helper)
    {
        parent::__construct();

        $this->helper = $helper;
    }

    /**
     * @return int
     */
    public function handle()
    {
        $this->installStack();

        return 0;
    }

    /**
     * @return int|null
     */
    protected function installStack()
    {
        (new Filesystem)->ensureDirectoryExists(base_path("routes/user"));
        (new Filesystem)->ensureDirectoryExists(base_path("routes/admin"));
        (new Filesystem)->copy(__DIR__."/../../../stubs/routes/user/setting.php", base_path("routes/user/setting.php"));
        (new Filesystem)->copy(__DIR__."/../../../stubs/routes/admin/setting.php", base_path("routes/admin/setting.php"));
        $this->helper->putRoute("api.php", "user/setting.php");
        $this->helper->putRoute("api.php", "admin/setting.php");

        (new Filesystem)->ensureDirectoryExists(app_path("Http/Controllers/Setting"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Controllers/Setting", app_path("Http/Controllers/Setting"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Requests/Settings"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Requests/Settings", app_path("Http/Requests/Settings"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Controllers/Admin/Setting"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Controllers/Admin/Setting", app_path("Http/Controllers/Admin/Setting"));
        (new Filesystem)->ensureDirectoryExists(app_path("Imports/Settings"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Imports/Settings", app_path("Imports/Settings"));
        (new Filesystem)->ensureDirectoryExists(app_path("Exports/Settings"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Exports/Settings", app_path("Exports/Settings"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Requests/Admin/Settings"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Requests/Admin/Settings", app_path("Http/Requests/Admin/Settings"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Responses"));

        $this->helper->putTrait($this->helper->classToFile(get_class(app(AuthModelContract::class))), \Tripteki\Setting\Traits\SettingTrait::class);

        $this->info("Adminer Setting scaffolding installed successfully.");
    }
};
