<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\CampaignClick;

class CampaignController extends Controller
{
    public function create()
    {
        return view('campaign.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required',
            'url'         => 'required',
            'payouts'      => 'required|numeric|min:0',
        ]);

        // Generate a 15-digit random code
        $uniqueCode = str_pad(random_int(0, 999999999999999), 15, '0', STR_PAD_LEFT);

        // Replace {id} placeholder if present
        $finalUrl = str_replace('{id}', $uniqueCode, $request->url);

        // Save campaign
        $campaign = Campaign::create([
            'name'        => $request->name,
            'description' => $request->description,
            'url'         => $finalUrl,
            'payouts'      => $request->payouts,
            'code'        => $uniqueCode,
        ]);

        if (!$campaign) {
            return back()->with('error', 'Failed to create campaign.');
        }

        return redirect()->route('admin.campaigns.create')->with('success', 'Campaign created successfully.');
    }
    public function specialOffers()
    {
        $camps = Campaign::orderBy('id', 'desc')->get();
        return view('specialOffers', ['camps' => $camps]);
    }
    public function specialClicks(Request $request)
    {
        // Validate input
        $request->validate([
            'upiid'       => 'required|string|max:255',
            'campaign_id' => 'required|exists:campaigns,id',
            'code'        => 'required|string|max:15',
            'payouts'     => 'required|numeric|min:0',
        ]);
        $cam = CampaignClick::where('upiid', $request->upiid)->where('campaign_id',$request->campaign_id)->first();
        if($cam){
            return redirect()->away($request->url);
        }
        // Save campaign click
        $campaignClick = CampaignClick::create([
            'upiid'       => $request->upiid,
            'campaign_id' => $request->campaign_id,
            'code'        => $request->code,
            'payouts'     => $request->payouts,
        ]);

        if (!$campaignClick) {
            return back()->with('error', 'Failed to record click.');
        }

        return redirect()->away($request->url);
    }

}
