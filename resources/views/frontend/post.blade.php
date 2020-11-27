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
        <div class="fixCen2 flex">
            <div class="articleDetail">
                <h1 class="title">{{ $post->name }}</h1>
                <div class="authority"><i>Tác giả:</i> {{ $post->author->name }}</div>
                <article class="contentDetail">
                    {!! $post->content !!}
                </article>
                <div class="tagList">
                    @foreach ($post->mainTopics as $index => $topic)
                        <a href="{{ url('chu-de/'.$topic->slug) }}" title="{{ $topic->name }}">
                            {{ $topic->name }}
                        </a> {{ $index +1 < $post->mainTopics->count() ? '|' : '' }}
                    @endforeach
                </div>
                <div class="articleSameAuthority">
                    <h2 class="title">Cùng tác giả</h2>
                    @if ($sameAuthorPosts = \App\Helpers::getSameAuthorPosts($post))
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
                    @endif
                </div>
            </div>
            <div class="colRight">
                <h2 class="rightTitle">Tags</h2>
                <div class="tagListRight">
                    @foreach ($post->otherTopics as $otherTopic)
                        <a href="{{ url('chu-de/'.$otherTopic->slug) }}" title="{{ $otherTopic->name }}">{{ $otherTopic->name }}</a>
                    @endforeach
                </div>
                <h2 class="rightTitle">Popular</h2>
                @if ($popularPosts = \App\Helpers::getPopularPosts())
                <div class="popularList">
                    @foreach ($popularPosts as $popularPost)
                    <div class="post">
                        <a href="{{ url($popularPost->slug.'.html') }}" class="imgThumb" title="" style="background: url({{ url($popularPost->circle_image) }}) center center no-repeat #3aadbb;"></a>
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
                    <a href="{{ url($relatedPost->slug.'.html') }}" class="imgThumb" title="" style="background: url({{ url($relatedPost->circle_image) }}) center center no-repeat;">
                        <img src="{{ url($relatedPost->circle_image) }}" alt="" class="imgFull">
                    </a>
                    <div class="parentCategory">{{ $relatedPost->author->name }}</div>
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
