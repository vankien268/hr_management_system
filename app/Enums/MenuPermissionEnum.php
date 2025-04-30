<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MenuPermissionEnum extends Enum
{
    const VIEW_PROJECT_TYPE = 15; /* Xem phân loại dự án */

    const VIEW_SYSTEM_STATUS = 20; /* Xem danh sách trạng thái */

    const VIEW_DEPLOYMENT_SCHEDULE = 76; /* Xem lịch triển khai */

    const VIEW_DEPLOYMENT_RECORD = 81; /* Xem biên bản triển khai dự án */

    const VIEW_ACCEPTANCE_RECORD = 86; /* Xem biên bản nghiệm thu */

    const VIEW_DISPATCHES = 91; /* Xem công văn, thông báo */

    const VIEW_PRICE_QUOTE = 106; /* Xem báo giá sản phẩm */

    const VIEW_MENU_CONTRACT = 107; /* Xem hợp đồng */

    const VIEW_CUSTOMER = 108; /* Xem khách hàng */

    const VIEW_DEPARTMENT = 109; /* Xem bộ phận */

    const VIEW_CONTRACT_TYPE = 110; /* Xem loại hợp đồng */

    const VIEW_BANK = 111; /* Xem ngân hàng */

    const VIEW_PRODUCT_GROUP = 112; /* Xem nhóm sản phẩm, dịch vụ */

    const VIEW_PRODUCT = 113; /* Xem sản phẩm, dịch vụ */

    const VIEW_UNIT = 114; /* Xem đơn vị tính */

    const VIEW_TAX_FEE_RATE = 115; /* Xem tỉ lệ thuế phí */

    const VIEW_DECLARE_ROLE = 116; /* Xem nhóm quyền */

    const VIEW_USER = 117; /* Xem người dùng */

    const VIEW_MENU_PROJECT = 118; /* Xem dự án */

    const VIEW_CUSTOMER_REPORT = 120; /* Xem báo cáo khách hàng */

    const VIEW_PROJECT_REPORT = 121; /* Xem báo cáo dự án */

    const VIEW_CONTRACT_REPORT = 122; /* Xem báo cáo hợp đồng */

    const VIEW_DISPATCH_REPORT = 123; /* Xem báo cáo công văn, thông báo */

    const VIEW_PAYMENT_CONTRACT_REPORT = 124; /* Xem báo cáo tiến độ thanh toán hợp đồng */

    const VIEW_ACCEPTANCE_REPORT = 125; /* Xem báo cáo tiến độ nghiệm thu */

    const VIEW_DEPLOYMENT_REPORT = 126; /* Xem báo cáo tiến độ triển khai */
    const MenuPer = [
        ['id' => 15, 'code' => 'VIEW_PROJECT_TYPE', 'route_name' => 'admin.project_types.index'],
        ['id' => 20, 'code' => 'VIEW_SYSTEM_STATUS', 'route_name' => 'admin.statuses.view'],
        ['id' => 76, 'code' => 'VIEW_DEPLOYMENT_SCHEDULE', 'route_name' => 'admin.deployment_schedule.index'],
        ['id' => 81, 'code' => 'VIEW_DEPLOYMENT_RECORD', 'route_name' => 'admin.deployment-records.index'],
        ['id' => 86, 'code' => 'VIEW_ACCEPTANCE_RECORD', 'route_name' => 'admin.acceptance-records.index'],
        ['id' => 91, 'code' => 'VIEW_DISPATCHES', 'route_name' => 'admin.dispatches.index'],
        ['id' => 106, 'code' => 'VIEW_PRICE_QUOTE', 'route_name' => 'admin.quote.view'],
        ['id' => 107, 'code' => 'VIEW_MENU_CONTRACT', 'route_name' => 'admin.contract.view'],
        ['id' => 108, 'code' => 'VIEW_CUSTOMER', 'route_name' => 'admin.customers.view'],
        ['id' => 109, 'code' => 'VIEW_DEPARTMENT', 'route_name' => 'admin.departments.index'],
        ['id' => 110, 'code' => 'VIEW_CONTRACT_TYPE', 'route_name' => 'admin.contract_type.view'],
        ['id' => 111, 'code' => 'VIEW_BANK', 'route_name' => 'admin.banks.index'],
        ['id' => 112, 'code' => 'VIEW_PRODUCT_GROUP', 'route_name' => 'admin.product_group.view'],
        ['id' => 113, 'code' => 'VIEW_PRODUCT', 'route_name' => 'admin.products.index'],
        ['id' => 114, 'code' => 'VIEW_UNIT', 'route_name' => 'admin.units.index'],
        ['id' => 115, 'code' => 'VIEW_TAX_FEE_RATE', 'route_name' => 'admin.tax-fee-rates.index'],
        ['id' => 116, 'code' => 'VIEW_DECLARE_ROLE', 'route_name' => 'admin.roles.index'],
        ['id' => 117, 'code' => 'VIEW_USER', 'route_name' => 'admin.users.index'],
        ['id' => 118, 'code' => 'VIEW_MENU_PROJECT', 'route_name' => 'admin.projects-management.index'],
        ['id' => 120, 'code' => 'VIEW_CUSTOMER_REPORT', 'route_name' => 'admin.reports.customers.index'],
        ['id' => 121, 'code' => 'VIEW_PROJECT_REPORT', 'route_name' => 'admin.reports.projects.index'],
        ['id' => 122, 'code' => 'VIEW_CONTRACT_REPORT', 'route_name' => 'admin.reports.contracts.index'],
        ['id' => 123, 'code' => 'VIEW_DISPATCH_REPORT', 'route_name' => 'admin.reports.dispatches.index'],
        ['id' => 124, 'code' => 'VIEW_PAYMENT_CONTRACT_REPORT', 'route_name' => 'admin.reports.payment-details.index'],
        ['id' => 125, 'code' => 'VIEW_ACCEPTANCE_REPORT', 'route_name' => 'admin.reports.acceptance-records.index'],
        ['id' => 126, 'code' => 'VIEW_DEPLOYMENT_REPORT', 'route_name' => 'admin.reports.deployment-records.index'],
    ];
    const GROUP_MENU_DECLARE = [
        ['id' => 15, 'code' => 'VIEW_PROJECT_TYPE', 'route_name' => 'admin.project_types.index'],
        ['id' => 20, 'code' => 'VIEW_SYSTEM_STATUS', 'route_name' => 'admin.statuses.view'],
        ['id' => 109, 'code' => 'VIEW_DEPARTMENT', 'route_name' => 'admin.departments.index'],
        ['id' => 110, 'code' => 'VIEW_CONTRACT_TYPE', 'route_name' => 'admin.contract_type.view'],
        ['id' => 111, 'code' => 'VIEW_BANK', 'route_name' => 'admin.banks.index'],
        ['id' => 112, 'code' => 'VIEW_PRODUCT_GROUP', 'route_name' => 'admin.product_group.view'],
        ['id' => 113, 'code' => 'VIEW_PRODUCT', 'route_name' => 'admin.products.index'],
        ['id' => 114, 'code' => 'VIEW_UNIT', 'route_name' => 'admin.units.index'],
        ['id' => 115, 'code' => 'VIEW_TAX_FEE_RATE', 'route_name' => 'admin.tax-fee-rates.index'],
    ];
    const GROUP_MENU_MANAGEMENT = [
        ['id' => 76, 'code' => 'VIEW_DEPLOYMENT_SCHEDULE', 'route_name' => 'admin.deployment_schedule.index'],
        ['id' => 81, 'code' => 'VIEW_DEPLOYMENT_RECORD', 'route_name' => 'admin.deployment-records.index'],
        ['id' => 86, 'code' => 'VIEW_ACCEPTANCE_RECORD', 'route_name' => 'admin.acceptance-records.index'],
        ['id' => 91, 'code' => 'VIEW_DISPATCHES', 'route_name' => 'admin.dispatches.index'],
        ['id' => 106, 'code' => 'VIEW_PRICE_QUOTE', 'route_name' => 'admin.quote.view'],
        ['id' => 107, 'code' => 'VIEW_MENU_CONTRACT', 'route_name' => 'admin.contract.view'],
        ['id' => 108, 'code' => 'VIEW_CUSTOMER', 'route_name' => 'admin.customers.view'],
        ['id' => 118, 'code' => 'VIEW_MENU_PROJECT', 'route_name' => 'admin.projects-management.index'],
    ];
    const GROUP_MENU_USER = [
        ['id' => 116, 'code' => 'VIEW_DECLARE_ROLE', 'route_name' => 'admin.roles.index'],
        ['id' => 117, 'code' => 'VIEW_USER', 'route_name' => 'admin.users.index'],
    ];
    const GROUP_MENU_REPORT = [
        ['id' => 120, 'code' => 'VIEW_CUSTOMER_REPORT', 'route_name' => 'admin.reports.customers.index'],
        ['id' => 121, 'code' => 'VIEW_PROJECT_REPORT', 'route_name' => 'admin.reports.projects.index'],
        ['id' => 122, 'code' => 'VIEW_CONTRACT_REPORT', 'route_name' => 'admin.reports.contracts.index'],
        ['id' => 123, 'code' => 'VIEW_DISPATCH_REPORT', 'route_name' => 'admin.reports.dispatches.index'],
        ['id' => 124, 'code' => 'VIEW_PAYMENT_CONTRACT_REPORT', 'route_name' => 'admin.reports.payment-details.index'],
        ['id' => 125, 'code' => 'VIEW_ACCEPTANCE_REPORT', 'route_name' => 'admin.reports.acceptance-records.index'],
        ['id' => 126, 'code' => 'VIEW_DEPLOYMENT_REPORT', 'route_name' => 'admin.reports.deployment-records.index'],
    ];
}
