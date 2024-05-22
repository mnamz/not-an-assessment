<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::with('restaurant')->get();

        if ($request->expectsJson()) {
            return response()->json([
                'data' => $users,
            ]);    
        } else {
            return Inertia::render('User/Index', [
                'users' => $users,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['restaurant']);
        return Inertia::render('User/Show', [
            'user' => $user,
            'user_status' => array_column(UserStatus::cases(), 'value'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->banner('User: ' . $user->name . ' has been updated');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->banner('User: ' . $user->name . ' has been deleted');
    }

}
