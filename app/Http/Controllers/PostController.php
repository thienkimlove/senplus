<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Customer;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function privacy()
    {
        $page = 'privacy';

        $meta = [];
        $meta['meta_title'] = Helpers::configGet('meta_index_title');
        $meta['meta_desc'] = Helpers::configGet('meta_index_desc');
        $meta['meta_keywords'] = Helpers::configGet('meta_index_keywords');
        $meta['meta_image'] = url('frontend/assets/img/logo-sm.png');
        $meta['meta_url'] = route('frontend.privacy');

        $isStyleBlog = true;

        return view('frontend.privacy', compact('page', 'isStyleBlog'))->with($meta);


    }

    public function deactivated()
    {
        $page = 'privacy';

        $meta = [];
        $meta['meta_title'] = Helpers::configGet('meta_index_title');
        $meta['meta_desc'] = Helpers::configGet('meta_index_desc');
        $meta['meta_keywords'] = Helpers::configGet('meta_index_keywords');
        $meta['meta_image'] = url('frontend/assets/img/logo-sm.png');
        $meta['meta_url'] = route('frontend.deactivated');


        return view('frontend.cas.deactivated', compact('page'))->with($meta);


    }



    public function postDeactivated(Request $request)
    {
        $email = $request->input('email');

        $customer = Customer::where('email', $email)->first();

        if ($customer) {
            $customer->delete();

            return response()->json(['success' => 'Your email is removed from our database']);
        }

        return response()->json(['error' => 'Email của bạn không tồn tại trong hệ thóng']);
    }

    public function blog()
    {

        $page = 'blog';

        $meta = [];
        $meta['meta_title'] = Helpers::configGet('meta_index_title');
        $meta['meta_desc'] = Helpers::configGet('meta_index_desc');
        $meta['meta_keywords'] = Helpers::configGet('meta_index_keywords');
        $meta['meta_image'] = url('frontend/assets/img/logo-sm.png');
        $meta['meta_url'] = route('frontend.blog');
        $isStyleBlog = true;
        $latestPost = Helpers::getLatestPost();

        $popularPosts = Post::where('status', true)
            ->where('id', '<>', $latestPost->id)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('frontend.blog', compact('page', 'isStyleBlog', 'latestPost', 'popularPosts'))->with($meta);
    }

    public function ajax(Request $request)
    {
        $page = $request->input('page');
        $latestPost = Helpers::getLatestPost();
        $popularPosts = Post::where('status', true)->where('id', '<>', $latestPost->id)->orderBy('updated_at', 'desc')->paginate(9);

        $page = $popularPosts->count() == 9 ? $page+1: 0;

        if ($popularPosts) {
            return response()->json([
                'html' => view('frontend.partials.index_posts', compact('popularPosts'))->render(),
                'page' => $page
            ]);
        } else {
            return response()->json([
                'html' => "",
                'page' => $page
            ]);
        }
    }

    public function topic($slug)
    {

        $page =  'topic';
        $isStyleBlog = true;

        $topic = Topic::findBySlug($slug);

        if ($topic) {
            $meta_title = $topic->name;
            $meta_desc = "";
            $meta_keywords = "";

            $posts = Post::where('status', true)
                ->whereHas('topics', function ($q) use ($topic) {
                    $q->where('id', $topic->id);
                })
                ->orderBy('updated_at', 'desc')
                ->paginate(10, ['*'], 'p');


            $meta['meta_title'] = $meta_title;
            $meta['meta_desc'] = $meta_desc;
            $meta['meta_keywords'] = $meta_keywords;
            $meta['meta_image'] = url('frontend/assets/img/logo-sm.png');
            $meta['meta_url'] = route('frontend.topic', $slug);

            $contentBlogUrl = route('frontend.topic', $slug);
            $contentBlogName = $topic->name;

            return view('frontend.topic', compact('posts', 'topic', 'contentBlogUrl', 'contentBlogName', 'page', 'isStyleBlog'))->with($meta);
        }

        return redirect(route('frontend.blog'));
    }

    public function search(Request $request)
    {

        $page =  'search';
        $isStyleBlog = true;

        $slug = $request->input('q');

        $meta_title = "Tìm kiếm theo từ khóa ".$slug;
        $meta_desc = "";
        $meta_keywords = "";

        $posts = Post::where('status', true)
            ->where('name', 'like', '%'.$slug.'%')
            ->orderBy('updated_at', 'desc')
            ->paginate(10, ['*'], 'p');


        $meta['meta_title'] = $meta_title;
        $meta['meta_desc'] = $meta_desc;
        $meta['meta_keywords'] = $meta_keywords;
        $meta['meta_image'] = url('frontend/assets/img/logo-sm.png');
        $meta['meta_url'] = route('frontend.search').'?q='.$slug;

        $contentBlogUrl = route('frontend.search').'?q='.$slug;
        $contentBlogName = $slug;

        return view('frontend.topic', compact('posts', 'page', 'contentBlogUrl', 'contentBlogName', 'isStyleBlog'))->with($meta);
    }

    public function main($value)
    {
        $page = 'post';
        $isStyleBlog = true;
        if (preg_match('/([a-z0-9\-]+)\.html/', $value, $matches)) {

            $post = Post::findBySlug($matches[1]);

            if ($post) {
                $post->update(['views' => (int) $post->views + 1]);
                $meta['meta_title'] = $post->name;
                $meta['meta_desc'] = $post->desc;
                $meta['meta_keywords'] = ($post->tagList) ? implode(',', $post->tagList) : null;
                $meta['meta_image'] = url($post->image);
                $meta['meta_url'] = route('frontend.main', $post->slug.'.html');

                return view('frontend.post', compact('post', 'page', 'isStyleBlog'))->with($meta);
            }

        }

        return redirect(route('frontend.blog'));
    }
}
