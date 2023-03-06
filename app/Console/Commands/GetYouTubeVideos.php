<?php

namespace App\Console\Commands;

use App\Models\Vlog as ModelsVlog;
use App\Models\YouTubePlaylist;
use App\Models\YouTubeVideo;
use App\Vlog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetYouTubeVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'malom:youtube-videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Malom Channel all videos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $API_KEY = config('malom.youtube.API_KEY');
        $allPlaylists = config('malom.youtube.playlists');

        foreach ($allPlaylists as $key => $playlists) {
            $playlistType = $key;
            foreach ($playlists as $playlistId) {
                $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=$playlistId&key=$API_KEY";
                $playlistItems = json_decode(file_get_contents($url));

                foreach ($playlistItems->items as $video) {
                    $publishedAt = Carbon::parse($video->snippet->publishedAt)->format('Y-m-d');
                    $videoId = $video->snippet->resourceId->videoId;

                    YouTubeVideo::updateOrCreate(
                        ['video_id' => $videoId],
                        [
                            'playlist_name' => $playlistType == YouTubePlaylist::WORKSHOP ? YouTubePlaylist::WORKSHOP : YouTubePlaylist::VLOG,
                            'title' => remove_emoji($video->snippet->title),
                            'description' => $video->snippet->description,
                            'published_at' => $publishedAt,
                        ]
                    );
                }
            }
        }

        $this->info('SUCCESS');
    }
}
