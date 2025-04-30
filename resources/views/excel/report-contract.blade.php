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
            </td>
            <td colspan="2" style="vertical-align: text-top;font-size: 10px">
                <span>{{ $data['cpnName'] }}</span>
                <br>
                <span>{{ $data['cpnAddress'] }}</span>
            </td>
            <td colspan="7" style="text-align: center; vertical-align: text-top;font-weight: bold; font-size: 14px">
                <span>{{ $data['reportName'] }}</span>
                <br>
                @php
                    $from_date_signing_date = isset($data['from_date_signing_date']) ? "Từ ngày ".$data['from_date_signing_date'] : '';
                    $to_date_signing_date = isset($data['to_date_signing_date']) ?  "Đến ngày ".$data['to_date_signing_date'] : '';
                    if(!isset($data['from_date_signing_date'])&& !isset($data['to_date_signing_date'])){
                        $from_date_signing_date = '';
                        $to_date_signing_date = '';
                    }
                @endphp
                <span>{{ $from_date_signing_date }} {{ $to_date_signing_date }}</span>
            </td>
            <td colspan="3" style="vertical-align: text-top;font-size: 10px">
                <span>Ngày in: {{ $data['dateIn'] }}</span>
                <br>
                <span>Người in: {{ $data['userIn'] }}</span>
            </td>
        </tr>
        <tr style="background-color: #ccc; font-weight: bold">
            <th style="text-align: center">STT</th>
            <th>Số hợp đồng</th>
            <th style="width: 100px">Ngày ký</th>
            <th>
                <span>
                    Đại diện ký
                </span>
                <br>
                <span>
                    (Phía khách hàng)
                </span>
            </th>
            <th>
                <span>
                    Đại diện ký
                </span>
                <br>
                <span>
                    (Phía công ty)
                </span>
            </th>
            <th>Loại hợp đồng</th>
            <th>Thời gian thực hiện</th>
            <th>Thời gian nghiệm thu</th>
            <th>Ngày hết hạn</th>
            <th>Trạng thái</th>
            <th><span>
                    TGBH
                </span>
                <br>
                <span>
                    (Tháng)
                </span>
            </th>
            <th><span>
                    SLTT
                </span>
                <br>
                <span>
                    (Lần)
                </span>
            </th>
            <th>Người phụ trách</th>
            <th><span>
                    GTHĐ
                </span>
                <br>
                <span>
                    (VNĐ)
                </span>
            </th>
        </tr>
        @foreach ($getExportContracts as $keyProject => $itemProject)
        <tr>
            <td colspan="14" style="vertical-align: text-top;text-align: left; height: 50px;font-weight: bold">
                <p>{{ $itemProject[0]['project']['code'] }} - {{ $itemProject[0]['project']['name'] }}</p>
                <p>{{ $itemProject[0]['customer']['code'] }} - {{ $itemProject[0]['customer']['name'] }}</p>
            </td>
        </tr>
            @foreach ($itemProject as $key => $item)
            <tr>
                <td style="vertical-align: text-top;text-align: center;">{{ (int) $key + 1 }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['code'] }}</td>
                @php
                    $date_signing_date = new DateTime($item['signing_date']);
                    $signing_date = $date_signing_date->format('d/m/Y');
                @endphp
                <td style="vertical-align: text-top; text-align: left">{{ $signing_date }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['customer_contractor'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['user_contractor']['name'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['contract_type']['name'] }}</td>
                @php
                    $date_start_date = new DateTime($item['start_date']);
                    $start_date = $date_start_date->format('d/m/Y');
                @endphp
                <td style="vertical-align: text-top; text-align: left">{{ $start_date }}</td>
                @php
                    $date_hand_over_date = new DateTime($item['hand_over_date']);
                    $hand_over_date = $date_hand_over_date->format('d/m/Y');
                @endphp
                <td style="vertical-align: text-top; text-align: left">{{ $hand_over_date }}</td>
                @php
                    $date_expiration_date= new DateTime($item['expiration_date']);
                    $expiration_date = $date_expiration_date->format('d/m/Y');
                @endphp
                <td style="vertical-align: text-top; text-align: left">{{ $expiration_date }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['status']['name'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['warranty_time'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['number_payment'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['user_charge']['name'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ number_format($item['contract_value'], 0, ",", ".") }}</td>
            </tr>
            @endforeach
        @endforeach
        <tr>
            <td>Tổng</td>
            <td>Hợp đồng</td>
            <td>{{ $totalContracts }}</td>
            <td colspan="11"></td>
        </tr>
        <tr>
            <td colspan="14"></td>
        </tr>
        <tr>
            <td colspan="14"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;font-weight: bold">Người lập biểu</td>
            <td colspan="9"></td>
            <td colspan="3" style="text-align: center;font-weight: bold">Trưởng bộ phận</td>
        </tr>
    </table>
</body>

</html>
