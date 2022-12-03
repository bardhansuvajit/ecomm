@extends('admin.layout.app')

@section('page-title', 'Order list')

@section('section')
<section class="quick-boxes">
    <div class="table-responsive">
        <table class="table table-sm table-hover table-striped">
            <thead>
                <tr>
                    <th>SR</th>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Order no</th>
                    <th>Address</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $orderKey => $order)
                <tr>
                    <td>{{ $orderKey + 1 }}</td>
                    <td>
                        {!! ($order->user_id == 0) ? '<p class="mb-0 text-danger">Guest Checkout</p>' : '' !!}
                        {{ $order->name }}
                    </td>
                    <td>
                        <p class="mb-1">{{ $order->mobile_no }}</p>
                        <p class="mb-0">{{ $order->email }}</p>
                    </td>
                    <td>#{{ $order->order_no }}</td>
                    <td>{{ $order->email }}</td>
                    <td>&#8377; {{ number_format($order->final_amount) }}</td>
                    <td>COD</td>
                    <td>{{ $order->created_at ? h_date($order->created_at) : '' }}</td>
                    <td>
                        <a href="{{ route('admin.order.detail', $order->id) }}" class="btn btn-sm btn-primary">Details</a>
                        {{-- <a href="" class="badge bg-dark">Status</a>
                        <a href="" class="badge bg-dark">Edit</a>
                        <a href="" class="badge bg-dark">Delete</a> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{$data->appends($_GET)->links()}}
</section>
@endsection