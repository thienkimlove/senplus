@extends('frontend.layout_home')

@section('after_head')
    @include('frontend.meta')
@endsection


@section('content')
    <main>
        <div class="relatedNews relatedNews2 tagSearch">
            @if ($posts->count() > 0)
            <div class="fixCen2">
                @foreach ($posts as $post)
                <div class="post">
                    <a href="{{ url($post->slug.'.html') }}" class="imgThumb" title="" style="background: url({{ url($post->image) }}) center center no-repeat;"></a>
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
