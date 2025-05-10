<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SystemPermissionEnum extends Enum
{
    const SYSTEM = 1; /* Hệ thống */

    const USER_MANAGEMENT = 2; /* Quản lý người dùng */

    const DECLARE_ROLE = 3; /* Khai báo nhóm quyền */

    const VIEW_DECLARE_ROLE = 116; /* Xem danh sách nhóm quyền */

    const ADD_DECLARE_ROLE = 5; /* Thêm nhóm quyền */

    const EDIT_DECLARE_ROLE = 6; /* Sửa nhóm quyền */

    const DELETE_DECLARE_ROLE = 7; /* Xóa nhóm quyền */

    const USER = 8; /* Khai báo người dùng */

    const VIEW_LIST_USER = 9; /* Xem danh sách người dùng */

    const ADD_USER = 10; /* Thêm người dùng */

    const EDIT_USER = 11; /* Sửa người dùng */

    const DELETE_USER = 12; /* Xóa người dùng */

    const CHANGE_PASSWORD_USER = 13; /* Đổi mật khẩu */

    const REQUEST_TICKETS = 14; /*Quản lý phiếu yêu cầu */

    const VIEW_REQUEST_TICKET = 15; /* Xem phiếu yêu cầu*/

    const ADD_REQUEST_TICKET = 16; /* Thêm mới phiếu yêu cầu */

    const EDIT_REQUEST_TICKET = 17; /* Sửa phiếu yêu cầu*/

    const DELETE_REQUEST_TICKET = 18; /* Xóa phiếu yêu cầu */

    const WORKFLOWS = 19; /* 'Khai báo quy trình duyệt' */

    const VIEW_WORKFLOW = 20; /* Xem danh sách quy trình duyệt */

    const ADD_WORKFLOW = 21; /* Thêm mới  quy trình duyệt */

    const EDIT_WORKFLOW = 22; /* Sửa  quy trình duyệt*/

    const DELETE_WORKFLOW = 23; /* Xóa  quy trình duyệt */

    const PROJECTS = 24; /* Thông tin dự án */

    const VIEW_PROJECT = 25; /* Xem */

    const EDIT_PROJECT = 26; /* Sửa */

    const VIEW_PHONE_CUSTOMER_CONTACT = 27; /* Xem SĐT Đại diện phía KH */

    const VIEW_EMAIL_CUSTOMER_CONTACT = 28; /* Xem Email Đại diện phía KH */

    const CONTRACTS = 29; /* Thông tin hợp đồng */

    const VIEW_CONTRACT = 30; /* Xem */

    const ADD_CONTRACT = 31; /* Thêm */

    const EDIT_CONTRACT = 32; /* Sửa */

    const DELETE_CONTRACT = 33; /* Xóa */

    const VIEW_DETAIL_PAYMENT_CONTRACT = 34; /* Xem chi tiết số lần thanh toán */

    const CUSTOMER = 35; /* Khai báo khách hàng */

    const VIEW_LIST_CUSTOMER = 36; /* Xem danh sách khách hàng */

    const VIEW_LIST_CUSTOMER_VIP = 37; /* Xem danh sách khách hàng VIP */

    const ADD_CUSTOMER = 38; /* Thêm mới khách hàng */

    const EDIT_CUSTOMER = 39; /* Sửa khách hàng */

    const DELETE_CUSTOMER = 40; /* Xóa khách hàng */

    const CUD_CUSTOMER_VIP = 41; /* Thêm, sửa, xóa khách hàng VIP */

    const VIEW_CUSTOMER_CONTACT = 42; /* Xem người liên hệ */

    const VIEW_CUSTOMER_PHONE = 43; /* Xem số điện thoại */

    const DEPARTMENT = 44; /* Khai báo bộ phận */

    const ADD_DEPARTMENT = 45; /* Thêm mới bộ phận */

    const EDIT_DEPARTMENT = 46; /* Sửa bộ phận */

    const DELETE_DEPARTMENT = 47; /* Xóa bộ phận */

    const CONTRACT_TYPE = 48; /* Khai báo loại hợp đồng */

    const ADD_CONTRACT_TYPE = 49; /* Thêm mới loại hợp đồng */

    const EDIT_CONTRACT_TYPE = 50; /* Sửa loại hợp đồng */

    const DELETE_CONTRACT_TYPE = 51; /* Xóa loại hợp đồng */

    const BANK = 52; /* Khai báo ngân hàng */

    const ADD_BANK = 53; /* Thêm mới ngân hàng */

    const EDIT_BANK = 54; /* Sửa ngân hàng */

    const DELETE_BANK = 55; /* Xóa ngân hàng */

    const ALLOWANCES = 56; /* Khai báo nhóm sản phẩm, dịch vụ */

    const ADD_ALLOWANCE = 57; /* Thêm mới nhóm sản phẩm, dịch vụ */

    const EDIT_ALLOWANCE = 58; /* Sửa nhóm sản phẩm, dịch vụ */

    const DELETE_ALLOWANCE = 59; /* Xóa nhóm sản phẩm, dịch vụ */

    const TAXES = 60; /* Khai báo sản phẩm, dịch vụ */

    const ADD_TAXES = 61; /* Thêm mới sản phẩm, dịch vụ */

    const EDIT_TAXES = 62; /* Sửa sản phẩm, dịch vụ */

    const DELETE_TAXES = 63; /* Xóa sản phẩm, dịch vụ */

    const INTERNAL_FUND = 64; /* Khai báo đơn vị tính */

    const ADD_UNIT = 65; /* Thêm mới đơn vị tính */

    const EDIT_INTERNAL_FUND = 66; /* Sửa đơn vị tính */

    const DELETE_UNIT = 67; /* Xóa đơn vị tính */

    const USER_LEAVE_DAYS = 68; /* Khai báo tỉ lệ thuế phí */

    const ADD_TAX_FEE_RATE = 69; /* Thêm mới tỉ lệ thuế phí */

    const EDIT_USER_LEAVE_DAYS = 70; /* Sửa tỉ lệ thuế phí */

    const DELETE_TAX_FEE_RATE = 71; /* Xóa tỉ lệ thuế phí */

    const HRM_CONTACTS = 72; /* QUẢN LÝ NHÂN SỰ */

    const VIEW_HRM_CONTACT = 73; /*Xem danh sách nhân sự*/

    const ADD_HRM_CONTACT = 74; /* Thêm danh sách nhân sự */

    const DEPLOYMENT_SCHEDULE = 75; /* Quản lý lịch triển khai */

    const VIEW_DEPLOYMENT_SCHEDULE = 76; /* Xem lịch triển khai */

    const ADD_DEPLOYMENT_SCHEDULE = 77; /* Thêm mới lịch triển khai */

    const EDIT_DEPLOYMENT_SCHEDULE = 78; /* Sửa lịch triển khai */

    const DELETE_DEPLOYMENT_SCHEDULE = 79; /* Xóa lịch triển khai */

    const DEPLOYMENT_RECORD = 80; /* Quản lý biên bản triển khai dự án */

    const VIEW_DEPLOYMENT_RECORD = 81; /* Xem biên bản triển khai dự án */

    const ADD_DEPLOYMENT_RECORD = 82; /* Thêm mới biên bản triển khai dự án */

    const EDIT_DEPLOYMENT_RECORD = 83; /* Sửa biên bản triển khai dự án */

    const DELETE_DEPLOYMENT_RECORD = 84; /* Xóa biên bản triển khai dự án */

    const ACCEPTANCE_RECORD = 85; /* Quản lý biên bản nghiệm thu */

    const VIEW_ACCEPTANCE_RECORD = 86; /* Xem biên bản nghiệm thu */

    const ADD_ACCEPTANCE_RECORD = 87; /* Thêm mới biên bản nghiệm thu */

    const EDIT_ACCEPTANCE_RECORD = 88; /* Sửa biên bản nghiệm thu */

    const DELETE_ACCEPTANCE_RECORD = 89; /* Xóa biên bản nghiệm thu */

    const DISPATCHES = 90; /* Quản lý công văn, thông báo */

    const VIEW_DISPATCHES = 91; /* Xem công văn, thông báo */

    const ADD_DISPATCHES = 92; /* Thêm mới công văn, thông báo */

    const EDIT_DISPATCHES = 93; /* Sửa công văn, thông báo */

    const DELETE_DISPATCHES = 94; /* Xóa công văn, thông báo */

    const PRICE_QUOTES = 95; /* Thông tin báo giá */

    const VIEW_PRICE_QUOTES = 96; /* Xem */

    const ADD_PRICE_QUOTES = 97; /* Thêm */

    const EDIT_PRICE_QUOTES = 98; /* Sửa */

    const DELETE_PRICE_QUOTES = 99; /* Xóa */

    const PRICE_QUOTE = 100; /* Báo giá sản phẩm */

    const APPROVE_PRICE_QUOTE = 101; /* Duyệt báo giá sản phẩm */

    const CONTRACT = 102; /* Hợp đồng */

    const VIEW_HRM_CONTRACT = 103; /* Xem danh sách hợp đồng */

    const SYSTEM_ADMIN = 104; /* Admin */

    const VIEW_PRICE_CONTRACT = 105; /* Xem giá trị hợp đồng */

    const VIEW_PRICE_QUOTE = 106; /* Xem báo giá sản phẩm */

    const VIEW_MENU_CONTRACT = 107; /* Xem hợp đồng */

    const VIEW_CUSTOMER = 108; /* Xem khách hàng */

    const VIEW_DEPARTMENT = 109; /* Xem bộ phận */

    const VIEW_CONTRACT_TYPE = 110; /* Xem loại hợp đồng */

    const VIEW_BANK = 111; /* Xem ngân hàng */

    const VIEW_ALLOWANCE = 112; /* Xem nhóm sản phẩm, dịch vụ */

    const VIEW_TAXES = 113; /* Xem sản phẩm, dịch vụ */

    const VIEW_INTERNAL_FUND = 114; /* Xem đơn vị tính */

    const VIEW_USER_LEAVE_DAYS = 115; /* Xem tỉ lệ thuế phí */

    const VIEW_LIST_DECLARE_ROLE = 116; /* Xem nhóm quyền */

    const VIEW_USER = 117; /* Xem người dùng */

    const VIEW_MENU_PROJECT = 118; /* Xem dự án */

    const REPORT = 119; /* Báo cáo */

    const VIEW_CUSTOMER_REPORT = 120; /* Xem báo cáo khách hàng */

    const VIEW_PROJECT_REPORT = 121; /* Xem báo cáo dự án */

    const VIEW_CONTRACT_REPORT = 122; /* Xem báo cáo hợp đồng */

    const VIEW_DISPATCH_REPORT = 123; /* Xem báo cáo công văn, thông báo */

    const VIEW_PAYMENT_CONTRACT_REPORT = 124; /* Xem báo cáo tiến độ thanh toán hợp đồng */

    const VIEW_ACCEPTANCE_REPORT = 125; /* Xem báo cáo tiến độ nghiệm thu */

    const VIEW_DEPLOYMENT_REPORT = 126; /* Xem báo cáo tiến độ triển khai */

    const EDIT_HRM_CONTACT = 127; /* Sửa nhân sự */

    const DELETE_HRM_CONTACT = 128; /* Xóa nhân sự */

    const ADD_HRM_CONTRACT = 129; /* Thêm mới hợp đồng */

    const EDIT_HRM_CONTRACT = 130; /* Sửa hợp đồng */

    const DELETE_HRM_CONTRACT = 131; /* Xóa hợp đồng */

    const SYSTEM_DECENTRALIZATION_PROJECT = 132; /* Phân quyền dự án */

    const VIEW_LIST_PRICE_QUOTE = 133; /* Xem danh sách báo giá sản phẩm */

    const ADD_SYSTEM_PRICE_QUOTE = 134; /* Thêm báo giá sản phẩm */

    const EDIT_SYSTEM_PRICE_QUOTE = 135; /* Sửa báo giá sản phẩm */

    const DELETE_SYSTEM_PRICE_QUOTE = 136; /* Xóa báo giá sản phẩm */
}
