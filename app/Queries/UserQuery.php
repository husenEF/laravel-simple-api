<?php

namespace App\Queries;

use App\Models\User;
use Illuminate\Http\Request;

class UserQuery
{
    public static function apply(Request $request)
    {
        $search  = $request->query('search');
        $sortBy  = $request->query('sortBy', 'created_at'); // default sorting
        $page    = $request->query('page', 1);

        $allowedSorts = ['name', 'email', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        return User::query()
            ->where('active', true)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->withCount('orders')
            ->orderBy($sortBy, 'asc')
            ->paginate(10, ['*'], 'page', $page);
    }
}
