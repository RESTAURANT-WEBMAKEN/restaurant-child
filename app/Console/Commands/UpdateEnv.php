<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:update {key} {value} {--cache=true : Whether to run config:cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a key-value pair in the .env file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $key = $this->argument('key');
        $value = $this->argument('value');
        $cache = filter_var($this->option('cache'), FILTER_VALIDATE_BOOLEAN);

        // Call the helper function to update the .env file
        $result = update_env_value($key, $value, $cache);

        $this->info($result);

        // Return Command::SUCCESS
        return Command::SUCCESS;
    }
}