<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function GetRoles()
    {
        try {
            $roles = Role::select('id', 'name')->get();
            return response()->json(['roles' => $roles]);
        } catch (Exception $e) {
            Log::info("Error in Role Fetching: " . $e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
