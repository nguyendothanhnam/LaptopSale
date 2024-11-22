@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin khách hàng
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session('message', null);
                    }
                    ?>
                    <thead>
                        <tr>
                            <th>Tên khách hàng</th>
                            <th>Email</th>
                            <td>Số điện thoại</td>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ $order_by_id->customer_name }}</td>
                            <td>{{ $order_by_id->customer_email }}</td>
                            <td>{{ $order_by_id->customer_phone }}</td>
                            <th style="width:30px;"></th>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br>

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin vận chuyển
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session('message', null);
                    }
                    ?>
                    <thead>
                        <tr>
                            <th>Tên người vận chuyển</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <td>Số điện thoại</td>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ $order_by_id->shipping_name }}</td>
                            <td>{{ $order_by_id->shipping_email }}</td>
                            <td>{{ $order_by_id->shipping_address }}</td>
                            <td>{{ $order_by_id->shipping_phone }}</td>
                            <th style="width:30px;"></th>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br>

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê chi tiết đơn hàng
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session('message', null);
                    }
                    ?>
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng tiền</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order_by_id->product_name }}</td>
                            <td>{{ $order_by_id->product_sales_quantity }}</td>
                            <td>{{ $order_by_id->product_price }}</td>
                            <td>{{ $order_by_id->product_price*$order_by_id->product_sales_quantity }}</td>
                            <th style="width:30px;"></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
