<?php

namespace Renatoxm\LaravelVonageDlrWebhooks\Events;

class LaravelVonageDlrWebhooksCalled
{
    public $err_code;
    public $message_timestamp;
    public $message_id;
    public $msisdn;
    public $network_code;
    public $price;
    public $scts;
    public $status;
    public $to;

    public function __construct($err_code, $message_timestamp, $message_id, $msisdn, $network_code, $price, $scts, $status, $to)
    {
        $this->err_code = $err_code;
        $this->message_timestamp = $message_timestamp;
        $this->message_id = $message_id;
        $this->msisdn = $msisdn;
        $this->network_code = $network_code;
        $this->price = $price;
        $this->scts = $scts;
        $this->status = $status;
        $this->to = $to;
    }
}
