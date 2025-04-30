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
            <td colspan="3" style="text-align: center; vertical-align: text-top;font-weight: bold; font-size: 14px">
                <span>{{ $data['reportName'] }}</span>
                <br>
                @php
                    $payment_date_from_date = isset($data['payment_date_from_date']) ? 'Từ ngày ' . $data['payment_date_from_date'] : '';
                    $payment_date_to_date = isset($data['payment_date_to_date']) ? 'Đến ngày ' . $data['payment_date_to_date'] : '';
                    if (!isset($data['payment_date_from_date']) && !isset($data['payment_date_to_date'])) {
                        $payment_date_from_date = '';
                        $payment_date_to_date = '';
                    }
                @endphp
                <span>{{ $payment_date_from_date }} {{ $payment_date_to_date }}</span>
            </td>
            <td colspan="2" style="vertical-align: text-top;font-size: 10px">
                <span>Ngày in: {{ $data['dateIn'] }}</span>
                <br>
                <span>Người in: {{ $data['userIn'] }}</span>
            </td>
        </tr>
        <tr style="background-color: #ccc; font-weight: bold;height: 50px">
            <th style="text-align: center">STT</th>
            <th style="width: 80px">LẦN</th>
            <th style="width: 230px">NGÀY THANH TOÁN DỰ KIẾN</th>
            <th>SỐ THANH TOÁN DỰ KIẾN</th>
            <th>NGÀY THANH TOÁN DỰ KIẾN</th>
            <th style="width: 150px">SỐ TIỀN THANH TOÁN THỰC TẾ</th>
            <th>CHƯA THANH TOÁN</th>
            <th style="width: 100px">GHI CHÚ</th>

        </tr>
        @foreach ($getExportPaymentDetails as $key => $item)
            <tr>
                <td colspan="8" style="vertical-align: text-top;text-align: left; height: 50px;font-weight: bold">
                    <span>{{ $item['code'] }} - {{ $item['name'] }}</span>
                    <br>
                    <span>{{ $item['customer']['code'] }} - {{ $item['customer']['name'] }}</span>
                </td>
            </tr>
            @foreach ($item['contracts'] as $keyContract => $itemContract)
                <tr>
                    <td style="vertical-align: text-top;text-align: center; height: 50px">{{ (int) $keyContract + 1 }}
                    </td>
                    <td colspan="7" style="vertical-align: text-top;text-align: left; height: 50px;font-weight: bold">
                        @php
                            $date_signing_date = new DateTime($item['signing_date']);
                            $signing_date = $date_signing_date->format('d/m/Y');
                        @endphp
                        <span>Ngày ký: {{ $itemContract['signing_date'] }}</span>
                        <br>
                        <span>Số hợp đồng: {{ $itemContract['code'] }}</span>
                    </td>
                </tr>
                @foreach ($itemContract['paymentDetails'] as $keyPaymentDetail => $itemPaymentDetail)
                    <tr>
                        <td style="vertical-align: text-top;text-align: center;"></td>
                        <td style="vertical-align: text-top;text-align: center;"> Lần
                            {{ $itemPaymentDetail['payment_times'] }}</td>
                        @php
                            $date_expected_payment_date = new DateTime($itemPaymentDetail['expected_payment_date']);
                            $expected_payment_date = $date_expected_payment_date->format('d/m/Y');
                        @endphp
                        <td style="vertical-align: text-top;text-align: left;">{{ $expected_payment_date }}
                        </td>
                        <td style="vertical-align: text-top;text-align: right;">
                            {{ str_replace(',', '.', number_format((int) $itemPaymentDetail['amount'])) }}</td>

                        @php
                            if ($itemPaymentDetail['payment_date'] == null) {
                                $payment_date = '';
                            } else {
                                $date_payment_date = new DateTime($itemPaymentDetail['payment_date']);
                                $payment_date = $date_payment_date->format('d/m/Y');
                            }

                        @endphp
                        <td style="vertical-align: text-top;text-align: left;">{{ $payment_date }}</td>
                        <td style="vertical-align: text-top;text-align: right;">
                            {{ str_replace(',', '.', number_format((int) $itemPaymentDetail['actual_amount'])) }}
                        </td>
                        <td style="vertical-align: text-top;text-align: right;">
                            {{ str_replace(',', '.', number_format((int) $itemPaymentDetail['amount'] - (int) $itemPaymentDetail['actual_amount'])) }}
                        </td>
                        <td style="vertical-align: text-top;text-align: left;">
                            {{ $itemPaymentDetail['note'] }}
                        </td>
                    </tr>
                @endforeach
                {{-- tổng doanh thu hợp đồng --}}
                <tr>
                    <td style="vertical-align: text-top;text-align: center;"></td>
                    <td colspan="2" style="vertical-align: text-top;text-align: center;font-weight:bold">Tổng doanh
                        thu
                        hợp
                        đồng</td>
                    @php
                        $totalAmountContract = 0;
                    @endphp
                    @foreach ($itemContract['paymentDetails'] as $keyPaymentDetail => $itemPaymentDetail)
                        @php
                            $totalAmountContract += (int) $itemPaymentDetail['amount'];
                        @endphp
                    @endforeach
                    <td style="vertical-align: text-top;text-align: right;">
                        {{ str_replace(',', '.', number_format($totalAmountContract)) }}
                    </td>

                    <td style="vertical-align: text-top;text-align: center;"></td>
                    @php
                        $totalActualAmountContract = 0;
                    @endphp
                    @foreach ($itemContract['paymentDetails'] as $keyPaymentDetail => $itemPaymentDetail)
                        @php
                            $totalActualAmountContract += (int) $itemPaymentDetail['actual_amount'];
                        @endphp
                    @endforeach
                    <td style="vertical-align: text-top;text-align: right;">
                        {{ str_replace(',', '.', number_format((int) $totalActualAmountContract)) }}
                    </td>
                    <td style="vertical-align: text-top;text-align: right;">
                        {{ str_replace(',', '.', number_format((int) $totalAmountContract - (int) $totalActualAmountContract)) }}
                    <td style="vertical-align: text-top;text-align: center;"></td>
                </tr>
            @endforeach
            {{-- tổng doanh thu dự án --}}
            <tr>
                <td colspan="3" style="vertical-align: text-top;text-align: center;font-weight:bold">Tổng doanh thu
                    dự án</td>
                @php
                    $totalAmountProject = 0;
                @endphp
                @foreach ($item['contracts'] as $itemContract)
                    @foreach ($itemContract['paymentDetails'] as $itemPaymentDetail)
                        @php
                            $totalAmountProject += (int) $itemPaymentDetail['amount'];
                        @endphp
                    @endforeach
                @endforeach
                <td style="vertical-align: text-top;text-align: right;">
                    {{ str_replace(',', '.', number_format($totalAmountProject)) }}
                </td>

                <td style="vertical-align: text-top;text-align: center;"></td>
                @php
                    $totalActualAmountProject = 0;
                @endphp
                @foreach ($item['contracts'] as $itemContract)
                    @foreach ($itemContract['paymentDetails'] as $itemPaymentDetail)
                        @php
                            $totalActualAmountProject += (int) $itemPaymentDetail['actual_amount'];
                        @endphp
                    @endforeach
                @endforeach
                <td style="vertical-align: text-top;text-align: right;">
                    {{ str_replace(',', '.', number_format((int) $totalActualAmountProject)) }}
                </td>
                <td style="vertical-align: text-top;text-align: right;">
                    {{ str_replace(',', '.', number_format((int) $totalAmountProject - (int) $totalActualAmountProject)) }}
                </td>
                <td style="vertical-align: text-top;text-align: center;"></td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;font-weight: bold">Người lập biểu</td>
            <td colspan="4"></td>
            <td colspan="2" style="text-align: center;font-weight: bold">Trưởng bộ phận</td>
        </tr>
    </table>
</body>

</html>
