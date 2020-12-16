@foreach ($popularPosts as $popularPost)
    <div class="post">
        <a href="{{ url($popularPost->slug.'.html') }}" class="imgThumb" title="" style="background: url({{ url($popularPost->image) }}) center center no-repeat #3aadbb;"></a>
        <div class="parentCategory">
        @if ($topicMain = \App\Helpers::getMainTopicPost($popularPost))
            <a href="{{ route('frontend.topic') }}/{{ $topicMain->slug }}">{{ $topicMain->name }}</a>
        @endif
        </div>
        <a href="{{ url($popularPost->slug.'.html') }}" class="title" title="{{ $popularPost->name }}">
            {{ $popularPost->name }}
        </a>
    </div>
@endforeach