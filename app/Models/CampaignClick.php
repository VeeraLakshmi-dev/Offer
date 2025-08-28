<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignClick extends Model
{
        protected $fillable = ['upiid', 'campaign_id', 'code', 'payouts',];
}
