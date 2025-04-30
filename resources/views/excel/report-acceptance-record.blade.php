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
            <td colspan="1" style="vertical-align: middle; text-align: center">
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
                    $acceptance_date_from_date = isset($data['acceptance_date_from_date']) ? 'Từ ngày ' . $data['acceptance_date_from_date'] : '';
                    $acceptance_date_to_date = isset($data['acceptance_date_to_date']) ? 'Đến ngày ' . $data['acceptance_date_to_date'] : '';
                    if (!isset($data['acceptance_date_from_date']) && !isset($data['acceptance_date_to_date'])) {
                        $acceptance_date_from_date = '';
                        $acceptance_date_to_date = '';
                    }
                @endphp
                <span>{{ $acceptance_date_from_date }} {{ $acceptance_date_to_date }}</span>
            </td>
            <td colspan="3" style="vertical-align: text-top;font-size: 10px">
                <span>Ngày in: {{ $data['dateIn'] }}</span>
                <br>
                <span>Người in: {{ $data['userIn'] }}</span>
            </td>
        </tr>
        <tr style="background-color: #ccc; font-weight: bold">
            <th style="text-align: center">STT</th>
            <th style="width: 160px">Mã biên bản nghiệm thu</th>
            <th style="width: 190px">Tiêu đề biên bản nghiệm thu</th>
            <th>
                Ngày gửi
            </th>
            <th>
                Người gửi
            </th>
            <th>Người nhận</th>
            <th>Ngày nghiệm thu</th>
            <th>
                <p>TGBH</p>
                <p>(Tháng)</p>
            </th>
            <th>Trạng thái</th>
            <th style="width: 150px">Ghi chú</th>
        </tr>
        @foreach ($getExportAcceptanceRecords as $keyProject => $itemProject)
            <tr>
                <td colspan="10" style="vertical-align: text-top;text-align: left;font-weight: bold">
                    {{ $itemProject[0]['project']['code'] }} - {{ $itemProject[0]['project']['name'] }}
                </td>
            </tr>
            @foreach ($itemProject as $key => $item)
                <tr >
                    <td tyle="vertical-align: text-top;text-align: center;">{{ (int) $key + 1 }}</td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['code'] }}</td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['title'] }}</td>
                    @php
                        $date_sent_date = new DateTime($item['sent_date']);
                        $sent_date = $date_sent_date->format('d/m/Y');
                    @endphp
                    <td style="vertical-align: text-top; text-align: left">{{ $sent_date }}</td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['sender'] }}</td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['receiver'] }}</td>
                    @php
                        $date_acceptance_date = new DateTime($item['acceptance_date']);
                        $acceptance_date = $date_acceptance_date->format('d/m/Y');
                    @endphp
                    <td style="vertical-align: text-top; text-align: left">{{ $acceptance_date }}</td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['warranty_period'] }}</td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['status']['name'] }}</td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['note'] }}</td>
                </tr>
            @endforeach
        @endforeach
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;font-weight: bold">Người lập biểu</td>
            <td colspan="5"></td>
            <td colspan="3" style="text-align: center;font-weight: bold">Trưởng bộ phận</td>
        </tr>
    </table>
</body>

</html>
