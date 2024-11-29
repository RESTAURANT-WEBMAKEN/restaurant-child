<?php

namespace App\Utils\Autoload;

// Use the Eloquent model
use App\Models\MetaData;

// Fetch all records from the 'rest' table
global $metadata;
global $mainpg;
global $pgtitle;
global $pgdesc;
global $pgkeyword;
global $review;
global $revtitle;
global $revdesc;
global $revkeyword;
global $reserv;
global $restitle;
global $resdesc;
global $reskeyword;
global $menuyn;


global $takeyn;
global $tmentitle;
global $tmendesc;
global $tmenkeyword;

global $menupg;
global $mentitle;
global $mendesc;
global $menkeyword;
global $orderyn;
global $orderpg;
global $ordtitle;
global $orddesc;
global $ordkeyword;
global $reserveyn;
global $timezone;

$metadata = MetaData::first();


$mainpg = $metadata->mainpg;
$pgtitle = $metadata->pgtitle;
$pgdesc = $metadata->pgdesc;
$pgkeyword = $metadata->pgkeyword;
$review = $metadata->review;
$revtitle = $metadata->revtitle;
$revdesc = $metadata->revdesc;
$revkeyword = $metadata->revkeyword;
$reserv = $metadata->reserv;
$restitle = $metadata->restitle;
$resdesc = $metadata->resdesc;
$reskeyword = $metadata->reskeyword;
$menuyn = $metadata->menuyn;


$takeyn = $metadata->takeyn;
$tmentitle = $metadata->tmentitle;
$tmendesc = $metadata->tmendesc;
$tmenkeyword = $metadata->tmenkeyword;

$menupg = $metadata->menupg;
$mentitle = $metadata->mentitle;
$mendesc = $metadata->mendesc;
$menkeyword = $metadata->menkeyword;
$orderyn = $metadata->orderyn;
$orderpg = $metadata->orderpg;
$ordtitle = $metadata->ordtitle;
$orddesc = $metadata->orddesc;
$ordkeyword = $metadata->ordkeyword;
$reserveyn = $metadata->reserveyn;
