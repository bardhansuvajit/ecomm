@extends('front.layout.app')

@section('style')
<link rel="stylesheet" href="{{ asset('backend-assets/plugins/ckeditor5-36.0.1-sy1shf6t1itx/content-styles.css') }}">
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <section id="content-lists">
            <div id="breadcrumb">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{!! $data->title !!}</li>
                    </ol>
                </nav>
            </div>

            <div id="title">
                <h5>{!! $data->title !!}</h5>
            </div>

            <div id="content">
                <div class="ck-content">{!! $data->content !!}</div>
            </div>

            {{-- <div id="short-description">
                <p class="small text-muted review1 height-3 mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi veniam inventore enim alias earum mollitia sint ipsam ad maiores consequuntur odio, velit, distinctio itaque expedita molestias laborum accusamus nostrum. Suscipit officiis modi voluptatem iste at autem dignissimos dolores, aliquam sit deleniti impedit quaerat quae nam aliquid! Dolorum recusandae quasi nemo at voluptatem sed provident porro assumenda. Commodi facilis, ab error quaerat optio fugiat odio, atque minima aperiam, rem ex eligendi quidem eaque ratione perferendis libero nobis sint ipsum! Dolorum aliquid quo explicabo dolor maxime? Ratione sed fuga, recusandae ipsa itaque dignissimos, dolorum saepe omnis voluptates autem odit nemo vel provident?
                </p>
                <a href="javascript: void(0)" onclick="seeMoreText('review1', 'more-text1')" class="more-text1">See more</a>
            </div> --}}
        </section>
    </div>
</div>
@endsection