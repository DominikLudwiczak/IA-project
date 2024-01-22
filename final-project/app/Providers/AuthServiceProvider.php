<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return env('FRONT_APP_URL', null)."/reset-password?token=$token&email=".urlencode($user->email);
        });

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            $parsedUrl = parse_url($url);
            $parsedUrl['host'] = env('FRONT_APP_URL', 'localhost:4200');
            $modifiedUrl = $parsedUrl['host']."/confirm-email"."/".array_reverse(explode('/', $parsedUrl['path']))[0];

            if (isset($parsedUrl['query'])) {
                $modifiedUrl .= '?' . $parsedUrl['query'];
            }

            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $modifiedUrl);
        });
    }
}
