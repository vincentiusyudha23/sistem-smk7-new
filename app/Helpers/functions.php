<?php

use Carbon\Carbon;

function getCurrentTimeOfDay($user = '')
{
    $hour = Carbon::now()->format('H');
    
    if ($hour >= 5 && $hour < 12) {
        return 'Selamat Pagi, '.$user;
    } elseif ($hour >= 12 && $hour < 16) {
        return 'Selamat Siang, '.$user;
    } elseif ($hour >= 16 && $hour < 19) {
        return 'Selamat Sore, '.$user;
    } else {
        return 'Selamat Malam, '.$user;
    }
}

function getCapitalText($kelas)
{
    switch ($kelas) {
        case 10:
            return 'X';
            break;
        case 11:
            return 'XI';
            break;
        case 12:
            return 'XII';
            break;
        default:
            return '';
            break;
    }
}