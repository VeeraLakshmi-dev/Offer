<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\OfferClick;
use App\Models\Campaign;
use App\Models\CampaignClick;
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

            $camps = Campaign::orderBy('id', 'desc')->get();

            return view('offers', [
                'campaigns' => $this->processCampaigns($campaigns),
                'camps' => $camps
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

        // 🔍 Check if same campaign & UPI already exists
        $existingClick = OfferClick::where('campaign_id', $data['campaign_id'])
            ->where('upi_id', $data['upi_id'])
            ->first();

        if ($existingClick) {
            // Already exists → return the same tracking link
            $trackingUrl = "https://herody.gotrackier.io/click?campaign_id="
                . $existingClick->campaign_id
                . "&pub_id=2&p2=" . $existingClick->p2;

            return response()->json([
                'success' => true,
                'message' => 'Offer click already exists.',
                'redirect_url' => $trackingUrl
            ]);
        }

        // 🚀 Otherwise create a new one
        $lastClick = OfferClick::where('campaign_id', $data['campaign_id'])
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastClick ? ((int) $lastClick->p2 + 1) : 1;
        $formattedCode = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $offerClick = new OfferClick();
        $offerClick->campaign_id = $data['campaign_id'];
        $offerClick->upi_id = $data['upi_id'];
        $offerClick->p2 = $formattedCode;
        $offerClick->save();

        // Build tracking URL
        $trackingUrl = "https://herody.gotrackier.io/click?campaign_id="
            . $data['campaign_id']
            . "&pub_id=2&p2=" . $formattedCode;

        return response()->json([
            'success' => true,
            'message' => 'Offer click recorded successfully.',
            'redirect_url' => $trackingUrl
        ]);
    }
    public function store1(Request $request)
    {
        $data = $request->all();
        dd($data);
        $existingClick = CampaignClick::where('campaign_id', $data['campaign_id1'])
            ->where('upi_id', $data['upi_id1'])
            ->first();

        if ($existingClick) {
            return response()->json([
                'success' => true,
                'message' => 'Offer click already exists.',
                'redirect_url' => $data['tracking_link1']
            ]);
        }

        $offerClick = new CampaignClick();
        $offerClick->campaign_id = $data['campaign_id1'];
        $offerClick->upi_id = $data['upi_id1'];
        $offerClick->p2 = $data['code'];
        $offerClick->save();

        return response()->json([
            'success' => true,
            'message' => 'Offer click recorded successfully.',
            'redirect_url' => $data['tracking_link1']
        ]);
    }

}
