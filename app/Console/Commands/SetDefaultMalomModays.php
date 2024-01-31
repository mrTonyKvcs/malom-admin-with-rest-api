<?php

namespace App\Console\Commands;

use App\Models\Monday;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SetDefaultMalomModays extends Command
{
    protected $data;
    protected $store;
    protected $mondays;
    protected $newMonday;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'malom:set-m-mondays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the malom mondays with stores';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->setConfigs();

        foreach ($this->mondays as $monday) {
            $this->createMonday($monday);
            foreach ($this->data as $item) {
                $this->findAndUpdateTheStore($item);
                $this->attachMondayToStore();
            }
        }

        $this->info('DONE');
    }

    private function setConfigs()
    {
        $this->mondays = config('malom.mondays');
        $jsonData = Storage::get('public/malom-mondays/24-active.json');
        $this->data = json_decode($jsonData, true);
    }

    private function createMonday($monday)
    {
        $slug = Str::slug($monday['title']);
        $this->newMonday = Monday::updateOrCreate([
            'title' => $monday['title'],
            'published_at' => $monday['published_at']
        ], [
            'slug' => $slug
        ]);
    }

    private function findAndUpdateTheStore($item)
    {
        $this->store = Store::where('name', 'LIKE', '%' . $item['name'] . '%')->first();
        if (empty($store)) {
            return true;
        }
        $this->store->update(['mondays_text' => $item['text']]);
    }

    private function attachMondayToStore()
    {
        if ($this->store && !$this->store->mondays->contains($this->newMonday->id)) {
            $this->store->mondays()->attach($this->newMonday->id, [], false);
        }
    }
}
