<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Server;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use GuzzleHttp\Client;

class ServerController extends Controller
{
    /**
     * get servers
     *
     * @return JsonResponse
     */
    public function index()
    {
        $user = auth('api')->user();
        $free = $user->subscription->plan->is_free;
        $servers = Server::where('status',1);

        if ($user->subscription->isExpired() || $free == 1) {
            $servers->where('is_premium', 0);
        }
        $servers = $servers->get();
        return response200($servers, __('Successfully retrieved servers data'));
    }

    /**
     * get random server
     *
     * @return JsonResponse
     */
    public function random()
    {
        $server = Server::inRandomOrder()->where('status',1)->where('is_premium',0)->first();
        return response200($server, __('Successfully retrieved random server data'));
    }

    /**
     * post connect server
     * 
     * @return JsonResponse
     */
    public function connect(Server $server)
    {
        $user = auth('api')->user();

        // create client wg
        $wg_id = "wg" . $user->id;
        $url = "http://$server->ip_address:51821/api/wireguard/client";
        $data = [
            'name' => $wg_id
        ];
        $headers = [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ];
        $client = new Client();
        $response = $client->post($url, [
            'headers' => $headers,
            'json'    => $data,
        ]);
        $statusCode = $response->getStatusCode();

        $resp = [];
        if ($statusCode == 200) {
            // get client config
            $url = "http://$server->ip_address:51821/api/wireguard/client/$wg_id/configuration";
            $headers = [
                'Accept'       => 'text/plain'
            ];
            $client = new Client();
            $response = $client->get($url, [
                'headers' => $headers,
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode == 200) {
                $body = $response->getBody()->getContents();
                $resp['client_id'] = $wg_id;
                $resp['conf'] = $body;
            }
        }

        return response200($resp, __('Connection Success'));
    }

}
