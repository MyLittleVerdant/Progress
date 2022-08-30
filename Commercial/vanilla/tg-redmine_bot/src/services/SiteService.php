<?php

namespace TgRedmine\services;

use DateTime;
use TgRedmine\models\SiteFall;

class SiteService
{
    public static function check()
    {

        $acceptStatus = [0, 200, 201, 202, 300, 301, 302];
        $notifySites = [];
        $uppedSites = [];
        $oldNotWorkSites = self::getAllValue();

        $siteFalls = new SiteFall();


        foreach ($oldNotWorkSites as $key => $site) {
            $url = $key;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT,
                'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CERTINFO, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
            $headers = [];
            array_push($headers, 'Content-Type: text/xml;charset=UTF-8');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_exec($ch);
            $data = curl_getinfo($ch);
            if (!in_array($data['http_code'], $acceptStatus)) {
                $oldValue = $site;
                $fallDate = strtotime($oldValue['last_fall']);
                $date = time();

                if ($oldValue['current_status'] == 1) {
                    $siteFalls->update([
                        'url' => $url,
                        'status' => 0
                    ]);

                    foreach ($site['responsible'] as $userRedmineId) {
                        ViolationService::addViolation($userRedmineId);
                    }

                    $notifySites[$url] = [
                        'url' => $url,
                        'code' => $data['http_code'],
                        'date' => date('Y-m-d H:i:s', strtotime('now'))
                    ];
                } else {
                    if ($date - $fallDate < 1140) {
                        $notifySites[$url] = [
                            'url' => $url,
                            'code' => $data['http_code'],
                            'date' => $oldValue['last_fall']
                        ];
                    }
                }

            } else {
                $oldValue = $site;
                if ($oldValue['current_status'] == 0) {
                    $uppedSites[$url] = [
                        'url' => $url,
                        'code' => 200,
                        'date' => date('Y-m-d H:i:s')
                    ];

                    $siteFalls->update([
                        'url' => $url,
                        'status' => 1
                    ]);
                }
            }
        }

        return ['notify' => $notifySites, 'upped' => $uppedSites];
    }

    private static function getOldValue()
    {
        $siteFalls = new SiteFall();
        $sites = $siteFalls->falls();
        return array_combine(array_column($sites, 'url'), $sites);
    }

    private static function getAllValue()
    {
        $siteFalls = new SiteFall();
        $sites = $siteFalls->all();
        return array_combine(array_column($sites, 'url'), $sites);
    }

    public static function sitesStatics()
    {
        $workStatus = self::getAllValue();

        $sites = [];

        foreach ($workStatus as $url => $status) {
            $site = [
                'name' => $url,
                'state' => $status['current_status'] ? 'normal' : 'down',
                'last_fall' => $status['last_fall'],
                'hosting' => $status['hosting_date'],
                'ssl' => $status['ssl_date'],
                'responsible' => $status['responsible']
            ];
            $sites[] = $site;
        }

        return $sites;
    }

    /**
     * Устанавливает даты оплаты домена и SSL для всех сайтов
     * @return void
     */
    public static function SSLnHosting()
    {
        $domainStatus = DomainService::timeList();
        $sslStatus = DomainService::timeList();
        $sitesService = new SiteFall();
        foreach ($sitesService->all() as $site) {
            if (!empty($domainStatus[$site['url']]['date']) && !empty($sslStatus[$site['url']]['date'])) {
                $sitesService->setSSLnHosting([
                    'url' => $site['url'],
                    'hosting' => $domainStatus[$site['url']]['date'],
                    'ssl' => $sslStatus[$site['url']]['date'],
                ]);
            }

        }
    }

    public static function lastFall()
    {
        return (new SiteFall())->getLastFall()[0];
    }
}