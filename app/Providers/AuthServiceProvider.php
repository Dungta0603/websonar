<?php

namespace App\Providers;

use App\Models\Admin\Category;
use App\Models\Admin\Post;
use App\Models\Comment;
use App\Models\Role;
use App\Policies\CategoryPolicy;
use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
//        Category::class => CategoryPolicy::class,
//        Role::class => RolePolicy::class,
//        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('delete', function(User $user, Post $post) {
            return $user->id == $post->user_id || $user->can('delete-post');
        });


    }
}
