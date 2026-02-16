<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Contact;
use App\Policies\ContactPolicy;
use App\Models\Task;
use App\Policies\TaskPolicy;
use App\Interfaces\ContactServiceInterface;
use App\Services\ContactService;
use App\Interfaces\TaskServiceInterface;
use App\Services\TaskService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContactServiceInterface::class, ContactService::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Contact::class, ContactPolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verifique seu endereço de e-mail')
                ->line('Clique no botão abaixo para verificar seu endereço de e-mail.')
                ->action('Verificar E-mail', $url)
                ->line('Se você não criou uma conta, ignore este e-mail.');
        });
    }
}
