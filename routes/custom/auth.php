<?php

use App\Controllers\AuthController;


$router->post('/login', [AuthController::class, 'login']);
$router->post('/register', [AuthController::class, 'register']);
$router->post('/reset', [AuthController::class, 'reset']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->post('/send-link', [AuthController::class, 'sendLink']);
$router->post('/reset-password', [AuthController::class, 'resetPassword']);




