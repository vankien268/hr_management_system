<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ProjectPermissionEnum extends Enum
{
    // Mã cha thông tin dự án
    const PROJECT_INFO_ID = 24;
    // Mã cha thông tin hợp đồng
    const CONTRACT_INFO_ID = 29;


    const VIEW_PROJECT = 'VIEW_PROJECT'; // xem dự án
    // mã id quyền xem dự án
    const VIEW_PROJECT_ID = 25;
    const EDIT_PROJECT = 'EDIT_PROJECT'; // sửa dự án
    const VIEW_PHONE_CUSTOMER_CONTACT = 'VIEW_PHONE_CUSTOMER_CONTACT'; // xem sdt khách hàng
    const VIEW_EMAIL_CUSTOMER_CONTACT = 'VIEW_EMAIL_CUSTOMER_CONTACT'; // xem email khách hàng
    const VIEW_CONTRACT = 'VIEW_CONTRACT'; // xem hợp đồng
    const ADD_CONTRACT = 'ADD_CONTRACT'; // thêm hợp đồng
    const EDIT_CONTRACT = 'EDIT_CONTRACT'; // sửa hợp đồng
    const DELETE_CONTRACT = 'DELETE_CONTRACT'; // xóa hợp đồng
    const VIEW_DETAIL_PAYMENT_CONTRACT = 'VIEW_DETAIL_PAYMENT_CONTRACT'; // xem số lần thanh toán hợp đồng
    const VIEW_PRICE_CONTRACT = 'VIEW_PRICE_CONTRACT'; // xem giá hợp đồng

    // Khai báo báo giá
    // Mã cha thông tin báo giá
    const QOUTES_PRICE_INFO_ID = 95;
    //xem báo giá
    const VIEW_PRICE_QUOTES_ID= 96;
    const VIEW_PRICE_QUOTES = "VIEW_PRICE_QUOTES";
    const ADD_PRICE_QUOTES="ADD_PRICE_QUOTES";
    const EDIT_PRICE_QUOTES="EDIT_PRICE_QUOTES";
    const DELETE_PRICE_QUOTES="DELETE_PRICE_QUOTES";

    // Tổng tất cả checkbox chức năng cần phân quyền trong dự án
    const TOTAL_FUNCTION_OF_PROJECT = 14;

}
