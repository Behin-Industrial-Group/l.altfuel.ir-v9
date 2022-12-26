<?php 

namespace App\Traits;

trait reCAPTCHA
{
    private function checkRecaptcha($g_recaptcha_response)
    {
        if(isset($g_recaptcha_response) && !empty($g_recaptcha_response)):
        //your site secret key
        $secret = '6Le-1VsUAAAAAD0gAsN9YJY7ab1mxvmU_1wPFv1k';
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$g_recaptcha_response);
        $responseData = json_decode($verifyResponse);
        if($responseData->success):
            
            return true;
        else:
            return false;
        endif;
    else:
        return false;
    endif;    
    }
}