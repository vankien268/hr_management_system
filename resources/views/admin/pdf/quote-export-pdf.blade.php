<!DOCTYPE html>
<html>

<head>
    <title>Chi tiết lịch triển khai</title>
    <meta property="og:site_name" content="Phần mềm quản lý dự án Newway" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    {{-- @vite(['resources/css/sass/style.scss', 'resources/css/app.scss', 'resources/js/app.js']) --}}
</head>

<body style="width:97%; margin:auto">
    <div class="title"
        style="text-align: center; margin-top: 25px; text-transform: uppercase; font-size: 24px; font-weight: bold; width: 100%; display: flex; justify-content: center;">
        THÔNG TIN BÁO GIÁ</div>
    <div class="text">

        <br />
    </div>
    <table style="width: 100%;font-size: 12px; border:0px;">
        <tbody>
            <tr>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 15% !important">
                    Mã báo giá : </td>
                <td colspan="3" style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 5% !important;">
                    {{ $data['code'] }}</td>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 0% !important; ">
                    Dự án :</td>
                <td colspan="4" style="padding-top: 3px;padding-bottom: 3px;width: 0% !important">
                    {{ $data['project']['name'] }}</td>
            </tr>
            <tr>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 0% !important">
                    Tiêu đề :</td>
                <td colspan="3" style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 5% !important;">
                    {{ $data['title'] }}</td>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 0% !important">
                    khách hàng :</td>
                <td colspan="4" style="padding-top: 3px;padding-bottom: 3px;width: 0% !important">
                    {{ $data['customer']['name'] }}</td>
            </tr>
            <tr>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 0% !important">
                    Ngày báo giá :</td>
                @php
                    $date_quote_date = new DateTime($data['quote_date']);
                    $quote_date = $date_quote_date->format('d/m/Y');
                @endphp
                <td colspan="3" style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 5% !important;">
                    {{ $quote_date }}</td>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 0% !important">
                    Loại hợp đồng :</td>
                <td colspan="4" style="padding-top: 3px;padding-bottom: 3px;width: 0% !important">
                    {{ $data['contract_type']['name'] }} </td>
            </tr>
            <tr>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 18% !important">
                    Người nhận báo giá :</td>
                <td colspan="3" style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 5% !important;">
                    {{ $data['receiver'] }}
                </td>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 0% !important">
                    Trạng thái :
                </td>
                <td colspan="4" style="padding-top: 3px;padding-bottom: 3px;width: 0% !important">
                    {{ $data['status'] == 0 ? 'Chưa duyệt' : ($data['status'] == 1 ? 'Đã duyệt' : 'Đã hủy') }} </td>
            </tr>
            <tr>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 0% !important">
                    SĐT người nhận :</td>
                <td colspan="3" style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 5% !important;">
                    {{ $data['phone'] }}</td>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 0% !important">
                    Người duyệt :</td>
                <td colspan="4" style="padding-top: 3px;padding-bottom: 3px;width: 0% !important">
                    {{ $data['approve_by']['name'] }} </td>
            </tr>
            <tr>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 0% !important">
                    Email người nhận :</td>
                <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;width: 5% !important;">
                    {{ $data['email'] }}</td>
            </tr>
        </tbody>
    </table>
    <div style="border-top:1px solid lightgray;padding-bottom:8px; margin-top:12px;"></div>
    <div style="margin-bottom:5px;"><b>Danh mục sản phẩm, dịch vụ</b></div>
    @php

    @endphp
    <table style="width: 100%;border-spacing: 0px;font-size: 12px; ">
        <tbody>
            <tr>
                <th style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width:50px;text-align: center">STT
                </th>
                <th
                    style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: lef">
                    Mã sản phẩm</th>
                <th
                    style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 30% !important;text-align: lef">
                    Tên sản phẩm</th>
                <th
                    style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">
                    Đơn vị tính</th>
                <th
                    style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">
                    Đơn giá</th>
                <th
                    style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 12% !important;text-align: left">
                    Số lượng</th>
                <th
                    style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 30% !important;text-align: left">
                    Thành tiền</th>
            </tr>
            @if (count($data['details']) > 0)
                @php
                    $total = 0;
                @endphp
                @foreach ($data['details'] as $key => $rows)
                    @php
                        $total += $rows['quantity'] * $rows['product']['price'];
                    @endphp
                    <tr>
                        <td
                            style="padding-top: 3px;padding-bottom: 3px;border: 1px solid rgba(0, 0, 0, 0.199);text-align: center">
                            {{ $key + 1 }}</td>
                        <td
                            style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">
                            {{ $rows['product']['code'] }}</td>
                        <td
                            style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">
                            {{ $rows['product']['name'] }}</td>
                        <td
                            style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">
                            {{ $rows['product']['unit']['name'] }}</td>
                        <td
                            style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: right">
                            {{ str_replace(',', '.', number_format($rows['product']['price'])) }}</td>
                        <td
                            style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 10% !important;text-align: center">
                            {{ $rows['quantity'] }}</td>
                        <td
                            style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 30% !important;text-align: right">
                            {{ str_replace(',', '.', number_format($rows['quantity'] * $rows['product']['price'])) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="3"
                        style="padding-top: 10px;padding-bottom: 3px;padding-left: 5px;width: 30% !important;text-align: right">
                        <b>Tổng cộng: {{ str_replace(',', '.', number_format($total)) }} <sup>đ</sup></b>
                    </td>
                </tr>
            @else
                <tr>
                    <td style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;"
                        class="text-center" colspan="7">Không có dữ liệu hiển thị
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <br />
    <div style="border-top:1px solid lightgray;padding-bottom:8px;"></div>
    <div style="margin-bottom:5px;"><b>Lưu ý</b></div>
    <div>
        <span>{{ $data['note'] }}</span>
    </div>
</body>

</html>
