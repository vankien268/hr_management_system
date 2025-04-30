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
                {{-- <img style="width:50px" src="{{ public_path('/assets/media/logos/newway.png') }}"> --}}
                {{-- {{÷}} --}}
            </td>
            <td colspan="2" style="vertical-align: text-top;font-size: 10px">
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
            <td colspan="2" style="vertical-align: text-top;font-size: 10px">
                <span>Ngày in: {{ $data['dateIn'] }}</span>
                <br>
                <span>Người in: {{ $data['userIn'] }}</span>
            </td>
        </tr>
        <tr style="background-color: #ccc; font-weight: bold">
            <th style="text-align: center">STT</th>
            <th style="width: 80px">Ngày tạo</th>
            <th style="width: 130px">Mã dự án</th>
            <th style="width: 130px">Tên dự án</th>
            <th>Khu vực</th>
            <th>Phân loại dự án</th>
            <th>Mô tả sơ bộ</th>
            <th>Đại diện khách hàng</th>
            <th>Đại diện công ty</th>
            <th>Trạng thái</th>
        </tr>
        @foreach ($getExportProjects as $keyCustomer => $itemCustomer)
            <tr>
                <td colspan="10" style="vertical-align: text-top; text-align: left;font-weight: bold">
                    {{ $itemCustomer[0]['customer']['code'] }} - {{ $itemCustomer[0]['customer']['name'] }}
                </td>
            </tr>
            @foreach ($itemCustomer as $key => $item)
            <tr>
                <td style="vertical-align: text-top;text-align: center;">{{ (int) $key + 1 }}</td>
                @php
                    $date_created_at = new DateTime($item['created_at']);
                    $created_at = $date_created_at->format('d/m/Y');
                @endphp
                <td style="vertical-align: text-top; text-align: left">{{ $created_at }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['code'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['name'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['city']['name'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['project_type']['name'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['description'] }}</td>
                @foreach ($item['contacts'] as $itemData)
                    <td style="vertical-align: text-top; text-align: left">
                        {{ $itemData['name'] }}
                    </td>
                @endforeach
                @foreach ($item['users'] as $itemData)
                    <td style="vertical-align: text-top; text-align: left">
                        {{ $itemData['name'] }}
                    </td>
                @endforeach
                <td style="vertical-align: text-top; text-align: left">{{ $item['status_project']['name'] }}</td>
            </tr>
            @endforeach

        @endforeach
        <tr>
            <td>Tổng</td>
            <td>Dự án</td>
            <td>{{ $totalProjects }}</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="10" ></td>
        </tr>
        <tr>
            <td colspan="10" ></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;font-weight: bold">Người lập biểu</td>
            <td colspan="6"></td>
            <td colspan="2" style="text-align: center;font-weight: bold">Trưởng bộ phận</td>
        </tr>
    </table>
</body>

</html>
