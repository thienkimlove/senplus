@foreach ($popularPosts as $popularPost)
    <div class="post">
        <a href="{{ url($popularPost->slug.'.html') }}" class="imgThumb" title="" style="background: url({{ url($popularPost->image) }}) center center no-repeat #3aadbb;"></a>
        <div class="parentCategory">{{ \App\Helpers::getMainTopicPost($popularPost) }}</div>
        <a href="{{ url($popularPost->slug.'.html') }}" class="title" title="{{ $popularPost->name }}">
            {{ $popularPost->name }}
        </a>
    </div>
@endforeach