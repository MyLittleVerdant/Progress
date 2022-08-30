<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('admin.index', function (BreadcrumbTrail $trail) {
    $trail->push('Главная', route('admin.index'));
});

/**
 * Новости
 */
Breadcrumbs::for('admin.news.index', function (BreadcrumbTrail $trail) {
    $trail->push('Новости', route('admin.news.index'));
});

Breadcrumbs::for('admin.news.edit', function (BreadcrumbTrail $trail, $news) {
    $trail->parent('admin.news.index');
    $trail->push('Редактирование', route('admin.news.edit', $news));
});

Breadcrumbs::for('admin.news.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.news.index');
    $trail->push('Создание', route('admin.news.create'));
});

/**
 * Команда
 */
Breadcrumbs::for('admin.team.index', function (BreadcrumbTrail $trail) {
    $trail->push('Команда', route('admin.team.index'));
});

Breadcrumbs::for('admin.team.edit', function (BreadcrumbTrail $trail, $member) {
    $trail->parent('admin.team.index');
    $trail->push('Редактирование', route('admin.team.edit', $member));
});

Breadcrumbs::for('admin.team.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.team.index');
    $trail->push('Создание', route('admin.team.create'));
});

/**
 * Клиенты
 */
Breadcrumbs::for('admin.clients.index', function (BreadcrumbTrail $trail) {
    $trail->push('Клиенты', route('admin.clients.index'));
});

Breadcrumbs::for('admin.clients.edit', function (BreadcrumbTrail $trail, $client) {
    $trail->parent('admin.clients.index');
    $trail->push('Редактирование', route('admin.clients.edit', $client));
});

Breadcrumbs::for('admin.clients.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.clients.index');
    $trail->push('Создание', route('admin.clients.create'));
});

/**
 * Контакты
 */
Breadcrumbs::for('admin.contacts.index', function (BreadcrumbTrail $trail) {
    $trail->push('Контакты', route('admin.clients.index'));
});

Breadcrumbs::for('admin.contacts.edit', function (BreadcrumbTrail $trail, $contact) {
    $trail->parent('admin.contacts.index');
    $trail->push('Редактирование', route('admin.contacts.edit', $contact));
});

Breadcrumbs::for('admin.contacts.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.contacts.index');
    $trail->push('Создание', route('admin.contacts.create'));
});

/**
 * Партнёры
 */
Breadcrumbs::for('admin.partners.index', function (BreadcrumbTrail $trail) {
    $trail->push('Партнёры', route('admin.partners.index'));
});

Breadcrumbs::for('admin.partners.edit', function (BreadcrumbTrail $trail, $contact) {
    $trail->parent('admin.partners.index');
    $trail->push('Редактирование', route('admin.partners.edit', $contact));
});

Breadcrumbs::for('admin.partners.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.partners.index');
    $trail->push('Создание', route('admin.partners.create'));
});

/**
 * Меценаты
 */
Breadcrumbs::for('admin.patronages.index', function (BreadcrumbTrail $trail) {
    $trail->push('Меценаты', route('admin.patronages.index'));
});

Breadcrumbs::for('admin.patronages.edit', function (BreadcrumbTrail $trail, $patronage) {
    $trail->parent('admin.patronages.index');
    $trail->push('Редактирование', route('admin.patronages.edit', $patronage));
});

Breadcrumbs::for('admin.patronages.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.patronages.index');
    $trail->push('Создание', route('admin.patronages.create'));
});

/**
 * Карьера
 */
Breadcrumbs::for('admin.careers.index', function (BreadcrumbTrail $trail) {
    $trail->push('Карьера', route('admin.careers.index'));
});

Breadcrumbs::for('admin.careers.values.edit', function (BreadcrumbTrail $trail, $value) {
    $trail->parent('admin.careers.index');
    $trail->push('Редактирование', route('admin.careers.values.edit', $value));
});

Breadcrumbs::for('admin.careers.values.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.careers.index');
    $trail->push('Создание', route('admin.careers.values.create'));
});

/**
 * О нас
 */
Breadcrumbs::for('admin.about.index', function (BreadcrumbTrail $trail) {
    $trail->push('О нас', route('admin.about.index'));
});

Breadcrumbs::for('admin.about.edit', function (BreadcrumbTrail $trail, $aboutBlock) {
    $trail->parent('admin.about.index');
    $trail->push('Редактирование', route('admin.about.edit', $aboutBlock));
});

Breadcrumbs::for('admin.about.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.about.index');
    $trail->push('Создание', route('admin.about.create'));
});


/**
 * Главная
 */
Breadcrumbs::for('admin.main.index', function (BreadcrumbTrail $trail) {
    $trail->push('Главная', route('admin.main.index'));
});

/**
 * Киты
 */
Breadcrumbs::for('admin.whales.index', function (BreadcrumbTrail $trail) {
    $trail->push('Каталог анимированных китов', route('admin.whales.index'));
});

Breadcrumbs::for('admin.whales.edit', function (BreadcrumbTrail $trail, $whale) {
    $trail->parent('admin.whales.index');
    $trail->push('Редактирование', route('admin.whales.edit', $whale));
});

Breadcrumbs::for('admin.whales.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.whales.index');
    $trail->push('Создание', route('admin.whales.create'));
});
