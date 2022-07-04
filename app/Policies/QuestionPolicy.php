<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use App\Models\Test;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can manage the question of the test
     */

    public function manage(User $user, Question $question, Test $test)
    {
        return $user->id === $test->user_id
            && $test->id === $question->test_id;
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Question $question)
    {
        //
    }
}
