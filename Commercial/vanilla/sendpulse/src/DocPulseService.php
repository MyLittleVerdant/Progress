<?php

namespace pulse;

use Exception;

class DocPulseService
{
    private $apiUrl = 'https://api.sendpulse.com';
    private $token;
    private $id;
    private $secret;


    public function __construct($id, $secret)
    {
        $this->id = $id;
        $this->secret = $secret;
        $this->token = $this->getToken();
    }

    private function getToken(): string
    {
        $data = array(
            'grant_type' => 'client_credentials',
            'client_id' => $this->id,
            'client_secret' => $this->secret,
        );

        $requestResult = $this->sendRequest('oauth/access_token', 'POST', $data, false);

        if ($requestResult['http_code'] !== 200) {
            throw new Exception('Could not connect to api, check your ID and SECRET');
        }

        return $requestResult['data']['access_token'];
    }

    protected function sendRequest($path, $method = 'GET', $data = array(), $useToken = true): array
    {
        $url = $this->apiUrl . '/' . $path;
        $method = strtoupper($method);
        $curl = curl_init();

        if ($useToken && !empty($this->token)) {
            $headers = array('Authorization: Bearer ' . $this->token, 'Expect:');
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, count($data));
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            default:
                if (!empty($data)) {
                    $url .= '?' . http_build_query($data);
                }
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 300);
        curl_setopt($curl, CURLOPT_TIMEOUT, 300);

        $response = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headerCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $responseBody = substr($response, $header_size);
        $responseHeaders = substr($response, 0, $header_size);
        $ip = curl_getinfo($curl, CURLINFO_PRIMARY_IP);
        $curlErrors = curl_error($curl);

        curl_close($curl);

        if ($headerCode === 401) {
            throw new Exception("Your access key's lifetime has expired");
        }
        return [
            'data' => json_decode($responseBody,true),
            'http_code' => $headerCode,
            'headers' => $responseHeaders,
            'ip' => $ip,
            'curlErrors' => $curlErrors,
            'method' => $method . ':' . $url,
            'timestamp' => date('Y-m-d h:i:sP')
        ];
    }

    public function addLead($bookID, $emails): array
    {
        if (empty($bookID) || empty($emails)) {
            throw new Exception("Empty book id or emails");
        }
        if (!$this->checkCURL()) {
            throw new Exception("Couldn't find CURL extension");
        }

        $this->prepareData($emails);

        $data = array(
            'emails' => json_encode($emails),
        );

        return $this->sendRequest('addressbooks/' . $bookID . '/emails', 'POST', $data);
    }

    private function uniPhone($phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    private function uniMail($phone): string
    {
        return 'empty' . $phone . '@mail.ru';
    }

    private function prepareData(&$emails)
    {
        foreach ($emails as &$lead) {
            $lead['variables']['phone'] = $this->uniPhone($lead['variables']['phone']);
            if (empty($lead['email'])) {
                $lead['email'] = $this->uniMail($lead['variables']['phone']);
            }
        }
    }

    private function checkCURL(): bool
    {
        return in_array("curl", get_loaded_extensions());
    }
}
