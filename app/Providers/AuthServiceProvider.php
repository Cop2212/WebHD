<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
// Nếu bạn có policy, import model và policy ở đây
// use App\Models\Question;
// use App\Policies\QuestionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        // Question::class => QuestionPolicy::class,

        \App\Models\Question::class => \App\Policies\QuestionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Bạn có thể khai báo Gate ở đây nếu không dùng Policy
        // Gate::define('update-question', function ($user, $question) {
        //     return $user->id === $question->user_id;
        // });
    }
}
