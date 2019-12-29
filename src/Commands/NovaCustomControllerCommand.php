<?php

namespace Opanegro\NovaCustomController\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class NovaCustomControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova:custom-controller
                            {resource : Resource name}
                            {--event=store : Event name [store,update]}
                            {--custom-uri-key= : Custom uriKey if you modify uriKey}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new custom controller to path app/Http/Controllers/...';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $resource = $this->argument('resource');
        $this->controller($resource);
    }

    /**
     * Get the stub file for the generator.
     *
     * @param string $event
     * @return string
     * @throws \Exception
     */
    protected function getStub(string $event)
    {
        if (file_exists(__DIR__ . '/stubs/' . $event . '.stub')) {
            return file_get_contents(__DIR__ . '/stubs/' . $event . '.stub');
        }

        throw new \Exception('The event has not exists in this package.');
    }

    /**
     * Create file controller
     *
     * @param string $name
     * @throws \Exception
     */
    protected function controller(string $name)
    {
        try {
            $controller_template = str_replace('{{DummyResource}}', $name, $this->getStub($this->option('event')));

            $event = Str::title($this->option('event'));
            File::makeDirectory(app_path("/Http/Controllers/Nova/{$name}"), 0755, true, true);
            if (file_exists(app_path("/Http/Controllers/Nova/{$name}/Resource{$event}Controller.php"))) {
                $this->error("Resource {$name} controller has already exists");
            } else {
                file_put_contents(app_path("/Http/Controllers/Nova/{$name}/Resource{$event}Controller.php"), $controller_template);
                $this->updateRoute($event, $name);

                $this->info("Resource {$name} controller has been created successfully.");
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * Add custom route in file routes/api.php
     *
     * @param string $event
     * @param string $name
     */
    protected function updateRoute(string $event, string $name)
    {
        $uriKey = $this->uriKey();

        switch ($event) {
            case 'update':
                $route = "\nRoute::put('/{nova_api}/{resource}/{resourceId}', 'Nova\\$name\\ResourceUpdateController@handle')->where(['nova_api' => 'nova-api', 'resource' => '$uriKey'])->middleware('nova');";
                break;
            default:
                $route = "\nRoute::post('/{nova_api}/{resource}', 'Nova\\$name\\ResourceStoreController@handle')->where(['nova_api' => 'nova-api', 'resource' => '$uriKey'])->middleware('nova');";
                break;
        }

        File::append(base_path('routes/web.php'), $route);
    }

    /**
     * Implement the uriKey
     *
     * @return array|bool|string|null
     */
    protected function uriKey()
    {
        $uriKey = empty($this->option('custom-uri-key'))
            ? Str::plural($this->argument('resource'))
            : $this->option('custom-uri-key');

        return Str::lower($uriKey);
    }
}
