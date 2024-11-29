<?php

namespace App\Utils\AutoLoad;

// Use the Eloquent model
use App\Models\Rest;

// Fetch all records from the 'rest' table
global $rest;
global $restnm;
global $email1;
global $email2;
global $email3;
global $email4;
global $email5;
global $phone1;
global $phone2;
global $phone3;
global $phone4;
global $phone5;
global $add1;
global $add2;
global $add3;
global $add4;
global $add5;
global $add6;
global $geolink;
global $timezone;

$rest = Rest::first();

$restnm = trim($rest->restnm);
$email1 = trim($rest->email1);
$email2 = trim($rest->email2);
$email3 = trim($rest->email3);
$email4 = trim($rest->email4);
$email5 = trim($rest->email5);
$phone1 = trim($rest->phone1);
$phone2 = trim($rest->phone2);
$phone3 = trim($rest->phone3);
$phone4 = trim($rest->phone4);
$phone5 = trim($rest->phone5);
$add1 = trim($rest->add1);
$add2 = trim($rest->add2);
$add3 = trim($rest->add3);
$add4 = trim($rest->add4);
$add5 = trim($rest->add5);
$add6 = trim($rest->add6);
$geolink = trim($rest->geolink);
$timezone = trim($rest->timezone);
