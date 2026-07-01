<?php

require_once __DIR__ . '/config_security.php';

// Url


// Configuration

function alltotal() { global $conn; include __DIR__ . '/config_alltotal.php'; }
function connect() { global $conn; include __DIR__ . '/config_connect.php'; }
function excelreader() { include __DIR__ . '/config_excel_reader.php'; }
function generate() { global $conn; include __DIR__ . '/config_generate.php'; }
function pagination() { include __DIR__ . '/config_pagination.php'; }
function session() { include __DIR__ . '/config_session.php'; }
function session2() { include __DIR__ . '/config_session2.php'; }
function timing() { global $conn; include __DIR__ . '/config_time.php'; }

// Component

function body() { include 'component/core/body.php'; } // Body Component
function footer() { include 'component/core/footer.php'; } // Footer Component
function head() { include 'component/core/head.php'; } // Head Component
function theader() { include 'component/core/theader.php'; } // Header Component
function menu() { include 'component/core/menu.php'; } // Menu Component
function usermenu() { include 'component/core/user_menu.php'; } // Menu Component


// ETC

function breadcrumb() { include 'component/core/breadcrumb.php'; } // Breadcrumb Component
function etc() { global $conn; include __DIR__ . '/config_etc.php'; }
function encryption() { include 'configuration/config_encrypt.php'; } // encrypt Configuration



?>