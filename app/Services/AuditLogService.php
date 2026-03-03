<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogService
{
    public function log(string $action, ?string $entityType = null, ?int $entityId = null, array $context = [], ?Request $request = null): void
    {
        $request = $request ?: request();
        $user = auth()->user();

        AuditLog::query()->create([
            'tenant_id' => $user?->tenant_id,
            'user_id' => $user?->id,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'context' => $context,
        ]);
    }
}
