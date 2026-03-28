<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:64'],
            'consent_offer' => ['accepted'],
            'consent_marketing' => ['sometimes', 'boolean'],
        ]);

        $data['consent_offer'] = $request->boolean('consent_offer');
        $data['consent_marketing'] = $request->boolean('consent_marketing');

        Lead::query()->create($data);

        return redirect()->route('home')->with('lead_ok', true);
    }
}
