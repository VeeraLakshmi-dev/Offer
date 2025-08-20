<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\OfferClick;
use Illuminate\Http\Request;
class TrackierController extends Controller
{
    public function getCampaigns()
    {
        $apiKey = '685a7380997284cfa6a177ab3fa685a738099760';
        $response = Http::withHeaders([
            'X-Api-Key' => $apiKey
        ])->get('https://api.trackier.com/v2/publisher/campaigns');

        if ($response->successful()) {
            $data = $response->json();
            $campaigns = $data['data']['campaigns'] ?? [];

            return view('offers', [
                'campaigns' => $this->processCampaigns($campaigns)
            ]);
        }

        return view('offers', ['campaigns' => []]);
    }

    protected function processCampaigns($campaigns)
    {
        return array_map(function($campaign) {
            return [
                'id' => $campaign['id'],
                'title' => $campaign['title'],
                'description' => $campaign['description'] ?? '',
                'payout' => $this->getPayout($campaign),
                'tracking_link' => $campaign['tracking_link'],
                'preview_url' => $campaign['preview_url'] ?? null,
                'thumbnail' => $campaign['thumbnail'] ?? null,
            ];
        }, $campaigns);
    }

    protected function getPayout($campaign)
    {
        $payout = 0;

        if (isset($campaign['payouts'])) {
            foreach ($campaign['payouts'] as $payoutData) {
                $payout = max($payout, $payoutData['payout']);
            }
        }
        return $payout;
    }

    public function store(Request $request)
    {
       $data = $request->all();

        $offerClick = new OfferClick();
        $offerClick->campaign_id = $data['campaign_id'];
        $offerClick->upi_id = $data['upi_id'];
        $offerClick->save();

        return response()->json(['success' => true, 'message' => 'Offer click recorded successfully.']);
    }
}
