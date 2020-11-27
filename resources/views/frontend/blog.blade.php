@extends('frontend.layout_home')

@section('after_head')
    <meta content='GCL' name='generator'/>
    <title>{{$meta_title}}</title>

    <meta property="og:title" content="{{$meta_title}}">
    <meta property="og:description" content="{{$meta_desc}}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{$meta_url}}">
    <meta property="og:image" content="{{$meta_image}}">
    <meta property="og:site_name" content="{{ \App\Helpers::configGet('website_name') }}">
    <meta property="fb:app_id" content="{{ \App\Helpers::configGet('facebook_app_id') }}" />

    <meta name="twitter:card" content="Card">
    <meta name="twitter:url" content="{{$meta_url}}">
    <meta name="twitter:title" content="{{$meta_title}}">
    <meta name="twitter:description" content="{{$meta_desc}}">
    <meta name="twitter:image" content="{{$meta_image}}">


    <meta itemprop="name" content="{{$meta_title}}">
    <meta itemprop="description" content="{{$meta_desc}}">
    <meta itemprop="image" content="{{$meta_image}}">

    <meta name="ABSTRACT" content="{{$meta_desc}}"/>
    <meta http-equiv="REFRESH" content="1200"/>
    <meta name="REVISIT-AFTER" content="1 DAYS"/>
    <meta name="DESCRIPTION" content="{{$meta_desc}}"/>
    <meta name="KEYWORDS" content="{{$meta_keywords}}"/>
    <meta name="ROBOTS" content="index,follow"/>
    <meta name="AUTHOR" content="{{ \App\Helpers::configGet('website_name') }}"/>
    <meta name="RESOURCE-TYPE" content="DOCUMENT"/>
    <meta name="DISTRIBUTION" content="GLOBAL"/>
    <meta name="COPYRIGHT" content="Copyright 2013 by Goethe"/>
    <meta name="Googlebot" content="index,follow,archive" />
    <meta name="RATING" content="GENERAL"/>
@endsection


@section('content')
    <main>
        <div class="topBlog">
            @if ($latestPost = \App\Helpers::getLatestPost())
            <div class="fixCen2">
                <a href="{{ url($latestPost->slug.'.html') }}" class="imgThumb" title="{{$latestPost->name}}" style="background: url({{ url($latestPost->square_image) }}) center top no-repeat;">
                    <img src="{{ url($latestPost->square_image) }}" alt="" class="imgFull">
                </a>
                <div class="rightSide">
                    <h2 class="title">
                        <a href="{{ url($latestPost->slug.'.html') }}" title="{{$latestPost->name}}">{{$latestPost->name}}</a>
                    </h2>
                    <div class="des">
                        {{$latestPost->desc}}
                    </div>
                    <div class="author">
                        <i>Tác giả:</i>  {{$latestPost->author->name }}
                    </div>
                    <div class="tagList">
                        @foreach ($latestPost->mainTopics as $index => $latestPostTopic)
                            <a href="{{ url('chu-de/'.$latestPostTopic->slug) }}" title="{{ $latestPostTopic->name }}">
                                {{ $latestPostTopic->name }}
                            </a> {{ $index + 1 < $latestPost->mainTopics->count() ? '|' : '' }}
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
                    <div class="post">
                        <a href="{{ url($popularPost->slug.'.html') }}" class="imgThumb" title="" style="background: url({{ url($popularPost->square_image) }}) center center no-repeat #3aadbb;"></a>
                        <a href="{{ url($popularPost->slug.'.html') }}" class="title" title="{{ $popularPost->name }}">
                            {{ $popularPost->name }}
                        </a>
                    </div>
                @endforeach
            </div>
            @endif
            <a href="javascript:void(0)" class="btnPlus" title="Xem thêm" aria-label="View more">
                <img src="/frontend/assets/img/i_plus.png" alt="" class="imgFull">
            </a>
        </div>
        <div class="manyTags mb50">
            <h2 class="rightTitle">Các chủ đề</h2>
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
    </main>
@endsection
