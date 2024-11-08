<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->get('page', 1);
    
        $campaignsUrl = "http://10.99.23.111/lazismuDIY/backendLazismuDIY/public/api/campaigns?page={$page}";
        $categoriesUrl = "http://10.99.23.111/lazismuDIY/backendLazismuDIY/public/api/campaign-categories";

        $campaignsResponse = Http::get($campaignsUrl)->json();
        $categoriesResponse = Http::get($categoriesUrl)->json();

        return view('campaign.index', [
            'campaigns' => $campaignsResponse['data'],
            'categories' => $categoriesResponse,
            'pagination' => [
                'current_page' => $campaignsResponse['current_page'],
                'last_page' => $campaignsResponse['last_page'],
                'next_page_url' => $campaignsResponse['next_page_url'],
                'prev_page_url' => $campaignsResponse['prev_page_url']
            ]
        ]);
    }
    
    

    

    public function store(Request $request)
    {
        $requestHttp = Http::asMultipart();

        if ($request->hasFile('campaign_thumbnail')) {
            $requestHttp->attach(
                'campaign_thumbnail',
                fopen($request->file('campaign_thumbnail')->getPathname(), 'r'),
                $request->file('campaign_thumbnail')->getClientOriginalName()
            );
        }

        if ($request->hasFile('campaign_image1')) {
            $requestHttp->attach(
                'campaign_image1',
                fopen($request->file('campaign_image1')->getPathname(), 'r'),
                $request->file('campaign_image1')->getClientOriginalName()
            );
        }

        if ($request->hasFile('campaign_image2')) {
            $requestHttp->attach(
                'campaign_image2',
                fopen($request->file('campaign_image2')->getPathname(), 'r'),
                $request->file('campaign_image2')->getClientOriginalName()
            );
        }

        if ($request->hasFile('campaign_image3')) {
            $requestHttp->attach(
                'campaign_image3',
                fopen($request->file('campaign_image3')->getPathname(), 'r'),
                $request->file('campaign_image3')->getClientOriginalName()
            );
        }

        // Mengirim data ke API
        $response = $requestHttp->post('http://10.99.23.111/lazismuDIY/backendLazismuDIY/public/api/campaigns', [
            'campaign_category_id' => $request->input('campaign_category_id'),
            'campaign_name' => $request->input('campaign_name'),
            'campaign_code' => $request->input('campaign_code'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'target_amount' => $request->input('target_amount'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Campaign created successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to create campaign.');
        }
    }

    public function update(Request $request, $id)
{
    $requestHttp = Http::asMultipart();

    if ($request->hasFile('campaign_thumbnail')) {
        $requestHttp->attach(
            'campaign_thumbnail',
            fopen($request->file('campaign_thumbnail')->getPathname(), 'r'),
            $request->file('campaign_thumbnail')->getClientOriginalName()
        );
    }

    if ($request->hasFile('campaign_image1')) {
        $requestHttp->attach(
            'campaign_image1',
            fopen($request->file('campaign_image1')->getPathname(), 'r'),
            $request->file('campaign_image1')->getClientOriginalName()
        );
    }

    if ($request->hasFile('campaign_image2')) {
        $requestHttp->attach(
            'campaign_image2',
            fopen($request->file('campaign_image2')->getPathname(), 'r'),
            $request->file('campaign_image2')->getClientOriginalName()
        );
    }

    if ($request->hasFile('campaign_image3')) {
        $requestHttp->attach(
            'campaign_image3',
            fopen($request->file('campaign_image3')->getPathname(), 'r'),
            $request->file('campaign_image3')->getClientOriginalName()
        );
    }

    // Mengirim data ke API untuk update
    $response = $requestHttp->put("http://10.99.23.111/lazismuDIY/backendLazismuDIY/public/api/campaigns/{$id}", [
        'campaign_category_id' => $request->input('campaign_category_id'),
        'campaign_name' => $request->input('campaign_name'),
        'campaign_code' => $request->input('campaign_code'),
        'description' => $request->input('description'),
        'location' => $request->input('location'),
        'target_amount' => $request->input('target_amount'),
        'start_date' => $request->input('start_date'),
        'end_date' => $request->input('end_date'),
    ]);

    if ($response->successful()) {
        return redirect()->back()->with('success', 'Campaign updated successfully!');
    } else {
        return redirect()->back()->with('error', 'Failed to update campaign.');
    }
}


}
