<?php

namespace App\Enums;

enum ActionEnum: string {
    case UPDATE = 'UPDATE';
    case CREATE = 'CREATE';
    case DELETE = 'DELETE';
    case READ = 'READ';
    case UPLOAD = 'UPLOAD';
    case DOWNLOAD = 'DOWNLOAD';
    case SEND = 'SEND';
}