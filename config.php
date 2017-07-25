<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
//DB
$DB_HOST = 'alfaspa.mysql.ukraine.com.ua';
$DB_NAME = 'alfaspa_corp';
$DB_USER = 'alfaspa_corp';
$DB_PASSWORD = 'unc4l3ds';

//Admin
$ALANG = 'ru';
$PROJECT_NAME = "Alfa-Spa";
$ADMIN_SESSION_AUTH = 1;

$LANGS = array('1'=>'Rus', '2'=>'Ukr', '3'=>'Eng');
$FOLDER_IMAGES = "web/images";
$FOLDER_FILES = "web/userfiles";

//Tables
$TABLE_DOCS_RUBS="docs_rubs";
$TABLE_DOCS="docs";
$TABLE_NEWS_RUBS="news_rubs";
$TABLE_NEWS="news";

$TABLE_USERS_RUBS="utypes";
$TABLE_USERS="users";
$TABLE_MAIL="emails";
$TABLE_TAGS = "tags";

$TABLE_ADMINS_GROUPS="admins_groups";
$TABLE_ADMINS="admins";
$TABLE_ADMINS_MENU="admins_menu";
$TABLE_ADMINS_MENU_ASSOC="admins_menu_assoc";
$TABLE_ADMINS_LOG="admins_log";
