<?php

namespace App\Console\Commands;

use App\Models\MyWaysStore;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GetTheMyWayAppsOffers extends Command
{
    protected $url;
    protected $data;
    protected $host;
    protected $version;
    protected $apiKey;
    protected $response;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'malom:myway-offers {--dev}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Get the MyWay app's offers";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->setConfig();

        $this->response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey,
        ])->get($this->url);

        $this->checkResponseStatus();
        $this->data = $this->response->collect()->where('posts', '!=', []);
        $this->checkData();
        $this->saveOffers();

        Log::info('MYWAY SAVE OFFERS: ' . now());
        $this->info('DONE');
        return true;
    }

    private function setConfig()
    {
        $config = config('malom.myway');

        $this->host = $this->option('dev')
            ? $config['host_dev']
            : $config['host'];

        $this->version = $config['version'];
        $this->apiKey = $config['apiKey'];
        $this->url = $this->host . '/' . $this->version . '/' . 'beacons?include=posts.postfields,posts.thumbnail,posts.postperiods';
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
            Log::error('MYWAY DATA IS EMPTY: ' . now());
            $this->info('DATA IS EMPTY');
            exit;
        }
    }

    private function getStoreId($item)
    {
        $store = MyWaysStore::query()
            ->where('myway_store_id', $item['minor'])
            ->orWhere('name', $item['description'])
            ->first();

        return isset($store->id) ? $store->id : false;
    }
    private function saveImage($offer)
    {
        $originalImageUrl = $offer['thumbnail']['urls']['thumbnail'];
        $offerId = $offer['id'];
        $offerSlug = $offerId . '-' . Str::slug($offer['name']);
        Storage::disk('local')->put('public/myway/' . $offerSlug . '.jpg', file_get_contents($originalImageUrl));
        return $offerSlug;
    }

    private function saveOffers()
    {
        $this->data->each(function ($item) {
            if (isset($item['minor'])) {
                $storeId = $this->getStoreId($item);
                $this->info($item['description']);
                $offers = collect($item['posts'])->where('type', 'posts');

                $offers->each(function ($offer) use ($storeId) {
                    $slug = $this->saveImage($offer);
                    try {
                        Offer::updateOrCreate(
                            [
                                'store_id' => $storeId,
                                'title' => preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $offer['name']),
                                'slug' => $slug
                            ],
                            [
                                'description' => isset($offer['postfields'][1]['content'])
                                    ? preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $offer['postfields'][1]['content'])
                                    : preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', json_decode($offer['postfields'][0]['content'], true)['text']),
                                'path' => 'images/myway-offers/' . $slug . '.jpg',
                                'thumbnail' => 'images/myway-offers/' . $slug . '.jpg',
                                'published_at' => Carbon::parse($offer['postperiods'][0]['start'])->format('Y-m-d'),
                                'started_at' => Carbon::parse($offer['postperiods'][0]['start'])->format('Y-m-d'),
                                'finished_at' => Carbon::parse($offer['postperiods'][0]['stop'])->format('Y-m-d'),
                            ]
                        );
                    } catch (\Throwable $th) {
                        Log::error('MYWAY ERROR OFFER:' . json_encode($offer) . now());
                        return true;
                    }
                });
            }
        });
    }
}
