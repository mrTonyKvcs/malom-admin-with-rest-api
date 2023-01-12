<?php

namespace App\Console\Commands;

use App\Models\MyWaysStore;
use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetTheMyWayAppsStoresId extends Command
{
    protected $url;
    protected $data;
    protected $apiKey;
    protected $response;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'malom:get-myway-stores-id {--dev}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the MyWay apps stores id!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stores = Store::get()->count();
        $this->setConfig();

        $this->response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey,
        ])->get($this->url);

        $this->checkResponseStatus();

        $this->data = collect($this->response->collect()->first()['shopcategories']);
        $this->checkData();
        $this->data->each(function ($stores) {
            collect($stores['shops'])->each(function ($store) {
                MyWaysStore::updateOrCreate([
                    'myway_store_id' => $store['id'],
                    'name'           => $store['name'],
                    'store_id'       => $store['external_id']
                ]);
            });
        });

        Log::info('MYWAY GET STORE: ' . now());
        $this->info('DONE');
        return true;
    }

    private function setConfig()
    {
        $config = config('malom.myway');

        $host = $this->option('dev')
            ? $config['host_dev']
            : $config['host'];

        $version = $config['version'];
        $this->apiKey = $config['apiKey'];
        $this->url = $host . '/' . $version . '/' . 'organizations?include=shopcategories.shops';
    }

    private function checkResponseStatus()
    {
        if ($this->response->status() !== 200) {
            Log::error('MYWAY RESPONSE ERROR: ' . now());
            $this->error('RESPONSE ERROR!');
            exit;
        }
    }

    private function checkData()
    {
        if ($this->data->isEmpty()) {
            Log::info('MYWAY DATA IS EMPTY: ' . now());
            $this->info('DATA IS EMPTY');
            exit;
        }
    }
}
