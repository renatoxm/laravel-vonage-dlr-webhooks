<?php

namespace Renatoxm\LaravelVonageDlrWebhooks\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Renatoxm\LaravelVonageDlrWebhooks\Events\LaravelVonageDlrWebhooksCalled;

class LaravelVonageDlrWebhooksController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {

        $model = config('laravel-vonage-dlr-webhooks.log.model');

        $vonageWebhookData['err_code'] = $request->input('err-code');
        $vonageWebhookData['message_timestamp'] = $request->input('message-timestamp');
        $vonageWebhookData['message_id'] = $request->input('messageId');
        $vonageWebhookData['msisdn'] = $request->input('msisdn');
        $vonageWebhookData['network_code'] = $request->input('network-code');
        $vonageWebhookData['price'] = $request->input('price');
        $vonageWebhookData['scts'] = $request->input('scts');
        $vonageWebhookData['status'] = $request->input('status');
        $vonageWebhookData['to'] = $request->input('to');

        $vonageWebhook = $model::createOrNewFromPayload($vonageWebhookData);

        tap(
            new LaravelVonageDlrWebhooksCalled(
                $vonageWebhook->err_code,
                $vonageWebhook->message_timestamp,
                $vonageWebhook->message_id,
                $vonageWebhook->msisdn,
                $vonageWebhook->network_code,
                $vonageWebhook->price,
                $vonageWebhook->scts,
                $vonageWebhook->status,
                $vonageWebhook->to
            ),
            function ($event) use ($vonageWebhook) {
                event($event);
                event("webhook.vonage: {$vonageWebhook->status}", $event);

                if ($dispatchEvent = config("laravel-vonage-dlr-webhooks.events.{$vonageWebhook->status}")) {
                    event(new $dispatchEvent($event));
                }
            }
        );

        return response()->json()->setStatusCode(204);
    }
}
