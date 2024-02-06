@extends('admin.layout.app')
@section('page-title', 'Blog feature list')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h5 class="font-weight-bold text-primary">Featured Blog list</h5>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="d-flex justify-content-end">
                                        <div class="form-group ml-2">
                                            <input type="search" class="form-control form-control-sm" name="featuredBlogKeyword" id="featuredBlogKeyword" value="" placeholder="Search something..." onkeyup="fetchFeaturedBlogs()">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <div id="featuredBlogs">
                                    <p class="text-muted my-5">Loading...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h5 class="font-weight-bold text-primary">All Blogs</h5>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="d-flex justify-content-end">
                                        <div class="form-group ml-2">
                                            <input type="search" class="form-control form-control-sm" name="keyword" id="keyword" value="{{ request()->input('keyword') }}" placeholder="Search something...">
                                        </div>

                                        <div class="form-group ml-2">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-filter"></i>
                                                </button>
                                                <a href="{{ url()->current() }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Clear filter">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm table-striped table-hover">
                                    <tbody>
                                        @foreach ($blogsList as $index => $blog)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="mr-2" id="customCheck{{$index}}" onchange="addToFeatureBlog({{ $blog->id }})" {{ (collect($blogFeatures)->contains($blog->id)) ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <label for="customCheck{{$index}}">
                                                    <div class="media">
                                                        <img src="{{ asset($blog->image_small) }}" alt="image" class="img-thumbnail mr-3" style="height: 70px">

                                                        <div class="media-body">
                                                            <a href="{{ route('admin.blog.list.detail', $blog->id) }}" target="_blank"><p class="text-muted mb-2">{{ $blog->title }}</p></a>

                                                            <p class="text-muted small height-2">
                                                                {{ $blog->short_desc }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="pagination-container">
                                    {{$blogsList->appends($_GET)->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        function fetchFeaturedBlogs() {
            $.ajax({
                url: "{{route('blog.featured.fetch')}}",
                method: 'post',
                data: {
                    _token: "{{csrf_token()}}",
                    keyword: $('input[name="featuredBlogKeyword"]').val()
                },
                success: function(result) {
                    let content = '';

                    if (result.status == 200) {
                        content += `<div class="row sortable" data-position-update-route="{{ route('admin.blog.feature.position') }}" data-csrf-token="{{ csrf_token() }}">`;

                        $.each(result.data, (key, value) => {
                            content += `
                            <div class="col-md-4 single" id="${value.feature_id}">
                                <div class="card text-left">
                                    <img class="card-img-top" src="${value.image}" alt="image">
                                    <div class="card-body p-2">
                                        <a href="${value.link}" target="_blank"><p class="text-muted mb-2">${value.title}</p></a>

                                        <p class="text-muted small height-2">${value.short_desc}</p>
                                    </div>
                                </div>
                            </div>
                            `;
                        });
                    } else {
                        content += `<p class="text-muted my-5">No data yet...</p>`;
                    }

                    $('#featuredBlogs').html(content);

                    // jquery UI sortable calling again
                    // as not working on ajax load
                    $( ".sortable" ).sortable({
                        delay: 150,
                        stop: function() {
                            var selectedData = new Array();
                            var route = $(this).attr('data-position-update-route');
                            var token = $(this).attr('data-csrf-token');
                            $('.sortable > .single').each(function() {
                                selectedData.push($(this).attr('id'));
                            });
                            updatePosition(selectedData, route, token);
                        }
                    });
                }
            });
        }

        function addToFeatureBlog(blogId) {
            $.ajax({
                url: "{{route('blog.featured.add')}}",
                method: 'post',
                data: {
                    _token: "{{csrf_token()}}",
                    blog_id: blogId,
                },
                beforeSend: function() {
                    toastFire('info', 'Please wait...');
                },
                success: function(result) {
                    toastFire('success', result.message);
                    if (result.status == 200) {
                        fetchFeaturedBlogs();
                    }
                }
            });
        }

        fetchFeaturedBlogs();
    </script>
@endsection
