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
        <div class="relatedNews relatedNews2 tagSearch">
            @if ($posts->count() > 0)
            <div class="fixCen2">
                @foreach ($posts as $post)
                <div class="post">
                    <a href="{{ url($post->slug.'.html') }}" class="imgThumb" title="" style="background: url({{ url($post->circle_image) }}) center center no-repeat;"></a>
                    <a href="{{ url($post->slug.'.html') }}" class="title" title="{{ $post->name }}">
                        {{ $post->name }}
                    </a>
                </div>
                @endforeach
            </div>
            @endif
            <a href="javascript:void(0)" class="btnPlus" title="Xem thêm" aria-label="View more">
                <img src="/frontend/assets/img/i_plus.png" alt="" class="imgFull">
            </a>
        </div>
    </main>
@endsection
