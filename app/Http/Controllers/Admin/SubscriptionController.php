<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::query()
            ->withoutGlobalScope('tenant')
            ->with(['tenant', 'plan', 'modules'])
            ->latest()
            ->paginate(20);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function updateStatus(Request $request, Subscription $subscription)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in([
                Subscription::STATUS_TRIALING,
                Subscription::STATUS_ACTIVE,
                Subscription::STATUS_PAST_DUE,
                Subscription::STATUS_CANCELED,
            ])],
        ]);

        $subscription->update($data);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription status updated.');
    }
}
