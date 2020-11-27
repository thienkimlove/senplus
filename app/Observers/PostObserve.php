<?php

namespace App\Observers;

use App\Models\Post;

class PostObserve
{
    public function created(Post $content)
    {
        return $content->transform();
    }

    public function updated(Post $content)
    {
        return $content->transform();
    }
}
