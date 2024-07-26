<?php

namespace App\Repositories;

use App\Interfaces\ActivityLogInterface;
use Illuminate\Support\Facades\DB;

use App\Models\ActivityLog;

use Jenssegers\Agent\Agent;

class ActivityLogRepository implements ActivityLogInterface
{
    public function add(array $data): array
    {
        $agent = new Agent();

        $log = new ActivityLog();
        $log->product_id = $data['id'];
        $log->category = $data['category'];
        $log->trigger_type = $data['trigger_type'];

        $log->user_agent = $agent->getUserAgent();
        $log->device_type = $agent->isDesktop() ? 'Desktop' : ($agent->isTablet() ? 'Tablet' : 'Mobile');
        $log->browser = $agent->browser();
        $log->browser_version = $agent->version($agent->browser());
        $log->platform = $agent->platform();
        $log->platform_version = $agent->version($agent->platform());
        $log->languages = json_encode($agent->languages());

        $log->user_id = (auth()->guard('web')->check()) ? auth()->guard('web')->user()->id : '';
        $log->ip_address = ipfetch();
        $log->save();

        return [
            'code' => 200,
            'status' => 'success',
            'message' => 'Data added',
            'data' => $data,
        ];
    }

    public function distinctProducts(int $userId, string $category, string $productId): array
    {
        $query = ActivityLog::query();

        $data = $query->where('user_id', $userId)
        ->where('category', $category)
        ->where('product_id', '!=', $productId)
        ->groupBy('product_id')
        ->latest('id')
        ->get();

        if (count($data) > 0) {
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Distinct data found',
                'data' => $data,
            ];
        } else {
            $response = [
                'code' => 404,
                'status' => 'failure',
                'message' => 'No data found'
            ];
        }

        return $response;
    }

}
