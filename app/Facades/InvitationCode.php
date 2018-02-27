<?php

namespace App\Facades;
use App\InvitationCodeGenerator;
use Illuminate\Support\Facades\Facade;

/**
 * Created by PhpStorm.
 * User: quim
 * Date: 23/02/18
 * Time: 16:54
 */

class InvitationCode extends Facade
{

    protected static function getFacadeAccessor()
    {
        return InvitationCodeGenerator::class;
    }

}