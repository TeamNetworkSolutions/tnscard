<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * TNS Card: "Get your TNS Card" form on the landing page.
 * Forwards each lead to the CRM webhook set in .env (LEADS_WEBHOOK_URL)
 * and keeps a local copy in storage/app/leads.jsonl.
 */
class LeadController extends Controller
{
    public function store(Request $request)
    {
        // Only accept submissions sent from this site.
        $origin = (string) ($request->headers->get('origin') ?: $request->headers->get('referer'));
        $host = $request->getHost();
        if ($origin !== '' && parse_url($origin, PHP_URL_HOST) !== $host) {
            return response()->json(['ok' => false], 403);
        }

        // Honeypot: real visitors never fill this hidden field.
        if ($request->filled('company_website')) {
            return response()->json(['ok' => true]);
        }

        // Bots submit instantly; people take a few seconds.
        $openedAt = (int) $request->input('form_opened_at', 0);
        if ($openedAt > 0 && (time() - $openedAt) < 3) {
            return response()->json(['ok' => true]);
        }

        $data = $request->validate([
            'name'     => 'required|string|max:120',
            'phone'    => 'required|string|max:40',
            'email'    => 'required|email|max:160',
            'business' => 'nullable|string|max:160',
            'product'  => 'required|string|in:wristband,card,sticker,keychain,other',
            'quantity' => 'nullable|string|max:40',
            'message'  => 'nullable|string|max:2000',
            'lang'     => 'nullable|string|in:en,es',
        ]);

        $lead = array_merge($data, [
            'source'       => 'tnscard.com',
            'submitted_at' => now()->toIso8601String(),
            'ip'           => $request->ip(),
            'page'         => $request->headers->get('referer', ''),
        ]);

        // Local backup, one JSON object per line.
        try {
            $dir = storage_path('app');
            if (!is_dir($dir)) { mkdir($dir, 0775, true); }
            file_put_contents($dir . '/leads.jsonl', json_encode($lead, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND | LOCK_EX);
        } catch (\Throwable $e) {
            Log::warning('Lead backup failed: ' . $e->getMessage());
        }

        // Forward to the CRM (GoHighLevel inbound webhook or any other URL).
        $webhook = trim((string) env('LEADS_WEBHOOK_URL', ''));
        $forwarded = false;
        if ($webhook !== '') {
            try {
                $response = Http::timeout(10)->acceptJson()->post($webhook, $lead);
                $forwarded = $response->successful();
                if (!$forwarded) {
                    Log::warning('Lead webhook returned ' . $response->status());
                }
            } catch (\Throwable $e) {
                Log::warning('Lead webhook failed: ' . $e->getMessage());
            }
        }

        return response()->json(['ok' => true, 'forwarded' => $forwarded]);
    }
}
