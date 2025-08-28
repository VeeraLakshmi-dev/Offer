<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class BackfillConversions extends Command
{
    protected $signature = 'trackier:backfill-conversions';
    protected $description = 'Backfill conversions from Trackier API';

    public function handle()
    {
        $this->info("Starting backfill...");

        $apiKey = "675c1ad42f98baba43c39c0f99b675c1ad42f9b6";
        $start = now()->subMonths(3)->format('Y-m-d 00:00:00');
        $end   = now()->format('Y-m-d H:i:s');
        $intervalDays = 30;
        $url = "https://api.trackier.com/v2/network/conversions";
        $client = new Client();
        $currentStart = $start;

        while (strtotime($currentStart) < strtotime($end)) {
            $currentEnd = date('Y-m-d 23:00:00', strtotime("+$intervalDays days", strtotime($currentStart)));
            if (strtotime($currentEnd) > strtotime($end)) {
                $currentEnd = $end;
            }

            try {
                $response = $client->request('GET', $url, [
                    'query' => [
                        'apiKey'   => $apiKey,
                        'start'    => $currentStart,
                        'end'      => $currentEnd,
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
            } catch (\Exception $e) {
                $this->error("API Error: " . $e->getMessage());
            }

            $currentStart = date('Y-m-d 00:00:00', strtotime("+1 second", strtotime($currentEnd)));
        }

        $this->info("Backfill complete!");
    }
}

