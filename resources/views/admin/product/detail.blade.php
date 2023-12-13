@extends('admin.layout.app')
@section('page-title', 'Product detail')

@section('style')
<link rel="stylesheet" href="{{ asset('frontend-assets/plugins/ckeditor5-36.0.1-sy1shf6t1itx/content-styles.css') }}">
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
                                <a href="{{ route('admin.product.list.all') }}" class="btn btn-sm btn-primary"> <i class="fa fa-chevron-left"></i> Back</a>

                                <a href="{{ route('admin.product.setup.category.edit', $data->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">Status</p>
                        <div class="row">
                            <div class="col-md-3">
                                <select name="status" id="status" class="form-control form-control-sm mb-4 w-50" data-route="{{ route('admin.product.status', $data->id) }}">
                                    <option value="0" {{ ($data->status == 0) ? 'selected' : '' }}>Draft</option>
                                    <option value="1" {{ ($data->status == 1) ? 'selected' : '' }}>Show</option>
                                    <option value="2" {{ ($data->status == 2) ? 'selected' : '' }}>Hide</option>
                                    <option value="3" {{ ($data->status == 3) ? 'selected' : '' }}>Out of Stock</option>
                                    <option value="4" {{ ($data->status == 4) ? 'selected' : '' }}>Coming Soon</option>
                                </select>
                            </div>
                        </div>

                        <p class="small text-muted mb-0">Images</p>
                        @if (!empty($data->frontImageDetails) && count($data->frontImageDetails) > 0)
                            <div class="d-flex mb-3">
                                @foreach ($data->frontImageDetails as $image)
                                    @if (!empty($image->img_small) && file_exists(public_path($image->img_small)))
                                        <img src="{{ asset($image->img_small) }}" alt="image" class="img-thumbnail mr-3" style="height: 100px">
                                    @else
                                        <img src="{{ asset('backend-assets/images/placeholder.jpg') }}" alt="image" style="height: 50px" class="mr-2">
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Type</p>
                        <p class="text-dark">{{ ($data->type == 1) ? 'Product' : 'Kit' }}</p>

                        <p class="small text-muted mb-0">Category</p>
                        <div class="row">
                            <div class="col-md-3"><p>{!! productCategories($data->id, 1, 'vertical') !!}</p></div>
                            <div class="col-md-3"><p>{!! productCategories($data->id, 2, 'vertical') !!}</p></div>
                            <div class="col-md-3"><p>{!! productCategories($data->id, 3, 'vertical') !!}</p></div>
                            <div class="col-md-3"><p>{!! productCategories($data->id, 4, 'vertical') !!}</p></div>
                        </div>

                        <p class="small text-muted mb-0">Title</p>
                        @if ($data->title)
                            <p class="text-dark">{{ $data->title }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Slug</p>
                        @if ($data->slug)
                            <p class="text-dark">{{ $data->slug }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Short description</p>
                        @if ($data->short_description)
                            <p class="text-dark">{!! nl2br($data->short_description) !!}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <hr>

                        <p class="small text-muted mb-0">Pricing</p>
                        @if (!empty($data->pricing) && count($data->pricing) > 0)
                            @foreach ($data->pricing as $pricing)
                                <h5 class="text-primary font-weight-bold">
                                    {!! $pricing->currency->entity !!} - 
                                    <span>{{ strtoupper($pricing->currency->name) }}</span>
                                    <small class="text-muted">({{ $pricing->currency->full_name }})</small>
                                </h5>

                                <div class="row">
                                    <div class="col-md-3">
                                        <table class="table table-sm table-striped table-hover mb-3">
                                            <tbody>
                                                <tr>
                                                    <td>Cost</td>
                                                    <td>
                                                        {!! $pricing->currency->entity !!}
                                                        {{ $pricing->cost }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>MRP</td>
                                                    <td>
                                                        @if ($pricing->mrp > 0)
                                                            {!! $pricing->currency->entity !!}
                                                            {{ $pricing->mrp }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Selling price</td>
                                                    <td>
                                                        {!! $pricing->currency->entity !!}
                                                        {{ $pricing->selling_price }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Profit/ unit sell:</td>
                                                    <td>
                                                        {!! $pricing->currency->entity !!}
                                                        {{ sprintf('%0.2f', $pricing->selling_price - $pricing->cost) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <hr>

                        <p class="small text-muted mb-0">Highlight</p>
                        @if (count($data->frontHighlightDetails) > 0)
                            <table class="table table-sm table-striped table-hover mb-3">
                            @foreach ($data->frontHighlightDetails as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            @if (!empty($item->image_small))
                                                <img src="{{ asset($item->image_small) }}" alt="image" height="30" class="mr-3">
                                            @endif
                                            <div class="text-part">
                                                <p class="text-dark mb-1">{{ $item->title }}</p>
                                                <p class="small text-muted mb-0">{{ $item->details }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <hr>

                        <p class="small text-muted mb-0">Detailed description</p>
                        @if ($data->long_description)
                            <div class="ck-content">{!! $data->long_description !!}</div>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <hr>

                        <p class="small text-muted mb-0">Usage</p>
                        @if (count($data->frontUsageDetails) > 0)
                            <table class="table table-sm table-striped table-hover mb-3">
                            @foreach ($data->frontUsageDetails as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            @if (!empty($item->image_small))
                                                <img src="{{ asset($item->image_small) }}" alt="image" height="30" class="mr-3">
                                            @endif
                                            <div class="text-part">
                                                <p class="text-dark mb-1">{{ $item->title }}</p>
                                                <p class="small text-muted mb-0">{{ $item->details }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <hr>

                        <p class="small text-muted mb-0">Box item</p>
                        @if (count($data->frontBoxItems) > 0)
                            <table class="table table-sm table-striped table-hover mb-3">
                            @foreach ($data->frontBoxItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            @if (!empty($item->image_small))
                                                <img src="{{ asset($item->image_small) }}" alt="image" height="30" class="mr-3">
                                            @endif
                                            <div class="text-part">
                                                <p class="text-dark mb-1">{{ $item->title }}</p>
                                                <p class="small text-muted mb-0">{{ $item->details }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <hr>

                        <p class="small text-muted mb-0">Page title</p>
                        @if ($data->page_title)
                            <p class="text-dark">{{ nl2br($data->page_title) }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Meta title</p>
                        @if ($data->meta_title)
                            <p class="text-dark">{{ nl2br($data->meta_title) }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Meta description</p>
                        @if ($data->meta_desc)
                            <p class="text-dark">{{ nl2br($data->meta_desc) }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif

                        <p class="small text-muted mb-0">Meta keyword</p>
                        @if ($data->meta_keyword)
                            <p class="text-dark">{{ nl2br($data->meta_keyword) }}</p>
                        @else
                            <p class="text-danger font-weight-bold">NA</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        $('select[name="status"]').on('change', function() {
            var val = $(this).find(':selected').val();
            var route = $(this).data('route');
            statusUpdate(route, val);
        });
    </script>
@endsection