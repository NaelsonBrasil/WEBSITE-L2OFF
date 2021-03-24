<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paysecurity extends Donate
{

    function __construct()
    {
        parent::__construct();
    }

    public static function initializePaySecurity($referCode,$id,$nameProduct,$amount,$price,$redirectUrl,$notificationUrl){

        $paymentRequest = new PagSeguroPaymentRequest();  

        $paymentRequest->addItem($id, $nameProduct, $amount, $price);
        
        global $iniShop;
        $iniShop['Currency'];
        $paymentRequest->setCurrency($iniShop['Currency']);
        
        $paymentRequest->setReference($referCode);
        
        $paymentRequest->setRedirectUrl($redirectUrl);
        $paymentRequest->addParameter('notificationURL', $notificationUrl);
            
        try {  
        
            $credentials = PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()  
            $checkoutUrl = $paymentRequest->register($credentials);  
            header('Location:' .$checkoutUrl);
        } catch (PagSeguroServiceException $e) { die($e->getMessage()); }
    }

}

