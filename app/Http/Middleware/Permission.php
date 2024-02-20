<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminPermissionCategory;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd('here');
        // return $next($request);

        if (Auth::guard('admin')->check()) {
            $requestPath = $request->path();

            $requestPathExploded = explode('/', $requestPath);

            // dd($requestPathExploded);

            $permissionCat = $requestPathExploded[1];
            $permissionSubCat = $requestPathExploded[2] ?? '';

            if ($permissionCat !== 'dashboard') {
                $catCheck = AdminPermissionCategory::where('title', 'like', '%'.$permissionCat.'%')->first();
                dd($catCheck);
            }

            

            // $role_id = Auth::guard('admin')->user()->role_id;

            // dd($request->path());

            // dd($role_id);
            return $next($request);
            // return redirect()->route('admin.error.403');
        }

        return redirect()->route('admin.login');
    }
}
