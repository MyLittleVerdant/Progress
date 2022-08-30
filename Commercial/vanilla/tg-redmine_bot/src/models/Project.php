<?php

namespace TgRedmine\models;

use TgRedmine\helpers\Connection;
use TgRedmine\helpers\Redmine;

class Project
{
    public function all()
    {
        $redmine = Redmine::getInstance()->getClient();
        $projects = [];
        $projectsResponse = $redmine->getApi('project')->all();
        if ($projectsResponse['total_count'] > $projectsResponse['limit']) {
            $projectsResponse = $redmine->getApi('project')->all([
                'limit' => $projectsResponse['total_count']
            ]);
        }
        foreach ($projectsResponse['projects'] as $project) {
            $projects[$project['id']] = [
                'name' => $project['name'],
                'identifier' => $project['identifier'],
                'parent' => $project['parent'] ?? null,
            ];
        }
        return $projects;
    }
}