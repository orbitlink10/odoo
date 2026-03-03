<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\UpdateTenantSettingsRequest;

class SettingsController extends Controller
{
    public function edit()
    {
        $tenant = auth()->user()->tenant;

        abort_if(! $tenant, 404);

        return view('app.settings', compact('tenant'));
    }

    public function update(UpdateTenantSettingsRequest $request)
    {
        $tenant = $request->user()->tenant;

        abort_if(! $tenant, 404);

        $settings = $tenant->settings ?? [];
        $settings['sms_provider'] = $request->input('sms_provider');
        $settings['email_provider'] = $request->input('email_provider');
        $settings['vat_rate'] = $request->input('vat_rate', 16);

        $tenant->update([
            'name' => $request->input('name'),
            'country' => strtoupper($request->input('country')),
            'timezone' => $request->input('timezone'),
            'currency' => strtoupper($request->input('currency')),
            'logo_path' => $request->input('logo_path'),
            'settings' => $settings,
        ]);

        return redirect()->route('app.settings.edit')->with('success', 'Settings updated.');
    }
}
