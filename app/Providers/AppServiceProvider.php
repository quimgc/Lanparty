<?php

namespace App\Providers;

use Acacha\User\GuestUser;
use App\Invitation;
use App\InvitationCodeGenerator;
use App\InvitationCodeGeneratorComplex;
use App\InvitationCodeGeneratorSimple;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use View;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view) {
            if (Auth::user()) {
                $view->with('user',Auth::user());
            } else {
                $view->with('user',new GuestUser);
            }
            $view->with('registrations_enabled', $this->registrationsAreEnabled() ? 'true' : 'false');
        });
    }

    /**
     * Check if registrations are enabled.
     *
     * @return bool
     */
    protected function registrationsAreEnabled()
    {
        return Carbon::parse(config('lanparty.registration_start_date'))->isPast();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InvitationCodeGenerator::class, function(){

            if(config('codes.type') == 'simple'){

                return new InvitationCodeGeneratorSimple();

            } else if(config('codes.type') == 'complex') {

                return new InvitationCodeGeneratorComplex();

            }else {

                dd('error');

            }

        });
    }
}
