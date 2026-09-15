<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request): JsonResponse|RedirectResponse
    {
        // Honeypot: bots fill the hidden field — pretend success without saving.
        if ($request->filled('website')) {
            return $this->success($request);
        }

        Lead::create([
            ...$request->validated(),
            'status' => 'new',
            'source' => Str::limit((string) $request->headers->get('referer'), 250, ''),
            'ip' => $request->ip(),
        ]);

        return $this->success($request);
    }

    private function success(Request $request): JsonResponse|RedirectResponse
    {
        $message = 'Спасибо! Заявка отправлена — мы свяжемся с вами и предложим решение.';

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        // Without JS, return to the page the form was sent from (home or a service page)
        return redirect()->to(strtok(url()->previous(), '#').'#contact')->with('lead_success', $message);
    }
}
