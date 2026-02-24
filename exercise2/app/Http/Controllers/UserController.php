<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            User::query()
                ->from('users as u1')
                ->leftJoin('users as u2', 'u2.employee_id', '=', 'u1.id')
                ->leftJoin('users as u3', 'u3.collaborator_id', '=', 'u1.id')
                ->whereRaw('DATE(u1.created_at) >= DATE_SUB(NOW(), INTERVAL 1 YEAR)')
                ->whereRaw('DATE(u2.created_at) >= DATE_SUB(NOW(), INTERVAL 1 YEAR)')
                ->whereRaw('DATE(u3.created_at) >= DATE_SUB(NOW(), INTERVAL 1 YEAR)')
                ->select(
                    'u1.id',
                    'u1.name',
                    'u1.email',
                    'u2.name as employee_name',
                    'u2.email as employee_email',
                    'u3.name as collaborator_name',
                    'u3.email as collaborator_email'
                )
                ->get()
        );
    }
}
