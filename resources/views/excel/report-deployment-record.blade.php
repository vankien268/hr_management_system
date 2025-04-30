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
            <td colspan="1" style="vertical-align: text-top;font-size: 10px">
                <span>{{ $data['cpnName'] }}</span>
                <br>
                <span>{{ $data['cpnAddress'] }}</span>
            </td>
            <td colspan="2" style="text-align: center; vertical-align: text-top;font-weight: bold; font-size: 14px">
                <span>{{ $data['reportName'] }}</span>
                <br>
                @php
                    $handover_date_from_date = isset($data['handover_date_from_date']) ? "Từ ngày ".$data['handover_date_from_date'] : '';
                    $handover_date_to_date = isset($data['handover_date_to_date']) ? "Đến ngày ".$data['handover_date_to_date'] : '';
                    if(!isset($data['handover_date_from_date'])&& !isset($data['handover_date_to_date'])){
                        $handover_date_from_date = '';
                        $handover_date_to_date = '';
                    }
                @endphp
                <span>{{ $handover_date_from_date }} {{ $handover_date_to_date }}</span>
            </td>
            <td colspan="1" style="vertical-align: text-top;font-size: 10px">
                <span>Ngày in: {{ $data['dateIn'] }}</span>
                <br>
                <span>Người in: {{ $data['userIn'] }}</span>
            </td>
        </tr>
        <tr style="background-color: #ccc; font-weight: bold">
            <th style="text-align: center">STT</th>
            <th>Mã lịch triển khai</th>
            <th style="width: 260px">Tiêu đề lịch triển khai</th>
            <th>
                <p>Thời gian thực hiện</p>
                <p>Từ ngày - Tới ngày</p>
            </th>
            <th style="width: 200px">
                Trạng thái
            </th>
            <th style="width: 200px">Ghi chú quan trọng</th>
        </tr>
        {{-- @dd($getExportDeploymentRecords) --}}
        @foreach ($getExportDeploymentRecords as $keyProject => $itemProject)
            <tr>
                <td colspan="6" style="vertical-align: text-top;text-align: left;font-weight: bold">
                    {{ $itemProject[0]['project']['code'] }} - {{ $itemProject[0]['project']['name'] }}
                </td>
            </tr>
            @foreach ($itemProject as $key => $item)
            <tr>
                <td style="vertical-align: text-top;text-align: center;">{{ (int) $key + 1 }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['code'] }}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['title'] }}</td>
                @php
                    $date_from_date = new DateTime($item['from_date']);
                    $from_date = $date_from_date->format('d/m/Y');
                    $date_to_date = new DateTime($item['to_date']);
                    $to_date = $date_to_date->format('d/m/Y');
                @endphp
                <td style="vertical-align: text-top; text-align: left">
                    {{$from_date}} - {{$to_date}}
                </td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['status']['name']}}</td>
                <td style="vertical-align: text-top; text-align: left">{{ $item['note'] }}</td>
            </tr>
            @endforeach
        @endforeach
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;font-weight: bold">Người lập biểu</td>
            <td colspan="3"></td>
            <td colspan="1" style="text-align: center;font-weight: bold">Trưởng bộ phận</td>
        </tr>
    </table>
</body>

</html>
