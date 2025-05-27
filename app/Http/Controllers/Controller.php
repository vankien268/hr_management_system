<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \App\Http\Controllers\Traits\APIResponseHandlerTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, APIResponseHandlerTrait;

    public function __construct()
    {
        if(!request()->has('is_delete')){
            request()->merge(['is_delete' => false]);
        }else {
            request()->merge(['is_delete' => true]);
        }
    }

    public function getUserStatistics(Request $request)
    {
        $filter = $request->get('filter', 'thisMonth');

        $labels = [];
        $data = [];

        if ($filter === 'thisMonth') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($filter === 'lastMonth') {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->subMonth()->endOfMonth();
        } elseif ($filter === 'thisYear') {
            $year = Carbon::now()->year;
        } elseif ($filter === 'lastYear') {
            $year = Carbon::now()->subYear()->year;
        }

        if (in_array($filter, ['thisMonth', 'lastMonth'])) {
            // Lấy tất cả users trong khoảng thời gian
            $users = DB::table('users')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->pluck('total', 'date'); // key: date, value: total

            // Tạo labels từ ngày đầu đến ngày cuối tháng
            $period = CarbonPeriod::create($startDate, $endDate);

            foreach ($period as $date) {
                $formatted = $date->format('d/m');
                $labels[] = $formatted;
                $data[] = $users[$date->toDateString()] ?? 0;
            }

        } elseif (in_array($filter, ['thisYear', 'lastYear'])) {
            // Lấy tất cả users theo tháng
            $users = DB::table('users')
                ->whereYear('created_at', $year)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->groupBy('month')
                ->pluck('total', 'month'); // key: month (1–12)

            for ($month = 1; $month <= 12; $month++) {
                $labels[] = 'Tháng ' . $month;
                $data[] = $users[$month] ?? 0;
            }
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Số lượng nhân viên',
                    'data' => $data,
                    'backgroundColor' => '#4CAF50',
                ]
            ]
        ]);
    }

    public function getUserByDepartmentStatistics(Request $request)
    {
        $filter = $request->get('filter', 'thisMonth'); // Mặc định: tháng này

        $query = DB::table('departments')
            ->leftJoin('users', 'departments.id', '=', 'users.department_id')
            ->select('departments.name', DB::raw('COUNT(users.id) as total_users'))
            ->groupBy('departments.id', 'departments.name');

        // Xử lý filter theo khoảng thời gian
        if (in_array($filter, ['thisMonth', 'lastMonth'])) {
            $date = Carbon::now();

            if ($filter === 'lastMonth') {
                $date->subMonth();
            }

            $start = $date->copy()->startOfMonth()->toDateString();
            $end = $date->copy()->endOfMonth()->toDateString();

            $query->whereBetween('users.created_at', [$start, $end]);
        }

        if (in_array($filter, ['thisYear', 'lastYear'])) {
            $year = Carbon::now()->year;
            if ($filter === 'lastYear') {
                $year -= 1;
            }

            $query->whereYear('users.created_at', $year);
        }

        $results = $query->get();

        // Labels: tên phòng ban
        $labels = $results->pluck('name');
        // Data: số nhân viên
        $data = $results->pluck('total_users');

        return response()->json([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Số lượng nhân viên',
                    'data' => $data,
                    'backgroundColor' => '#4CAF50',
                ]
            ]
        ]);
    }
}
