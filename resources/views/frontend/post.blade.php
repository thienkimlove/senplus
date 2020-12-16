@extends('frontend.layout_home')

@section('after_head')
    @include('frontend.meta')
@endsection


@section('content')
    <main>
        <div class="fixCen2 flex">
            <div class="articleDetail">
                <h1 class="title">{{ $post->name }}</h1>
                @if ($post->author)
                    <div class="authority"><i>Tác giả:</i> {{ $post->author->name }}</div>
                @endif
                <article class="contentDetail">
                    {!! $post->content !!}
                </article>
                <div class="tagList">
                    @foreach ($post->topics as $index => $topic)
                        <a href="{{ url('chu-de/'.$topic->slug) }}" title="{{ $topic->name }}">
                            {{ $topic->name }}
                        </a> {{ $index +1 < $post->topics->count() ? '|' : '' }}
                    @endforeach
                </div>
                @if ($sameAuthorPosts = \App\Helpers::getSameAuthorPosts($post))
                <div class="articleSameAuthority">
                    <h2 class="title">Cùng tác giả</h2>

                    <ul class="listNews">
                        @foreach ($sameAuthorPosts as $sameAuthorPost)
                        <li>
                            <h3>
                                <a href="{{ url($sameAuthorPost->slug.'.html') }}" title="{{ $sameAuthorPost->name }}">
                                    {{ $sameAuthorPost->name }}
                                </a>
                            </h3>
                        </li>

                        @endforeach

                    </ul>

                </div>
                @endif
            </div>
            <div class="colRight">
                <h2 class="rightTitle">Tags</h2>
                <div class="tagListRight">
                    @foreach (\App\Helpers::getAllTopics() as $otherTopic)
                        <a href="{{ url('chu-de/'.$otherTopic->slug) }}" title="{{ $otherTopic->name }}">{{ $otherTopic->name }}</a>
                    @endforeach
                </div>
                <h2 class="rightTitle">Popular</h2>
                @if ($popularPosts = \App\Helpers::getPopularPosts(5))
                <div class="popularList">
                    @foreach ($popularPosts as $popularPost)
                    <div class="post">
                        <a href="{{ url($popularPost->slug.'.html') }}" class="imgThumb" title="" style="background: url({{ $popularPost->anh2 ? url($popularPost->anh2) : url($popularPost->image) }}) center center no-repeat #3aadbb;"></a>
                        <a href="{{ url($popularPost->slug.'.html') }}" class="title" title="{{ $popularPost->name }}">
                            {{ $popularPost->name }}
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        <div class="relatedNews">
            @if ($relatedPosts = \App\Helpers::getRelatedPosts($post))
            <div class="fixCen2">
                @foreach ($relatedPosts as $relatedPost)
                <div class="post">
                    <a href="{{ url($relatedPost->slug.'.html') }}" class="imgThumb" title="" style="background: url({{ url($relatedPost->image) }}) center center no-repeat;">
                        <img src="{{ url($relatedPost->image) }}" alt="" class="imgFull">
                    </a>


                    <div class="parentCategory">
                        @if ($topicMain = \App\Helpers::getMainTopicPost($relatedPost))
                            <a href="{{ route('frontend.topic') }}/{{ $topicMain->slug }}">{{ $topicMain->name }}</a>
                        @endif
                    </div>

                    <a href="{{ url($relatedPost->slug.'.html') }}" class="title" title="{{ $relatedPost->name }}">
                        {{ $relatedPost->name }}
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </main>
@endsection
