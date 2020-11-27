<?php

namespace App\Observers;

use App\Models\Post;

class PostObserve
{
    public function created(Post $content)
    {
        return $content->afterCreated();
    }

    public function updated(Post $content)
    {
        return $content->afterCreated();
    }
}
