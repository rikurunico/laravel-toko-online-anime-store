@extends('layouts.frontend.app')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{ route('transaction.index') }}"> Transaction</a>
                        <span>{{ $data['order']->invoice_number }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice" style="border-top: 2px solid #6777ef;">
                        <div class="invoice-print">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="invoice-title">
                                        <h2>Invoice</h2>
                                        <div class="invoice-number">Order {{ $data['order']->invoice_number }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address>
                                                <strong>Billed To:</strong><br>
                                                Ujang Maman<br>
                                                1234 Main<br>
                                                Apt. 4B<br>
                                                Bogor Barat, Indonesia
                                            </address>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <address>
                                                <strong>Shipped To:</strong><br>
                                                {{ $data['order']->recipient_name }}<br>
                                                {{ $data['order']->address_detail }}<br>
                                                {{ $data['order']->destination }}
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address>
                                                <strong>Order Status:</strong>
                                                <div class="mt-2">
                                                    {!! $data['order']->status_name !!}
                                                </div>
                                            </address>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <address>
                                                <strong>Order Date:</strong><br>
                                                {{ $data['order']->created_at }}<br><br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="section-title">Order Summary</div>
                                    <p class="section-lead">All items here cannot be deleted.</p>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-md">
                                            <tbody>
                                                <tr>
                                                    <th data-width="40" style="width: 40px;">#</th>
                                                    <th>Item</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-right">Totals</th>
                                                </tr>
                                                @foreach ($data['order']->orderDetail()->get() as $detail)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><a
                                                                href="{{ route('product.show', ['categoriSlug' => $detail->Product->category->slug, 'productSlug' => $detail->Product->slug]) }}">{{ $detail->product->name }}</a>
                                                        </td>
                                                        <td class="text-center">{{ rupiah($detail->product->price) }}
                                                        </td>
                                                        <td class="text-center">{{ $detail->qty }}</td>
                                                        <td class="text-right">
                                                            {{ rupiah($detail->total_price_per_product) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-8">
                                            <address>
                                                <strong>Shipment Method:</strong>
                                                <div class="mt-2">
                                                    <p class="section-lead text-uppercase">{{ $data['order']->courier }}
                                                        {{ $data['order']->shipping_method }}</p>
                                                </div>
                                            </address>
                                            @if ($data['order']->receipt_number != null)
                                                <address>
                                                    <strong>Receipt Number:</strong>
                                                    <div class="mt-2">
                                                        <p class="section-lead text-uppercase">
                                                            {{ $data['order']->receipt_number }}</p>
                                                    </div>
                                                </address>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 text-right">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Subtotal</div>
                                                <div class="invoice-detail-value">{{ rupiah($data['order']->subtotal) }}
                                                </div>
                                            </div>
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Shipping</div>
                                                <div class="invoice-detail-value">
                                                    {{ rupiah($data['order']->shipping_cost) }}</div>
                                            </div>
                                            <hr class="mt-2 mb-2">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Total</div>
                                                <div class="invoice-detail-value invoice-detail-value-lg">
                                                    {{ rupiah($data['order']->total_pay) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-md-right">
                            <div class="float-lg-left mb-lg-0 mb-3">
                                @if ($data['order']->status == 0)
                                    <button class="btn btn-primary btn-icon icon-left" id="pay-button"><i
                                            class="fa fa-credit-card"></i>
                                        Process Payment</button>
                                    <a href="{{ route('transaction.canceled', $data['order']->invoice_number) }}" class="btn btn-danger btn-icon icon-left"><i class="fa fa-times"></i>
                                        Cancel Order</a>
                                @elseif ($data['order']->status == 2)
                                    <a href="{{ route('transaction.received', $data['order']->invoice_number) }}"
                                        class="btn btn-primary text-white btn-icon icon-left"><i
                                            class="fa fa-credit-card"></i>
                                        Order Received</a>
                                @endif
                            </div>
                            <button class="btn btn-warning btn-icon icon-left"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">Order Track</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="activities">
                                        @foreach ($data['order']->OrderTrack()->get() as $orderTrack)
                                            <div class="activity">
                                                <div class="activity-icon bg-primary text-white shadow-primary">
                                                    <i class="{{ $orderTrack->icon }}"></i>
                                                </div>
                                                <div class="activity-detail bg-primary text-white">
                                                    <div class="mb-2">
                                                        <span class="text-job text-white">{{ $orderTrack->created_at->diffForHumans() }}</span>
                                                        <span class="bullet"></span>
                                                    </div>
                                                    <p>{{ __($orderTrack->description) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
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
@push('js')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $data['order']->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                }
            });
        });
    </script>
@endpush
