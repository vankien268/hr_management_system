<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="background-color: #ccc">
    <table>
        <tr>
            <td colspan="2" style="vertical-align: middle; text-align: center">
                {{-- <img src="{{ public_path('/assets/media/logos/newway.png') }}"  width="70"> --}}
                {{-- {{÷}} --}}
            </td>
            <td colspan="1" style="vertical-align: text-top;font-size: 10px">
                <span>{{ $data['cpnName'] }}</span>
                <br>
                <span>{{ $data['cpnAddress'] }}</span>
            </td>
            <td colspan="4" style="text-align: center; vertical-align: text-top;font-weight: bold; font-size: 14px">
                <span>{{ $data['reportName'] }}</span>
                <br>
                @php
                    $from_date = isset($data['from_date']) ? "Từ ngày ".$data['from_date'] : '';
                    $to_date = isset($data['to_date']) ? "Đến ngày ".$data['to_date'] : '';
                    if(!isset($data['from_date'])&& !isset($data['to_date'])){
                        $from_date = '';
                        $to_date = '';
                    }
                @endphp
                <span>{{ $from_date }} {{ $to_date }}</span>
            </td>
            <td colspan="1" style="vertical-align: text-top;font-size: 10px">
                <span>Ngày in: {{ $data['dateIn'] }}</span>
                <br>
                <span>Người in: {{ $data['userIn'] }}</span>
            </td>
        </tr>
        <tr style="background-color: #ccc; font-weight: bold">
            <th style="text-align: center">STT</th>
            <th style="width: 120px">Ngày khai báo</th>
            <th style="width: 250px">Mã khách hàng</th>
            <th>Mã số thuế</th>
            <th>Tên khách hàng</th>
            <th>Người đại diện</th>
            <th>Trạng thái</th>
            <th style="width: 200px">Ghi chú</th>
        </tr>
        @foreach ($getExportCustomers as $key => $item)
            <tr>
                <td style="vertical-align: text-top;text-align: center">{{ (int) $key + 1 }}</td>
                @php
                    $date = new DateTime($item['created_at']);
                    $formatted_date = $date->format('d/m/Y');
                @endphp
                <td style="vertical-align: text-top; text-align: left">{{ $formatted_date }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['code'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['tax_code'] }}</td>
                <td style="vertical-align: text-top; text-align: left">
                    <p style="vertical-align: text-top; text-align: left">
                        {{ $item['customer_type'] === 1 ? 'Khách VIP' : 'Khách thường' }}
                    </p>
                    <p style="vertical-align: text-top; text-align: left">
                        {{ $item['name'] }}
                    </p>
                    <p style="vertical-align: text-top; text-align: left">
                        Địa chỉ: {{ $item['address'] }}
                    </p>
                </td>
                <td style="vertical-align: text-top; text-align: left">
                    <p style="vertical-align: text-top; text-align: left">
                        {{ $item['representative_name'] }}
                    </p>
                    <p style="vertical-align: text-top; text-align: left">
                        SĐT: {{ $item['representative_phone'] }}
                    </p>
                    <p style="vertical-align: text-top; text-align: left">
                        Email: {{ $item['representative_email'] }}
                    </p>
                </td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['status']['name'] }}</td>
                <td style="vertical-align: text-top; text-align: left;">{{ $item['note'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Tổng</td>
            <td>Khách hàng</td>
            <td>{{ $totalCustomers }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td>Trong đó</td>
            <td>Khách hàng Vip</td>
            <td>{{ $totalCustomerVip }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td></td>
            <td>Khách hàng thường</td>
            <td>{{ $totalCustomerNormal }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="8" ></td>
        </tr>
        <tr>
            <td colspan="8" ></td>
        </tr>
        <tr>
            <td style="text-align: center;font-weight: bold" colspan="2">Người lập biểu</td>
            <td colspan="5"></td>
            <td style="text-align: center;font-weight: bold" colspan="1">Trưởng bộ phận</td>
        </tr>
    </table>


</body>

</html>
