@extends('front.layout.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <section id="filter" class="pb-0">
            <form action="" method="get">
                <div id="title">
                    <h5>Filter</h5>
                </div>

                <div id="subtitle">
                    <p class="small text-muted">Showing 25 out of 253 products</p>
                </div>

                <div id="set-1" class="filter-set">
                    <p class="text-dark fw-semibold mb-1 set-heading">Sort by</p>

                    <input type="radio" class="btn-check" name="sort-by" id="sort-by-popularity" autocomplete="off" value="popularity-desc" {{ ( (request()->input('sort-by') == "popularity-desc") || empty(request()->input('sort-by')) ) ? 'checked' : '' }}>
                    <label class="btn btn-xsm btn-outline-dark mb-2" for="sort-by-popularity">Popularity</label>

                    <input type="radio" class="btn-check" name="sort-by" id="sort-by-price-asc" autocomplete="off" value="price-asc" {{ (request()->input('sort-by') == "price-asc") ? 'checked' : '' }}>
                    <label class="btn btn-xsm btn-outline-dark mb-2" for="sort-by-price-asc">Price Low to High</label>

                    <input type="radio" class="btn-check" name="sort-by" id="sort-by-price-desc" autocomplete="off" value="price-desc" {{ (request()->input('sort-by') == "price-desc") ? 'checked' : '' }}>
                    <label class="btn btn-xsm btn-outline-dark mb-2" for="sort-by-price-desc">Price High to Low</label>
                </div>

                <div id="set-2" class="filter-set">
                    <p class="text-dark fw-semibold mb-1 set-heading">Collection</p>
                    {{-- <p class="text-dark fw-semibold mb-1 set-heading">{{ dd(request()->input('collection')) }}</p> --}}

                    <ul class="list-group">
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="collection-1" name="collection[]" value="first" {{ (collect(request()->input('collection'))->contains('first')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="collection-1">First checkbox</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="collection-2" name="collection[]" value="second" {{ (collect(request()->input('collection'))->contains('second')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="collection-2">Second checkbox</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="collection-3" name="collection[]" value="third" {{ (collect(request()->input('collection'))->contains('third')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="collection-3">Third checkbox</label>
                        </li>
                    </ul>
                </div>

                <div id="set-3" class="filter-set">
                    <p class="text-dark fw-semibold mb-1 set-heading">Category</p>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="category-1" name="category[]" value="first" {{ (collect(request()->input('category'))->contains('first')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category-1">First checkbox</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="category-2" name="category[]" value="second" {{ (collect(request()->input('category'))->contains('second')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category-2">Second checkbox</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" id="category-3" name="category[]" value="third" {{ (collect(request()->input('category'))->contains('third')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category-3">Third checkbox</label>
                        </li>
                    </ul>
                </div>

                <div style="height: 500px"></div>

                <div id="form-submit-buttons">
                    <button type="submit" class="btn btn-sm btn-dark">Apply</button>
                    <a href="{{ url()->current() }}" class="btn btn-sm btn-light">Cancel</a>
                </div>
            </form>
        </section>
    </div>
    <div class="col-md-9">
        <section id="page-detail">
            <div id="breadcrumb">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">category</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lorem ipsum dolor...</li>
                    </ol>
                </nav>
            </div>

            <div id="title">
                <h5>Category titile</h5>
            </div>

            <div id="short-description">
                <p class="small text-muted review1 height-3 mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi veniam inventore enim alias earum mollitia sint ipsam ad maiores consequuntur odio, velit, distinctio itaque expedita molestias laborum accusamus nostrum. Suscipit officiis modi voluptatem iste at autem dignissimos dolores, aliquam sit deleniti impedit quaerat quae nam aliquid! Dolorum recusandae quasi nemo at voluptatem sed provident porro assumenda. Commodi facilis, ab error quaerat optio fugiat odio, atque minima aperiam, rem ex eligendi quidem eaque ratione perferendis libero nobis sint ipsum! Dolorum aliquid quo explicabo dolor maxime? Ratione sed fuga, recusandae ipsa itaque dignissimos, dolorum saepe omnis voluptates autem odit nemo vel provident?
                </p>
                <a href="javascript: void(0)" onclick="seeMoreText('review1', 'more-text1')" class="more-text1">See more</a>
            </div>

            <div id="products">
                <div class="row my-4">
                    <div class="col-md-3">
                        <div class="single-product">
                            <div class="card">
                                <a href="#">
                                    <div class="full-container">
                                        <div class="image-container">
                                            <div class="image-holder">
                                                <img src="https://torzo.in/uploads/product/5tehgfu780hgfhv/8297nr8728roshjskd (1).jpeg" alt="image">
                                            </div>
                                        </div>
                                        <div class="description-container">
                                            <div class="product-title">
                                                <h5>Loud &amp; Big Vamavarti (12 cms) Blowing Shankh (White)</h5>
                                            </div>
                                            <div class="rating">
                                                <div class="rating-count">
                                                    <h5 class="digit">3.9</h5> 
                                                    <div class="icon">
                                                        <i class="material-icons md-light">star</i>
                                                    </div>
                                                </div>
                                                <div class="review-count">(7,890)</div>
                                            </div>
                                            <div class="pricing">
                                                <h4 class="selling-price">
                                                    <span class="currency-icon">₹</span>
                                                    <span class="amount">599</span>
                                                </h4>
                                                <h6 class="mrp">
                                                    <span class="currency-icon">₹</span>
                                                    <span class="amount">2,000</span>
                                                </h6>
                                            </div>
                                            <div class="discount">
                                                <span>70%</span>
                                                <span>off</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="single-product">
                            <div class="card">
                                <a href="#">
                                    <div class="full-container">
                                        <div class="image-container">
                                            <div class="image-holder">
                                                <img src="https://torzo.in/uploads/product/5tehgfu780hgfhv/8297nr8728roshjskd (1).jpeg" alt="image">
                                            </div>
                                        </div>
                                        <div class="description-container">
                                            <div class="product-title">
                                                <h5>Loud &amp; Big Vamavarti (12 cms) Blowing Shankh (White)</h5>
                                            </div>
                                            {{-- <div class="rating">
                                                <div class="rating-count">
                                                    <h5 class="digit">3</h5> 
                                                    <div class="icon">
                                                        <i class="material-icons md-light">star</i>
                                                    </div>
                                                </div>
                                                <div class="review-count">(7,890)</div>
                                            </div> --}}
                                            <div class="pricing">
                                                <h4 class="selling-price">
                                                    <span class="currency-icon">₹</span>
                                                    <span class="amount">599</span>
                                                </h4>
                                                <h6 class="mrp">
                                                    <span class="currency-icon">₹</span>
                                                    <span class="amount">2,000</span>
                                                </h6>
                                            </div>
                                            <div class="discount">
                                                <span>70%</span>
                                                <span>off</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="single-product">
                            <div class="card">
                                <a href="#">
                                    <div class="full-container">
                                        <div class="image-container">
                                            <div class="image-holder">
                                                <img src="https://torzo.in/uploads/product/5tehgfu780hgfhv/8297nr8728roshjskd (1).jpeg" alt="image">
                                            </div>
                                        </div>
                                        <div class="description-container">
                                            <div class="product-title">
                                                <h5>Loud &amp; Big Vamavarti (12 cms) Blowing Shankh (White)</h5>
                                            </div>
                                            <div class="rating">
                                                <div class="rating-count">
                                                    <h5 class="digit">2.0</h5> 
                                                    <div class="icon">
                                                        <i class="material-icons md-light">star</i>
                                                    </div>
                                                </div>
                                                <div class="review-count">(7,890)</div>
                                            </div>
                                            <div class="pricing">
                                                <h4 class="selling-price">
                                                    <span class="currency-icon">₹</span>
                                                    <span class="amount">599</span>
                                                </h4>
                                                <h6 class="mrp">
                                                    <span class="currency-icon">₹</span>
                                                    <span class="amount">2,000</span>
                                                </h6>
                                            </div>
                                            <div class="discount">
                                                <span>70%</span>
                                                <span>off</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="single-product">
                            <div class="card">
                                <a href="#">
                                    <div class="full-container">
                                        <div class="image-container">
                                            <div class="image-holder">
                                                <img src="https://torzo.in/uploads/product/5tehgfu780hgfhv/8297nr8728roshjskd (1).jpeg" alt="image">
                                            </div>
                                        </div>
                                        <div class="description-container">
                                            <div class="product-title">
                                                <h5>Loud &amp; Big Vamavarti (12 cms) Blowing Shankh (White)</h5>
                                            </div>
                                            <div class="rating">
                                                <div class="rating-count">
                                                    <h5 class="digit">3.6</h5> 
                                                    <div class="icon">
                                                        <i class="material-icons md-light">star</i>
                                                    </div>
                                                </div>
                                                <div class="review-count">(7,890)</div>
                                            </div>
                                            <div class="pricing">
                                                <h4 class="selling-price">
                                                    <span class="currency-icon">₹</span>
                                                    <span class="amount">599</span>
                                                </h4>
                                                <h6 class="mrp">
                                                    <span class="currency-icon">₹</span>
                                                    <span class="amount">2,000</span>
                                                </h6>
                                            </div>
                                            <div class="discount">
                                                <span>70%</span>
                                                <span>off</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="pagination">
                
            </div>
        </section>
    </div>
</div>
@endsection