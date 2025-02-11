@extends('client.layouts.master')

@section('title')
    My Account
@endsection

@section('content')
    <!-- Begin Kenne's Breadcrumb Area -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <h2>Shop Related</h2>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('my.account') . '#account-orders' }}">Order</a></li>
                    <li class="active">Order detail</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Kenne's Breadcrumb Area End Here -->
    <!-- Begin Kenne's Page Content Area -->
    
    <main class="page-content">
        
        <div class="account-page-area">
            
            <div class="container">
                @session('success')
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <div>
                      {{session("success")}}
                    </div>
                  </div>
                @endsession
                <div class="row">
                    <div class="col-lg-3">
                        <div class="tab-content myaccount-tab-content" id="account-page-tab-content">
                            <div class="card-header mb-3">
                                <h4>Customer Details</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0 vstack gap-3">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt=""
                                                    class="avatar-sm rounded" width="50px">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-1">{{ $orderItems->user_name }}</h6>
                                                <p class="text-muted mb-0">Customer</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>{{ $orderItems->user_email }}</li>
                                    <li>{{ $orderItems->user_phone }}</li>
                                    <li>{{ $orderItems->user_address }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content myaccount-tab-content mt-3" id="account-page-tab-content">
                            <div class="card-header mb-3">
                                <h4>Status</h4>
                            </div>
                            <div class="card-body">
                                <p>Status Order: {{ $orderItems->status_order }}</p>
                                <p>Status Payment: {{ $orderItems->status_payment }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="tab-content myaccount-tab-content" id="account-page-tab-content">
                            <div class="tab-pane fade show active" id="account-orders" role="tabpanel"
                                aria-labelledby="account-orders-tab">
                                <div class="myaccount-orders">
                                    <h4 class="small-title">ORDERS #{{ $orderItems->id }}</h4>
                                    <div class="table-responsive">
                                        <table class="table ">
                                            <tr>
                                                <th>Product Details</th>
                                                <th>Price regular</th>
                                                <th>Price sale</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                @if ($orderItems->status_order == 'delivered')
                                                    <th></th>
                                                @endif
                                            </tr>
                                            <tbody>
                                                @foreach ($orderItems->order_items as $item)
                                                    <tr>
                                                        <td class="d-flex text-start align-items-center gap-3">
                                                            <div style="width: 100px">
                                                                <img src="{{ Storage::url($item->product_img_thumbnail) }}"
                                                                    alt="" width="100%">
                                                            </div>
                                                            <div class="">
                                                                <h5>{{ $item->product_name }}</h5>
                                                                <p class="mb-1">Color:
                                                                    <span>{{ $item->variant_color_name }}</span>
                                                                </p>
                                                                <p class="mb-1">Size:
                                                                    <span>{{ $item->variant_size_name }}</span>
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td>{{ $item->product_price_regular }}<sup>đ</sup></td>
                                                        <td>{{ $item->product_price_sale }}<sup>đ</sup></td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ $item->product_price_sale * $item->quantity }}<sup>đ</sup>
                                                        </td>
                                                        @if ($orderItems->status_order == 'delivered' && $orderItems->status_payment == 'paid' && $item->is_rating == false)
                                                        <td>
                                                                <button type="button" class="kenne-btn kenne-btn_sm"
                                                                    style="width: 100px;" data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal{{ $item->id }}">Viết
                                                                    đánh
                                                                    giá</button>
                                                            </td>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="exampleModal{{ $item->id }}"
                                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                                Đánh giá
                                                                                sản phẩm này</h5>
                                                                        </div>
                                                                        <form action="{{route('rating')}}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="product_variant_id" value="{{$item->product_variant_id}}">
                                                                            <input type="hidden" name="order_item_id" value="{{$item->id}}">
                                                                            <div class="modal-body">
                                                                                <div class="mb-3">
                                                                                    <label for=""
                                                                                        class="form-label">Mức độ hài
                                                                                        lòng</label>
                                                                                    <select name="rating" id=""
                                                                                        class="form-select">
                                                                                        <option value="5">Rất Tốt
                                                                                        </option>
                                                                                        <option value="4">Tốt</option>
                                                                                        <option value="3">Tạm</option>
                                                                                        <option value="2">Kém</option>
                                                                                        <option value="1">Rất Tệ
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="rating"
                                                                                        class="form-label">Viết đánh
                                                                                        giá</label>
                                                                                    <textarea class="form-control" id="rating" rows="3" name="content"
                                                                                        placeholder="Bạn nghĩ như thế nào về kiểu dáng, độ vừa vặn, kích thước, màu sắc"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    style="background: gray; padding:5px 10px"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Đóng</button>
                                                                                <button type="submit"
                                                                                    style="background: blue; padding:5px 10px"
                                                                                    class="btn btn-primary">Gửi</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </tr>
                                                @endforeach

                                                @php
                                                    $totalTemp = 0;
                                                    foreach ($orderItems->order_items as $item) {
                                                        $totalTemp += $item->product_price_sale * $item->quantity;
                                                    }
                                                @endphp

                                                <tr class="border-top border-top-dashed">
                                                    {{-- <td colspan="4"></td> --}}
                                                    <td colspan="5" class="fw-medium p-0">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-start">Sub Total :</td>
                                                                    <td class="text-end">{{ $totalTemp }}<sup>đ</sup>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-start">Discount <span
                                                                            class="text-muted">(KENNE)</span> :</td>
                                                                    <td class="text-end">
                                                                        -{{ $orderItems->discount }}<sup>đ</sup></td>
                                                                </tr>
                                                                <tr class="border-top border-top-dashed">
                                                                    <th scope="row" class="text-start">Total :</th>
                                                                    <th class="text-end">
                                                                        {{ $orderItems->total_price }}<sup>đ</sup></th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kenne's Account Page Area End Here -->
    </main>
@endsection
