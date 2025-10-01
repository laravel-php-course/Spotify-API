<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a model, migration, service, and repository with a repository pattern';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $this->info("Generating files for model: {$name}");

        // Create Model and Migration
        $this->call('make:model', ['name' => $name, '--migration' => true]);

        // Create Repository Interface, Service, and Implementation
        $repositoryPath = app_path('Repositories/');

        $interfaceContent = $this->generateRepositoryInterface($name);
        File::put("{$repositoryPath}/{$name}RepositoryInterface.php", $interfaceContent);

        $implementationContent = $this->generateRepositoryImplementation($name);
        File::put("{$repositoryPath}/{$name}Repository.php", $implementationContent);

        // Add bindings to AppServiceProvider
        $this->registerInAppServiceProvider($name);

        $this->info('Files generated and registered successfully!');
    }

    /**
     * Generate Repository Interface content.
     */
    protected function generateRepositoryInterface($name): string
    {
        return <<<PHP
        <?php

        namespace App\Repositories;

        interface {$name}RepositoryInterface
        {
            public function findById(\$id);

            public function create(array \$data);

            public function update(\$id, array \$data);
        }
        PHP;
    }

    /**
     * Generate Repository Implementation content.
     */
    protected function generateRepositoryImplementation($name): string
    {
        return <<<PHP
        <?php

        namespace App\Repositories;

        use App\Models\\{$name};

        class {$name}Repository implements {$name}RepositoryInterface
        {

            public function findById(\$id)
            {
                return {$name}::find(\$id);
            }

            public function create(array \$data)
            {
                return {$name}::create(\$data);
            }

            public function update(\$id, array \$data)
            {
                \$model = \$this->findById(\$id);
                \$model->update(\$data);
                return \$model;
            }
        }
        PHP;
    }

    /**
     * Generate Service content.
     */
    protected function registerInAppServiceProvider($name): void
    {
        $providerPath = app_path('Providers/AppServiceProvider.php');
        $interface = "\App\Repositories\\{$name}RepositoryInterface";
        $repository = "\App\Repositories\\{$name}Repository";
        $binding = "\$this->app->singleton({$interface}::class, {$repository}::class);";

        if (File::exists($providerPath)) {
            $content = File::get($providerPath);

            // Add binding under the "//repositories" section
            if (strpos($content, $binding) === false) {
                if (strpos($content, '//repositories') !== false) {
                    $updatedContent = preg_replace(
                        '/(\/\/repositories)/',
                        "\$1\n        {$binding}",
                        $content
                    );

                    if ($updatedContent) {
                        File::put($providerPath, $updatedContent);
                        $this->info("Registered {$interface} to {$repository} under the repositories section in AppServiceProvider.");
                    } else {
                        $this->error('Failed to update AppServiceProvider. Please check the file formatting.');
                    }
                } else {
                    $this->error('The //repositories section was not found in AppServiceProvider. Please add the binding manually.');
                }
            } else {
                $this->info("{$interface} is already registered in AppServiceProvider.");
            }
        } else {
            $this->error('AppServiceProvider file not found.');
        }
    }
}
