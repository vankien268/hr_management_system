<!DOCTYPE html>
<html>

<head>
    <title>Chi tiết thông tin báo giá</title>
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
       CHI TIẾT LỊCH TRIỂN KHAI</div>
        <div class="text">

            <br />
        </div>
        <table style="width: 100%;;font-size: 12px; border:0px;">
            <tbody>
                <tr>
                    <td
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 18% !important">
                        Mã lịch triển khai : </td>
                    <td colspan="2"
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 12% !important;">
                        {{ $data['code'] }}</td>
                        <td
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 12% !important">
                        Thuộc dự án :</td>
                        <td colspan="2"
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 12% !important">
                        {{ $data['project']->toArray()['data']['name'] }}</td>
                </tr>
                <tr>
                    <td
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 19% !important">
                        Tiêu đề lịch triển khai :</td>
                    <td colspan="2"
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 12% !important;">
                        {{ $data['title'] }}</td>
                        <td
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 12% !important">
                        Loại hợp đồng :</td>
                        <td colspan="2"
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 12% !important">
                        {{ $data['contractType']->toArray()['data']['name'] }}</td>
                </tr>
                <tr>
                    <td
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 12% !important">
                        Trạng thái :</td>
                    <td colspan="2"
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 12% !important;">
                        {{ $data['status']->toArray()['data']['name'] }}</td>
                        <td
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 17% !important">
                        Ghi chú quan trọng :</td>
                        <td colspan="2"
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 12% !important">
                        {{ $data['note'] }} </td>
                </tr>
                <tr>
                    <td
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 18% !important">
                        Thời gian thực hiện :</td>
                    <td colspan="2"
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 12% !important;">
                        {{Carbon\Carbon::parse($data['from_date'])->format('d/m/Y') .' - '.Carbon\Carbon::parse($data['to_date'])->format('d/m/Y') }}</td>
                        <td colspan="2"
                        style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;;width: 12% !important">
                        </td>
                </tr>

            </tbody>
        </table>
        <div style="border-top:1px solid lightgray;padding-bottom:8px; margin-top:5px;" ></div>
        <div style="margin-bottom:5px;"><b>Chi tiết lịch triển khai theo ngày</b></div>
        @php
            $deploymentScheduleDetails = array();
            foreach ($data['deploymentScheduleDetails']->toArray()['data'] as $element) {
                $deploymentScheduleDetails[$element['day']][] = $element;
            }
            $deploymentScheduleDetails = array_values($deploymentScheduleDetails);
            $users = $data['users']->toArray()['data'];
        @endphp
        <table style="width: 100%;border-spacing: 0px;font-size: 12px; ">
            <tbody>
                <tr >
                    <th style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width:40px;text-align: center">STT</th>
                    <th style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 100px !important;text-align: center">Ngày</th>
                    <th style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 100px !important;text-align: center">Ca triển khai</th>
                    <th style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">Chức năng/sản phẩm</th>
                    <th style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 50% !important;text-align: left">Diễn giải</th>
                </tr>
                @if(count($deploymentScheduleDetails) > 0)

                    @foreach ($deploymentScheduleDetails as $key => $rows)
                            @foreach ($rows as $key2 => $rowSub)
                                <tr >
                                    @if ($rowSub['shift'] < 1)
                                        <td rowspan="3" style="padding-top: 3px;padding-bottom: 3px;border: 1px solid rgba(0, 0, 0, 0.199);text-align: center">{{ $key + 1 }}</td>
                                    @endif
                                    @if ($rowSub['shift'] < 1)
                                        <td rowspan="3"  style="padding-top: 3px;padding-bottom: 3px;width:20%;border: 1px solid rgba(0, 0, 0, 0.199);text-align: center">
                                            {{ Carbon\Carbon::parse($rowSub['day'])->format('d/m/Y') }} </td>
                                    @endif

                                    <td  style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: center">{{ $rowSub['shift'] == 0 ? 'Ca sáng' : ($rowSub['shift'] == 1 ? 'Ca chiều' : 'Ca tối') }}</td>
                                    <td   style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">{{ $rowSub['product_function'] }}</td>
                                    <td   style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">{{ $rowSub['description'] }}</td>
                                </tr>
                            @endforeach

                    @endforeach
                @else
                <tr>
                    <td  style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;"
                        class="text-center" colspan="5">Không có dữ liệu hiển thị
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        <br />
        <div style="border-top:1px solid lightgray;padding-bottom:8px; margin-top:5px;" ></div>
        <div style="margin-bottom:5px;"><b>Chuyên viên thực hiện dự án</b></div>
        <table style="width: 100%;border-spacing: 0px;font-size: 12px; ">
            <tbody>
                <tr >
                    <th style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width:50px;text-align: center">STT</th>
                    <th style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 30% !important;text-align: left">Tên chuyên viên</th>
                    <th style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">Số điện thoại</th>
                    <th style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">Email</th>
                    <th style="padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">Skype</th>
                </tr>
                @if(count($users) > 0)
                    @foreach ($users as $key => $rows)
                            <tr >
                                <td  style="padding-top: 3px;padding-bottom: 3px;border: 1px solid rgba(0, 0, 0, 0.199);text-align: center">{{ $key + 1 }}</td>
                                <td  style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 30% !important;text-align: left">
                                    {{ $rows['name'].'( '.$rows['username'].' )' }}</td>
                                <td  style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">
                                    {{ $rows['phone'] }}</td>
                                <td   style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">
                                    {{ $rows['email'] }}</td>
                                <td   style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;text-align: left">
                                    {{ $rows['skype'] }}</td>
                            </tr>
                    @endforeach
                 @else
                    <tr>
                        <td  style="padding-top: 3px;padding-bottom: 3px;padding-left: 5px;border: 1px solid rgba(0, 0, 0, 0.199);width: 20% !important;"
                         class="text-center" colspan="5">Không có dữ liệu hiển thị
                        </td>
                    </tr>
                 @endif
            </tbody>
        </table>
        <div style="border-top:1px solid lightgray;padding-bottom:8px; margin-top:18px;" ></div>
        <div style="margin-bottom:5px;"><b>Nội dung yêu cầu dự án</b></div>
        <div>
            <span>{{ $data['project_content'] }}</span>
        </div>
    </body>
</html>
