<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StreamingController extends Controller
{
    /**
     * Admin: show streaming configuration form.
     */
    public function config(): View
    {
        $settings = [
            'streaming_youtube_url' => SiteContent::get('streaming_youtube_url', ''),
            'streaming_title'       => SiteContent::get('streaming_title', 'Segunda Gala FECOER - En Vivo'),
            'streaming_description' => SiteContent::get('streaming_description', ''),
            'streaming_enabled'     => SiteContent::get('streaming_enabled', 'false'),
        ];

        $isActive = SiteContent::isStreamingActive();

        return view('admin.streaming-config', compact('settings', 'isActive'));
    }

    /**
     * Admin: update streaming configuration.
     */
    public function updateConfig(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'streaming_youtube_url' => ['nullable', 'string', 'max:500'],
            'streaming_title'       => ['nullable', 'string', 'max:255'],
            'streaming_description' => ['nullable', 'string', 'max:2000'],
        ]);

        $keys = ['streaming_youtube_url', 'streaming_title', 'streaming_description'];

        foreach ($keys as $key) {
            SiteContent::updateOrCreate(
                ['key' => $key],
                ['value' => $validated[$key] ?? '']
            );
            SiteContent::clearCache($key);
        }

        $enabled = $request->has('streaming_enabled') ? 'true' : 'false';
        SiteContent::updateOrCreate(
            ['key' => 'streaming_enabled'],
            ['value' => $enabled]
        );
        SiteContent::clearCache('streaming_enabled');

        return redirect()->route('admin.streaming.config')
            ->with('success', 'Configuraci&oacute;n de streaming actualizada correctamente.');
    }

    /**
     * Public: watch the stream (requires paid ticket).
     */
    public function watch(): View
    {
        $streamingEnabled = SiteContent::get('streaming_enabled', 'false') === 'true';
        $youtubeUrl       = SiteContent::get('streaming_youtube_url', '');
        $title            = SiteContent::get('streaming_title', 'Segunda Gala FECOER - En Vivo');
        $description      = SiteContent::get('streaming_description', '');
        $embedUrl         = SiteContent::getYoutubeEmbedUrl($youtubeUrl);

        // Check if streaming is active
        if (!$streamingEnabled || empty($embedUrl)) {
            return view('streaming', [
                'access'   => 'inactive',
                'title'    => $title,
                'embedUrl' => '',
                'description' => '',
            ]);
        }

        // Check if user has a paid VIRTUAL ticket (presencial tickets don't include streaming)
        $user = Auth::user();
        $hasPaidVirtualTicket = false;
        $hasPendingVirtualTicket = false;

        if ($user) {
            $hasPaidVirtualTicket = Order::where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->orWhere('email', $user->email);
                })
                ->where('status', 'paid')
                ->where('ticket_type', 'virtual')
                ->exists();

            if (!$hasPaidVirtualTicket) {
                $hasPendingVirtualTicket = Order::where(function ($q) use ($user) {
                        $q->where('user_id', $user->id)
                          ->orWhere('email', $user->email);
                    })
                    ->where('status', 'pending')
                    ->where('ticket_type', 'virtual')
                    ->exists();
            }
        }

        if (!$hasPaidVirtualTicket) {
            return view('streaming', [
                'access'           => $hasPendingVirtualTicket ? 'pending' : 'denied',
                'title'            => $title,
                'embedUrl'         => '',
                'description'      => '',
            ]);
        }

        return view('streaming', [
            'access'      => 'granted',
            'title'       => $title,
            'embedUrl'    => $embedUrl,
            'description' => $description,
        ]);
    }
}
