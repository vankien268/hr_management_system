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
            <td colspan="4" style="text-align: center; vertical-align: text-top;font-weight: bold; font-size: 14px">
                <span>{{ $data['reportName'] }}</span>
                <br>
                @php
                    $from_date = isset($data['from_date']) ? 'Từ ngày ' . $data['from_date'] : '';
                    $to_date = isset($data['to_date']) ? 'Đến ngày ' . $data['to_date'] : '';
                    if (!isset($data['from_date']) && !isset($data['to_date'])) {
                        $from_date = '';
                        $to_date = '';
                    }
                @endphp
                <span>{{ $from_date }} {{ $to_date }}</span>
            </td>
            <td colspan="3" style="vertical-align: text-top;font-size: 10px">
                <span>Ngày in: {{ $data['dateIn'] }}</span>
                <br>
                <span>Người in: {{ $data['userIn'] }}</span>
            </td>
        </tr>
        <tr style="background-color: #ccc; font-weight: bold">
            <th style="text-align: center">STT</th>
            <th style="width: 100px">Ngày lập</th>
            <th>Mã công văn, thông báo</th>
            <th>Tên công văn thông báo</th>
            <th>Loại</th>
            <th>Số công văn thông báo</th>
            <th>Ngày hiệu lực</th>
            <th>Trạng thái</th>
            <th style="width: 100px">Nội dung</th>
            <th style="width: 100px">Ghi chú</th>

        </tr>
            <tr>

        @foreach ($getExportDispatches as $keyProject => $itemProject)
            <tr>
                <td colspan="14" style="vertical-align: text-top;text-align: left; height: 50px;font-weight: bold">
                    <p>{{ $itemProject[0]['project']['code'] }} - {{ $itemProject[0]['project']['name'] }}</p>
                    <p>{{ $itemProject[0]['customer']['code'] }} - {{ $itemProject[0]['customer']['name'] }}</p>
                </td>
            </tr>
            @foreach ($itemProject as $key => $item)
                <tr>
                    <td style="vertical-align: text-top;text-align: center;">{{ (int) $key + 1 }}</td>
                    @php
                        if ($item['date'] == null) {
                            $date = '';
                        }
                        else {
                            $date_date = new DateTime($item['date']);
                            $date = $date_date->format('d/m/Y');
                        }

                    @endphp
                    <td style="vertical-align: text-top; text-align: left">
                        {{ $date}}
                    </td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['code'] }}</td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['name'] }}</td>
                    <td style="vertical-align: text-top; text-align: left">
                        <p style="vertical-align: text-top; text-align: left">
                            {{ $item['type'] === 1 ? 'Gửi đi' : 'Tiếp nhận' }}
                        </p>
                        @if ($item['type'] === 1)
                            <p style="vertical-align: text-top; text-align: left">
                                Người gửi: {{ $item['sender'] === null ? '' : $item['sender'] }}
                            </p>
                            <p style="vertical-align: text-top; text-align: left">
                                Người nhận: {{ $item['receiver'] === null ? '' : $item['receiver'] }}
                            </p>
                        @elseif($item['type'] === 0)
                            <p style="vertical-align: text-top; text-align: left">
                                Người nhận: {{ $item['receiver'] === null ? '' : $item['receiver'] }}
                            </p>
                            <p style="vertical-align: text-top; text-align: left">
                                Người gửi: {{ $item['sender'] === null ? '' : $item['sender'] }}
                            </p>
                        @endif
                    </td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['number'] }}</td>
                    <td style="vertical-align: text-top; text-align: left">
                        @php
                            $date_date_from_date = new DateTime($item['from_date']);
                            $date_from_date = $date_date_from_date->format('d/m/Y');
                        @endphp
                        <p style="vertical-align: text-top; text-align: left">
                            Từ ngày: {{ $date_from_date }}
                        </p>
                        @php
                            $date_date_to_date = new DateTime($item['to_date']);
                            $date_to_date = $date_date_to_date->format('d/m/Y');
                        @endphp
                        <p style="vertical-align: text-top; text-align: left">
                            Đến ngày: {{ $date_to_date }}
                        </p>
                    </td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['status']['name'] }}</td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['content'] }}</td>
                    <td style="vertical-align: text-top; text-align: left">{{ $item['note'] }}</td>
                </tr>
            @endforeach
        @endforeach
        <tr>
            <td>Tổng</td>
            <td colspan="2">Công văn thông báo</td>
            <td>{{ $totalDispatches }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Trong đó</td>
            <td colspan="2">Công văn, thông báo gửi đi</td>
            <td>{{ $totalDispatchSens }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Công văn thông báo, tiếp nhận</td>
            <td>{{ $totalDispatchRecs }}</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;font-weight: bold">Người lập biểu</td>
            <td colspan="6"></td>
            <td colspan="2" style="text-align: center;font-weight: bold">Trưởng bộ phận</td>
        </tr>
    </table>
</body>

</html>
