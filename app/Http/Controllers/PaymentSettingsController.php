<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentSettingsController extends Controller
{
    public function edit(): View
    {
        $settings = [
            'epayco_public_key'  => SiteContent::get('epayco_public_key', ''),
            'epayco_private_key' => SiteContent::get('epayco_private_key', ''),
            'epayco_p_cust_id'   => SiteContent::get('epayco_p_cust_id', ''),
            'epayco_p_key'       => SiteContent::get('epayco_p_key', ''),
            'epayco_test_mode'   => SiteContent::get('epayco_test_mode', 'true'),
        ];

        $isConfigured = SiteContent::isEpaycoConfigured();

        return view('admin.pagos-config', compact('settings', 'isConfigured'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'epayco_public_key'  => ['nullable', 'string', 'max:255'],
            'epayco_private_key' => ['nullable', 'string', 'max:255'],
            'epayco_p_cust_id'   => ['nullable', 'string', 'max:255'],
            'epayco_p_key'       => ['nullable', 'string', 'max:255'],
        ]);

        $keys = [
            'epayco_public_key',
            'epayco_private_key',
            'epayco_p_cust_id',
            'epayco_p_key',
        ];

        foreach ($keys as $key) {
            SiteContent::updateOrCreate(
                ['key' => $key],
                ['value' => $validated[$key] ?? '']
            );
            SiteContent::clearCache($key);
        }

        // Test mode toggle
        $testMode = $request->has('epayco_test_mode') ? 'true' : 'false';
        SiteContent::updateOrCreate(
            ['key' => 'epayco_test_mode'],
            ['value' => $testMode]
        );
        SiteContent::clearCache('epayco_test_mode');

        return redirect()->route('admin.pasarela.edit')
            ->with('success', 'Configuraci&oacute;n de ePayco actualizada correctamente.');
    }
}
