<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // redirection apres la deconnection 
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse{
            public function toResponse($request){
                return redirect()->route("login");
            }
        });

        // redirection apres la connexion selon le role 
        $this->app->instance(LoginResponse::class, new class implements LoginResponse{
            public function toResponse($request){
                if(auth()->user()->role == "admin"){
                    return redirect()->route("dashboard");
                }else{
                   return redirect("/") ;
                }
            }
        });

        // redirection apres inscription
       $this->app->instance(RegisterResponse::class, new class implements RegisterResponse{
            public function toResponse($request){
                if(auth()->user()->role == "admin"){
                    return redirect()->route("dashboard");
                }else{
                   return redirect("/") ;
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        
        // pour l'inscription
        Fortify::registerView(function(){
            return view("auth.register");
        });
        
        // pour la connexion
        Fortify::loginView(function(){
            return view("auth.login");
        });

        // reiniatialisation de mot de passe 
        Fortify::requestPasswordResetLinkView(function(){
            return view("auth.forgot-password");
        });

        // reset-password 
        Fortify::resetPasswordView(function(Request $request){
            return view("auth.reset-password",["request"=>$request]);
        });
    }
}