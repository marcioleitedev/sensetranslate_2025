<?php 
namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName(),
                'password' => bcrypt(Str::random(24)), 
            ]
        );

        $token = JWTAuth::fromUser($user);

        // Redireciona para /dashboard
         return redirect('/dashboard');

    }
}
