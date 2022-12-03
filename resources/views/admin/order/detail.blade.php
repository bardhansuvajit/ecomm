@extends('admin.layout.app')

@section('page-title', 'Order detail')

@section('section')
<section class="quick-boxes">
    <div class="row">
        <div class="col-md-4 border-end">
            <p>Order details</p>
            <table class="w-100 text-muted">
                <tr>
                    <th>Order no</th>
                    <td class="text-end">{{ $data->order_no }}</td>
                </tr>
                <tr>
                    <th>Time</th>
                    <td class="text-end">{{ h_date($data->created_at) }}</td>
                </tr>
                <tr>
                    <th>Total amount</th>
                    <td class="text-end">&#8377; {{ number_format($data->total_amount) }}</td>
                </tr>
                <tr>
                    <th>Discount</th>
                    <td class="text-end">&#8377; {{ number_format($data->discount) }}</td>
                </tr>
                <tr>
                    <th>Final amount</th>
                    <td class="text-end">&#8377; {{ number_format($data->final_amount) }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-4 border-end">
            <p>Customer details</p>
            <table class="w-100 text-muted">
                <tr>
                    <th>Type</th>
                    <td class="text-end">{{ ($data->user_id == 0) ? 'Guest checkout' : 'Existing user' }}</td>
                </tr>
                @if ($data->user_id != 0)
                <tr>
                    <th>User account</th>
                    <td class="text-end">{{ $data->userDetails->name }}</td>
                </tr>
                @endif
                <tr>
                    <th>Name</th>
                    <td class="text-end">{{ $data->name }}</td>
                </tr>
                <tr>
                    <th>Mobile number</th>
                    <td class="text-end">{{ $data->mobile_no }}</td>
                </tr>
                <tr>
                    <th>Email id</th>
                    <td class="text-end">{{ $data->email }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-4">
            <p>Address details</p>
            @if ($data->addressDetails)
            <table class="w-100 text-muted">
                <tr>
                    <th>Country</th>
                    <td class="text-end">{{ $data->addressDetails->country }}</td>
                </tr>
                <tr>
                    <th>Pincode</th>
                    <td class="text-end">{{ $data->addressDetails->pincode }}</td>
                </tr>
                <tr>
                    <th>City</th>
                    <td class="text-end">{{ $data->addressDetails->city }}</td>
                </tr>
                <tr>
                    <th>State</th>
                    <td class="text-end">{{ $data->addressDetails->state }}</td>
                </tr>
                <tr>
                    <th>Street</th>
                    <td class="text-end">{{ $data->addressDetails->street_address }}</td>
                </tr>
                <tr>
                    <th>Landmark</th>
                    <td class="text-end">{{ $data->addressDetails->landmark }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td class="text-end">{{ $data->addressDetails->type }}</td>
                </tr>
            </table>
            @endif
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-12">
            <table class="table table-sm w-100 text-muted">
                <thead>
                    <tr>
                        <th>SR</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Qty</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->orderProducts as $itemKey => $item)
                    <tr>
                        <td>{{$itemKey+1}}</td>
                        <td>
                            {{$item->productDetails->title}}
                        </td>
                        <td>&#8377; {{ number_format($item->amount) }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection