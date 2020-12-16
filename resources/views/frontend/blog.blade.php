@extends('frontend.layout_home')

@section('after_head')
    @include('frontend.meta')
@endsection


@section('content')
    <main>
        <div class="topBlog">
            @if ($latestPost = \App\Helpers::getLatestPost())
            <div class="fixCen2">
                <a href="{{ url($latestPost->slug.'.html') }}" class="imgThumb" title="{{$latestPost->name}}" style="background: url({{ $latestPost->anh2 ? url($latestPost->anh2) : url($latestPost->image) }}) center top no-repeat;">
                    <img src="{{ $latestPost->anh2 ? url($latestPost->anh2) : url($latestPost->image) }}" alt="" class="imgFull">
                </a>
                <div class="rightSide">
                    <h2 class="title">
                        <a href="{{ url($latestPost->slug.'.html') }}" title="{{$latestPost->name}}">{{$latestPost->name}}</a>
                    </h2>
                    <div class="des">
                        {{$latestPost->desc}}
                    </div>
                    @if ($latestPost->author)
                        <div class="author">
                            <i>Tác giả:</i>  {{$latestPost->author->name }}
                        </div>
                    @endif
                    <div class="tagList">
                        @foreach ($latestPost->topics as $index => $latestPostTopic)
                            <a href="{{ url('chu-de/'.$latestPostTopic->slug) }}" title="{{ $latestPostTopic->name }}">
                                {{ $latestPostTopic->name }}
                            </a> {{ $index + 1 < $latestPost->topics->count() ? '|' : '' }}
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="manyTags">
            <h2 class="rightTitle">Các chủ đề phổ biến</h2>
            @if ($popularTopics = \App\Helpers::getPopularTopics())
            <div class="fixCen2">
                @foreach ($popularTopics as $popularTopic)
                    <a href="{{ url('chu-de/'.$popularTopic->slug) }}" title="{{ $popularTopic->name }}">
                        {{ $popularTopic->name }}
                    </a>
                @endforeach
            </div>
            @endif
        </div>
        <div class="relatedNews relatedNews2">
            @if ($popularPosts = \App\Helpers::getPopularPosts())
            <div class="fixCen2">
                @foreach ($popularPosts as $popularPost)
                    @if ($popularPost->id != $latestPost->id)
                    <div class="post">
                        <a href="{{ url($popularPost->slug.'.html') }}" class="imgThumb" title="" style="background: url({{ url($popularPost->image) }}) center center no-repeat #3aadbb;"></a>
                        <div class="parentCategory">{{ \App\Helpers::getMainTopicPost($popularPost) }}</div>
                        <a href="{{ url($popularPost->slug.'.html') }}" class="title" title="{{ $popularPost->name }}">
                            {{ $popularPost->name }}
                        </a>
                    </div>
                    @endif
                @endforeach
            </div>
            @endif
            <a href="javascript:void(0)" class="btnPlus" title="Xem thêm" aria-label="View more">
                <img src="/frontend/assets/img/i_plus.png" alt="" class="imgFull">
            </a>
        </div>
        <div class="manyTags mb50">
            <h2 class="rightTitle">Các chủ đề</h2>
            @if ($popularTopics = \App\Helpers::getAllTopics())
                <div class="fixCen2">
                    @foreach ($popularTopics as $popularTopic)
                        <a href="{{ url('chu-de/'.$popularTopic->slug) }}" title="{{ $popularTopic->name }}">
                            {{ $popularTopic->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
@endsection
