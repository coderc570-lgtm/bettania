<?php

namespace App\Http\Controllers;

use App\Mail\LoginVerificationMail;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Modules\Auth\AuthServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthenticationController extends Controller
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Handle an authentication attempt.
     *
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'code'    => 'required|string',
        ]);
    
        $verification = VerificationCode::where('user_id', $request->user_id)
            ->where('code', $request->code)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();
    
        if (! $verification) {
            return response()->json([
                'message' => 'Invalid or expired verification code.',
            ], 422);
        }
    
        $verification->update(['is_used' => true]);
    
        $user = User::findOrFail($request->user_id);
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful.',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    public function checkAuth(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json([
                'isLoggedIn' => true,
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                ],
            ]);
        } else {
            return response()->json([
                'isLoggedIn' => false,
                'user' => null,
            ]);
        }
    }
    /**
     * Handle password reset requests
     *
     */
    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');

        $this->authService->forgotPassword($email);

        return response()->json(['message' => 'Reset request processed, If we find the email in our database, you will receive the link via email to reset your password'], 200);
    }

    /**
     * Reset password request due to forgotten password
     * 
     */
    public function resetPassword(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $passwordConfirmation = $request->input('password');
        $token = $request->input('token');

        $isSuccess = $this->authService->resetPassword($email, $password, $passwordConfirmation, $token);

        if ($isSuccess) {
            return response()->json(['message' => 'Password reset successfully'], 200);
        } else {
            return response()->json(['message' => 'Password reset failed'], 400);
        }
    }

    /**
     * Invalidate the user's session
     * 
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'User logged out successfully'], 200);
    }

    public function requestLoginCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        DB::beginTransaction();
        
        try {

            $user = User::where('email', $request->email)->firstOrFail();

            $code = rand(100000, 999999);
            
            VerificationCode::create([
                'user_id' => $user->id,
                'code' => $code,
                'expires_at' => now()->addMinutes(10),
            ]);
        
            Mail::to($user->email)->send(new LoginVerificationMail($code, $user));
            DB::commit();
            return response()->json(['message' => 'Login code sent to your email', 'user_id' => $user->id], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to process login code request', 'error_message' => $e->getMessage()], 500);
        }
    
    }
}