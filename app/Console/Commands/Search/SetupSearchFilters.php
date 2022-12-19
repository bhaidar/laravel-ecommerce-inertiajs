<?php

namespace App\Console\Commands\Search;

use App\Models\Product;
use Exception;
use Illuminate\Console\Command;

use MeiliSearch\Client;

class SetupSearchFilters extends Command
{
    protected $signature = 'scout:filters
        {index : The index you want to work with.}
    ';

    protected $description = 'Register filters against a search index.';

    public function handle(Client $client): int
    {
        $index = $this->argument(
            key: 'index',
        );

        $model = match ($index) {
            'products' => Product::class,
        };

        try {
            $this->info(
                string: "Updating filterable attributes for [$model] on index [$index]",
            );

            $client->index(
                uid: $index,
            )->updateFilterableAttributes(
                filterableAttributes: $model::getSearchFilterAttributes(),
            );
        } catch (Exception $exception) {
            $this->warn(
                string: $exception->getMessage(),
            );

            return self::FAILURE;
        }
        return 0;
    }
}
