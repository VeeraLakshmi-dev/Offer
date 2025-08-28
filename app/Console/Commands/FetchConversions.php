<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class FetchConversions extends Command
{
    protected $signature = 'trackier:fetch-conversions';
    protected $description = 'Fetch conversions from Trackier API and save to DB';

    public function handle()
    {
        $this->info("Fetching conversions...");

        $apiKey = "675c1ad42f98baba43c39c0f99b675c1ad42f9b6";
        $url = "https://api.trackier.com/v2/network/conversions";
        $client = new Client();

        $start = now()->startOfDay()->format('Y-m-d H:i:s');
        $end   = now()->endOfDay()->format('Y-m-d H:i:s');

        try {
                $response = $client->request('GET', $url, [
                    'query' => [
                        'apiKey'   => $apiKey,
                        'start'    => $start,
                        'end'      => $end,
                        'fields[]' => ['publisher_id', 'p2', 'click_id', 'payout', 'campaign_id'],
                    ]
                ]);

                $body = json_decode($response->getBody(), true);
                $records = $body['conversions'] ?? ($body['data'] ?? $body);

                $filtered = array_filter($records, fn($c) =>
                    isset($c['publisher_id']) && $c['publisher_id'] == 2
                );

                foreach ($filtered as $conversion) {
                    $exists = DB::table('conversions')->where('click_id', $conversion['click_id'])->first();
                    $offerclick = DB::table('offer_clicks')
                        ->where('campaign_id', $conversion['campaign_id'])
                        ->where('p2', $conversion['p2'] ?? null)
                        ->first();

                    if ($offerclick && !$exists) {
                        DB::table('conversions')->insert([
                            'publisher_id' => $conversion['publisher_id'],
                            'user_id'      => $offerclick->p2,
                            'click_id'     => $conversion['click_id'],
                            'payout'       => $conversion['payout'] ?? 0,
                            'campaign_id'  => $conversion['campaign_id'],
                            'created_at'   => now(),
                            'updated_at'   => now(),
                        ]);
                    }
                }
                $this->info("Conversions fetched successfully.");
            }
        catch (\Exception $e)
             {
                $this->error("API Error: " . $e->getMessage());
             }
    }
}
