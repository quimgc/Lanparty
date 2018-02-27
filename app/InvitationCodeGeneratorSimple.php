<?php
/**
 * Created by PhpStorm.
 * User: quim
 * Date: 23/02/18
 * Time: 17:06
 */

namespace App;

use App\Invitation;
use Illuminate\Support\Facades\Hash;

class InvitationCodeGeneratorSimple implements InvitationCodeGenerator
{
    public function generate()
    {
//        $hash = Hash::make("hola");
//        dd($hash);
//        return 'INVITATIONCODE_123';



        return Hash::make("hola");

    }
}