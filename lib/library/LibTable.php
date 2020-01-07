<?php

class LibTable
{
    static $config = 'config';
    static $sy_user = 'sy_user';
    static $sy_user_config = 'sy_user_config';
    static $sy_real_auth = 'sy_real_auth';
    static $sy_game = 'game';
    static $sy_game_ext = 'game_ext';
    static $sy_game_package = 'game_package';
    static $sy_game_package_refresh = 'game_package_refresh';
    static $sy_game_server_merge = 'game_server_merge';
    static $sy_game_update = 'game_update';
    static $sy_gift = 'sy_gift';
    static $sy_gift_type = 'sy_gift_type';
    static $sy_article = 'sy_article';
    static $sy_article_content = 'sy_article_content';
    static $sy_order = 'sy_order';
    static $sy_order_ext = 'sy_order_ext';
    static $sy_openid = 'sy_openid';
    static $user_role = 'user_role';
    static $user_ext = 'user_ext';
    static $channel = 'channel';
    static $channel_company = 'channel_company';
    static $channel_group = 'channel_group';
    static $channel_user = 'channel_user';
    static $channel_upload_log = 'channel_upload_log';
    static $channel_user_auth = 'channel_user_auth';
    static $channel_user_app = 'channel_user_app';
    static $admin_user = 'admin_user';
    static $admin_role = 'admin_role';
    static $admin_log = 'admin_log';
    static $ad_click = 'ad_click';
    static $ad_project = 'ad_project';
    static $ad_pay_upload = 'ad_pay_upload';
    static $ad_discount = 'ad_discount';
    static $land_model = 'land_model';
    static $land_page = 'land_page';
    static $data_pay_login_retain = 'data_pay_login_retain';
    static $data_pay_money_retain = 'data_pay_money_retain';
    static $data_pay_retain = 'data_pay_retain';
    static $data_new_overview = 'data_new_overview';
    static $data_new_overview_month = 'data_new_overview_month';
    static $data_new_overview_months = 'data_new_overview_months';
    static $data_new_server_overview = 'data_new_server_overview';
    static $data_time_gap = 'data_time_gap';
    static $data_overview_day = 'data_overview_day';
    static $data_overview_hour = 'data_overview_hour';
    static $data_reg = 'data_reg';
    static $data_reg_hour = 'data_reg_hour';
    static $data_ltv = 'data_ltv';
    static $data_dau = 'data_dau';
    static $data_game_server = 'data_game_server';
    static $data_retain = 'data_retain';
    static $data_pay = 'data_pay';
    static $data_pay_hour = 'data_pay_hour';
    static $data_pay_monitor = 'data_pay_monitor';
    static $data_pay_monitor_hour = 'data_pay_monitor_hour';
    static $data_pay_hall = 'data_pay_hall';
    static $data_pay_habit = 'data_pay_habit';
    static $data_pay_habits = 'data_pay_habits';
    static $data_pay_new = 'data_pay_new';
    static $data_pay_new_server_role = 'data_pay_new_server_role';
    static $data_pay_area = 'data_pay_area';
    static $data_channel_hour_pay = 'data_channel_hour_pay';
    static $data_level = 'data_level';
    static $data_other = 'data_other';
    static $data_others = 'data_others';
    static $data_land_tj_date_code = 'data_land_tj_date_code';
    static $data_land_tj_hour_code = 'data_land_tj_hour_code';
    static $data_land_tj_hour = 'data_land_tj_hour';
    static $data_land_heat_map = 'data_land_heat_map';
    static $data_channel_effect = 'data_channel_effect';
    static $data_hour_land = 'data_hour_land';
    static $data_hour_land_ios = 'data_hour_land_ios';
    static $data_cycle_time = 'data_cycle_time';
    static $cp_user = 'cp_user';
    static $cp_users = 'cp_users';
    static $material = 'material';
    static $material_land = 'material_land';
    static $data_finance = 'data_finance';
    static $data_upload = 'data_upload';
    static $log_active = 'log_active';
    static $log_reg = 'log_reg';
    static $log_login = 'log_login';
    static $log_role = 'log_role';
    static $log_land = 'log_land';
    static $log_user = 'user_log_';
    static $tag = 'tag';
    static $data_new_pay_retain = 'data_new_pay_retain';
    static $data_click = 'data_click';
    static $data_click_hour = 'data_click_hour';
    static $data_active = 'data_active';
    static $data_active_hour = 'data_active_hour';
    static $data_new_role = 'data_new_role';
    static $data_new_role_hour = 'data_new_role_hour';
    static $data_login = 'data_login';
    static $data_login_hour = 'data_login_hour';
    static $data_log_day = 'data_log_day';
    static $data_online = 'data_online';
    static $sy_vip = 'kf_vip';
    static $data_discount = 'data_discount';
    static $kf_game_server = 'kf_game_server';
    static $active = 'active';
    static $data_split_upload = 'data_split_upload';
    static $aso_discount = 'aso_discount';
    static $data_aso_discount = 'data_aso_discount';
    static $order_log = 'order_log';
    static $data_login_log = 'data_login_log';
    static $login_log = 'login_log';
    static $forbidden = 'forbidden';
    static $forbidden_white = 'forbidden_white';
    static $user_server_log = 'user_server_log';

    //广告投放
    static $ad_app = 'ad_app';
    static $ad_advertiser = 'ad_advertiser';
    static $ad_account = 'ad_account';
    static $ad_account_auth = 'ad_account_auth';
    static $ad_adio_group = 'ad_adio_group';
    static $ad_adio = 'ad_adio';
    static $ad_material = 'ad_material';
    static $ad_copywriting = 'ad_copywriting';// 文案
    static $directional_package = 'directional_package';
    static $batch_create_ad = 'batch_create_ad'; // 批量创建广告

    //联运分发
    static $platform = 'platform';
    static $platform_game = 'platform_game';


}