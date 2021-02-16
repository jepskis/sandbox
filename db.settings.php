<?php

    date_default_timezone_set( "America/Los_Angeles" );

    define( "DB_HOST" , "localhost" );
    define( "DB_USER" , "root" );
    define( "DB_PASS" , "123456" );
    define( "DB_NAME" , "streamliner" );
    define( "ELEMENTS_SEPARATOR" , "###" );

    define( "DB_NAME_PUBLISHED" , "matrix_splitted_asf" );

    define( "DEBUG_MODE" , TRUE );

    define( "PROJECT_PATH"               , "c:/xampp/htdocs/streamliner/web/" );
    define( "SERVER_ADDRESS"             , "http://localhost/" );
    define( "PROJECT_URL"                , "/streamliner/web/" );
    define( "LOGIN_SERVER"               , "https://streamliner.cisco.com/login/" );
    define( "USERS_GROUP"                , "login-sandbox_authenticated_user" );
    define( "HCL_URL"                    , SERVER_ADDRESS . PROJECT_URL . "/hcl-tool/" );
    define( "ADMIN_GROUP_NAME"           , "SLINER-prod-admin" );
    define( "MATRIX_REVIEWER_GROUP_NAME" , "SLINER-component-matrix-eng-reviewer" );
    define( "PRD_REVIEWER_GROUP_NAME"    , "SLINER-prod-prd-eng-reviewer" );

    require_once __DIR__ . "/emi.settings.php";