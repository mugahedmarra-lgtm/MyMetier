<?php

use App\Models\AnalyticsEvent;
use Illuminate\Support\Facades\Auth;

if (!function_exists('trackEvent')) {
    /**
     * Track an analytics event.
     *
     * @param string $type       e.g. whatsapp_click, profile_view, search_performed
     * @param string|null $entityType  e.g. profile, search
     * @param int|null $entityId
     * @param array $meta        Additional metadata to store
     */
    function trackEvent(string $type, ?string $entityType = null, ?int $entityId = null, array $meta = []): void
    {
        try {
            AnalyticsEvent::create([
                'user_id'     => Auth::id(),
                'event_type'  => $type,
                'entity_type' => $entityType,
                'entity_id'   => $entityId,
                'meta'        => !empty($meta) ? $meta : null,
                'created_at'  => now(),
            ]);
        } catch (\Throwable $e) {
            // Silently fail — analytics must never break the app
            report($e);
        }
    }
}
