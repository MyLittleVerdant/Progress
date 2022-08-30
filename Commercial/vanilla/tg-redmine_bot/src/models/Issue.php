<?php

namespace TgRedmine\models;

use TgRedmine\helpers\Connection;
use TgRedmine\helpers\Redmine;

class Issue
{
    private function issuesWithParams($params)
    {
        if (!isset($params['status_id'])) {
            $params['status_id'] = '*';
        }

        $redmine = Redmine::getInstance()->getClient();
        $issues = [];
        $projects = [];
        $issuesResponse = $redmine->getApi('issue')->all($params);

        $checklists = (new Checklist())->getByIssue();

        if ($issuesResponse['total_count'] > $issuesResponse['limit']) {
            $issuesResponse = $redmine->getApi('issue')->all([
                'status_id' => '*',
                'limit' => $issuesResponse['total_count']
            ]);
        }

        $projectsResponse = (new Project())->all();
        foreach ($projectsResponse as $id => $project) {
            $projects[$id] = $project['name'];
        }
        foreach ($issuesResponse['issues'] as $issue) {
            $issues[$issue['id']] = [
                'project_id' => $issue['project']['id'],
                'project' => $projects[$issue['project']['id']],
                'name' => $issue['subject'],
                'cof' => $issue['custom_fields']['2']['value'],
                'prev_hours' => $issue['custom_fields']['3']['value'],
                'estimated_hours' => $issue['estimated_hours'] ?? false,
                'checklist' => isset($checklists[$issue['id']]) ? $checklists[$issue['id']] : [],
                'author' => $issue["author"],
                'assigned_to' => $issue["assigned_to"] ?? null,
                'start_date' => $issue["start_date"],
                'due_date' => $issue["due_date"] ?? null,
                'status' => $issue["status"],
            ];
        }
        return $issues;
    }

    public function issues()
    {
        $redmine = Redmine::getInstance()->getClient();
        $issues = [];
        $projects = [];
        $issuesResponse = $redmine->getApi('issue')->all([
            'status_id' => '*'
        ]);

        $checklists = (new Checklist())->getByIssue();

        if ($issuesResponse['total_count'] > $issuesResponse['limit']) {
            $issuesResponse = $redmine->getApi('issue')->all([
                'status_id' => '*',
                'limit' => $issuesResponse['total_count']
            ]);
        }

        $projectsResponse = (new Project())->all();
        foreach ($projectsResponse as $id => $project) {
            $projects[$id] = $project['name'];
        }
        foreach ($issuesResponse['issues'] as $issue) {
            $issues[$issue['id']] = [
                'project_id' => $issue['project']['id'],
                'project' => $projects[$issue['project']['id']],
                'name' => $issue['subject'],
                'cof' => $issue['custom_fields']['2']['value'],
                'prev_hours' => $issue['custom_fields']['3']['value'],
                'estimated_hours' => $issue['estimated_hours'] ?? false,
                'checklist' => isset($checklists[$issue['id']]) ? $checklists[$issue['id']] : [],
                'author' => $issue["author"],
                'assigned_to' => $issue["assigned_to"] ?? null,
                'start_date' => $issue["start_date"],
                'due_date' => $issue["due_date"] ?? null,
            ];
        }
        return $issues;
    }

    public function getIssuesByAuthor($authorID)
    {
        $params = [
            'author_id' => $authorID,
        ];
        return $this->issuesWithParams($params);
    }

    public function issuesById($id)
    {
        $redmine = Redmine::getInstance()->getClient();
        $issues = [];
        $projects = [];
        $issuesResponse = $redmine->getApi('issue')->all([
            'issue_id' => implode(',', $id),
            'status_id' => '*',
        ]);
        $checklists = (new Checklist())->getByIssue();

        if ($issuesResponse['total_count'] > $issuesResponse['limit']) {
            $issuesResponse = $redmine->getApi('issue')->all([
                'issue_id' => implode(',', $id),
                'status_id' => '*',
                'limit' => $issuesResponse['total_count']
            ]);
        }

        $projectsResponse = (new Project())->all();
        foreach ($projectsResponse as $id => $project) {
            $projects[$id] = $project['name'];
        }

        foreach ($issuesResponse['issues'] as $issue) {
            $issues[$issue['id']] = [
                'project_id' => $issue['project']['id'],
                'project' => $projects[$issue['project']['id']],
                'name' => $issue['subject'],
                'cof' => $issue['custom_fields']['2']['value'],
                'prev_hours' => $issue['custom_fields']['3']['value'],
                'estimated_hours' => $issue['estimated_hours'] ?? false,
                'checklist' => isset($checklists[$issue['id']]) ? $checklists[$issue['id']] : [],
                'author' => $issue["author"],
                'assigned_to' => $issue["assigned_to"] ?? null,
                'start_date' => $issue["start_date"],
                'due_date' => $issue["due_date"] ?? null,
            ];
        }

        return $issues;

    }
}