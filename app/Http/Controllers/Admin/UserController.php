<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::withCount('orders')->orderBy('created_at', 'desc');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->has('role') && !empty($request->role)) {
            $query->where('role', $request->role);
        }
        
        // Filter by verification status
        if ($request->has('verified') && $request->verified !== '') {
            $query->where('is_verified', (bool)$request->verified);
        }
        
        $users = $query->paginate(15)->withQueryString();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|in:user,admin',
                'is_verified' => 'boolean'
            ]);
            
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_verified' => $request->has('is_verified'),
                'email_verified_at' => $request->has('is_verified') ? now() : null
            ]);
            
            Log::info("New user created by admin " . auth()->id() . ": {$request->email}");
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create user');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::with(['orders.orderItems.product'])->findOrFail($id);
            return view('admin.users.show', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error showing user: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'User not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.users.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error editing user: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'User not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => 'nullable|string|min:8',
                'role' => 'required|in:user,admin',
                'is_verified' => 'boolean'
            ]);
            
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'is_verified' => $request->has('is_verified'),
            ];
            
            // Update password only if provided
            if (!empty($request->password)) {
                $updateData['password'] = Hash::make($request->password);
            }
            
            // Update email verification timestamp
            if ($request->has('is_verified') && !$user->email_verified_at) {
                $updateData['email_verified_at'] = now();
            } elseif (!$request->has('is_verified')) {
                $updateData['email_verified_at'] = null;
            }
            
            $user->update($updateData);
            
            Log::info("User {$id} updated by admin " . auth()->id());
            
            return redirect()->route('admin.users.show', $id)
                ->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update user');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting current admin
            if ($user->id === auth()->id()) {
                return back()->with('error', 'You cannot delete your own account');
            }
            
            // Check if user has orders
            if ($user->orders()->count() > 0) {
                return back()->with('error', 'Cannot delete user with existing orders');
            }
            
            $email = $user->email;
            $user->delete();
            
            Log::info("User {$email} deleted by admin " . auth()->id());
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete user');
        }
    }
    
    /**
     * Toggle user verification status
     */
    public function toggleVerification(string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $user->update([
                'is_verified' => !$user->is_verified,
                'email_verified_at' => !$user->is_verified ? now() : null
            ]);
            
            $status = $user->is_verified ? 'verified' : 'unverified';
            Log::info("User {$id} marked as {$status} by admin " . auth()->id());
            
            return back()->with('success', "User marked as {$status} successfully");
        } catch (\Exception $e) {
            Log::error('Error toggling user verification: ' . $e->getMessage());
            return back()->with('error', 'Failed to update verification status');
        }
    }
}
