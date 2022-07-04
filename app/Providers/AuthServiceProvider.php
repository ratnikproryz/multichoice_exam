<?php

namespace App\Providers;

use App\Models\ChoiceSubmission;
use App\Models\Question;
use App\Models\Submission;
use App\Models\Test;
use App\Policies\ChoiceSubmissionPolicy;
use App\Policies\QuestionPolicy;
use App\Policies\SubmissionPolicy;
use App\Policies\TestPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Test::class => TestPolicy::class,
        Question::class => QuestionPolicy::class,
        Submission::class => SubmissionPolicy::class,
        ChoiceSubmission::class => ChoiceSubmissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
