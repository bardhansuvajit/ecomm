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
        return $next($request);

        // 1. checking if logged in
        if (Auth::guard('admin')->check()) {
            $role_id = Auth::guard('admin')->user()->role_id;
            // 2. get request path
            $requestPath = $request->path();
            $requestPathExploded = explode('/', $requestPath);
            $pathExpCount = count($requestPathExploded);
            // dd(count($requestPathExploded),$requestPathExploded);

            // dd($requestPathExploded);

            // 3. get category & subcategory
            if ($requestPathExploded[$pathExpCount - 2] == 'admin') {
                $permissionCat = $requestPathExploded[$pathExpCount - 1];
                $permissionSubCat = 'list';
            } else {
                $permissionCat = $requestPathExploded[$pathExpCount - 2];
                $permissionSubCat = $requestPathExploded[$pathExpCount - 1] ?? 'list';
            }

            // dd($permissionCat, $permissionSubCat);

            // setup array
            if ($permissionSubCat == 'list' || $permissionSubCat == 'read') {
                $permissionSubCatArr = ['list', 'read'];
            } elseif ($permissionSubCat == 'create' || $permissionSubCat == 'setup') {
                $permissionSubCatArr = ['create', 'setup'];
            } else {
                $permissionSubCatArr = [$permissionSubCat];
            }

            // dd($permissionCat);

            if ($permissionCat != 'dashboard' && $permissionCat != 'logout') {
                // dd($permissionSubCatArr);
                $catCheck = AdminPermissionCategory::where('title', 'like', '%'.$permissionCat.'%')->first();

                if (!empty($catCheck)) {
                    foreach($catCheck->subCategories as $subcat) {
                        if ($subcat->title == $permissionSubCat) {
                            if ( ($subcat->permissionDetail->access == 1) && ($subcat->permissionDetail->role_id == $role_id) ) {
                                return $next($request);
                            } else {
                                return redirect()->route('admin.error.403');
                            }
                        }

                        if (in_array($subcat->title, $permissionSubCatArr)) {
                            // dd($subcat->permissionDetail->access, $role_id, $subcat->role_id);
                            // dd('matched with array');
                            if ( ($subcat->permissionDetail->access == 1) && ($subcat->permissionDetail->role_id == $role_id) ) {
                                return $next($request);
                            } else {
                                return redirect()->route('admin.error.403');
                            }
                        }
                    }

                    return redirect()->route('admin.error.403');

                } else {
                    return redirect()->route('admin.error.403');
                }
            } else {
                return $next($request);
            }
        }

        return redirect()->route('admin.login');
    }
}
