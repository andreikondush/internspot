<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Requests\Authorization as AuthorizationRequest;
use App\Http\Requests\Registration as RegistrationRequest;

class AuthController extends Controller
{
    public function authorization(): View
    {
        return view('authorization');
    }

    public function authorizationAction(AuthorizationRequest $request): JsonResponse
    {
        $validated = $request->only(['email', 'password']);

        $user = User::whereEmail($validated['email'])->first();

        if ($user instanceof User) {
            if (password_verify($validated['password'], optional($user)->getAuthPassword())) {

                Auth::guard('user')->login($user);

                return response()->json([
                    'redirect' => route('internships.list'),
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => "Wrong email and password combination.",
            'errors' => ['email' => false, 'password' => false],
        ]);
    }

    public function registration(): View
    {
        return view('registration');
    }

    public function registrationAction(RegistrationRequest $request): JsonResponse
    {
        $validated = $request->safe()->only([
            'first_name', 'last_name', 'email', 'password',
        ]);

        $role = Role::whereName('student')->first();

        if ($role instanceof Role) {

            // Create new user
            $user = new User();
            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->email = $validated['email'];
            $user->password = $validated['password'];
            $user->role_id = $role->id;
            $user->save();

            Auth::guard('user')->login($user);

            return response()->json([
                'redirect' => route('internships.list'),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => "Failed to register account.",
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        try {
            Auth::logout();
        } catch (\Exception) {  }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
