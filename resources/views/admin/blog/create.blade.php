@extends('admin.layout.app')
@section('page-title', 'Create Blog')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend-assets/plugins/ckeditor5-36.0.1-sy1shf6t1itx/content-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('backend-assets/plugins/select2/css/select2.min.css') }}">
@endsection

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.blog.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.blog.list.store') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="cat1_id">Category 1 * <span class="text-muted">(Multiple options can be selected)</span></label>
                                    <select class="select2 w-100" name="cat1_id[]" id="cat1_id" multiple="multiple" data-placeholder="Select category" data-dropdown-css-class="select2-purple" onchange="fetchBlogCat2s()">
                                        @forelse ($cat1s as $category)
                                            <option value="{{$category->id}}" 
                                                {{ (collect(old('cat1_id'))->contains($category->id)) ? 'selected':'' }}
                                            >{{$category->title}}</option>
                                        @empty
                                            <option value="">No data found</option>
                                        @endforelse
                                    </select>
                                    @error('cat1_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="cat2_id">Category 2 <span class="text-muted">(Optional - Multiple options can be selected)</span></label>
                                    <div id="category-2-container">
                                        <select name="cat2_id[]" id="cat2_id" class="form-control">
                                            <option value="" selected disabled>Select Category 1 first...</option>
                                        </select>
                                    </div>
                                    @error('cat2_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="image">Image *</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="image">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                    </div>
                                    {!! imageUploadNotice('blog-banner')['html'] !!}
                                    @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tags_id">Tags <span class="text-muted">(Optional - Multiple options can be selected)</span></label>
                                    <select class="select2 w-100" name="tags_id[]" id="tags_id" multiple="multiple" data-placeholder="Select tag" data-dropdown-css-class="select2-purple">
                                        @forelse ($tags as $tag)
                                            <option value="{{$tag->id}}" 
                                                {{ (collect(old('tags_id'))->contains($tag->id)) ? 'selected':'' }}
                                            >{{$tag->title}}</option>
                                        @empty
                                            <option value="">No data found</option>
                                        @endforelse
                                    </select>
                                    @error('tags_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title">Title <span class="text-muted">*</span></label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title') }}">
                                @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="short_desc">Short description <span class="text-muted">(within 1000 characters)</span></label>
                                <textarea name="short_desc" id="short_desc" class="form-control" placeholder="Enter short description">{{ old('short_desc') }}</textarea>
                                @error('short_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="detailed_desc">Detailed description *</label>
                                <textarea name="detailed_desc" id="detailed_desc" class="form-control ckeditor" placeholder="Enter detailed description" rows="6">{{ old('detailed_desc') }}</textarea>
                                @error('detailed_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="page_title">Page title <span class="text-muted">(Optional)</span></label>
                                <textarea name="page_title" id="page_title" class="form-control" placeholder="Enter Page title">{{ old('page_title') }}</textarea>
                                @error('page_title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_title">Meta title <span class="text-muted">(Optional)</span></label>
                                <textarea name="meta_title" id="meta_title" class="form-control" placeholder="Enter Meta title">{{ old('meta_title') }}</textarea>
                                @error('meta_title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_desc">Meta Description <span class="text-muted">(Optional)</span></label>
                                <textarea name="meta_desc" id="meta_desc" class="form-control" placeholder="Enter Meta Description">{{ old('meta_desc') }}</textarea>
                                @error('meta_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="meta_keyword">Meta Keyword <span class="text-muted">(Optional)</span></label>
                                <textarea name="meta_keyword" id="meta_keyword" class="form-control" placeholder="Enter Meta Keyword">{{ old('meta_keyword') }}</textarea>
                                @error('meta_keyword') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script src="{{ asset('backend-assets/plugins/ckeditor5-36.0.1-sy1shf6t1itx/build/ckeditor.js') }}"></script>
    <script src="{{ asset('backend-assets/js/ckeditor-custom.js') }}"></script>
    <script src="{{ asset('backend-assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('.select2').select2();

        function fetchBlogCat2s() {
            var opts = [];
            opts = $('#cat1_id').val();

            if(opts.length > 0) {
                //fetch category 2 matching with 1
                $.ajax({
                    url: "{{route('admin.blog.category1.category2.fetch')}}",
                    method: 'post',
                    data: {
                        _token: "{{csrf_token()}}",
                        data: opts,
                    },
                    success: function(result) {
                        let content = '';

                        content += `<select class="select2 w-100" name="cat2_id[]" id="cat2_id" multiple="multiple" data-placeholder="Select category 2" data-dropdown-css-class="select2-purple">`;

                        $.each(result.data, (key, value) => {
                            content += `
                            <option value="${value.id}">
                                ${value.title}
                            </option>
                            `;
                        });

                        content += `</select>`;

                        $('#category-2-container').html(content);
                        $('.select2').select2();
                    }
                });
            }
        }

        @if(!empty(old('cat1_id')))
            fetchBlogCat2s();
        @endif
    </script>
@endsection