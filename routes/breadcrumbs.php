<?php

use App\Models\User;
use App\Models\Bulletin;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

//raiz
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Área de Trabalho', route('dashboard'));
});

//users
Breadcrumbs::for('users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Lista de Usuários', route('users.index'));
});

Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('users.index');
    $trail->push('Criando novo Usuário', route('users.create'));
});

//aqui passa parâmetro
Breadcrumbs::for('users.edit', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users.index');
    $trail->push('Editando Usuário: '.$user->name, route('users.edit',$user->id));
});

//boletins
Breadcrumbs::for('bulletins.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Lista de Boletins', route('bulletins.index'));
});

Breadcrumbs::for('bulletins.create', function (BreadcrumbTrail $trail) {
    $trail->parent('bulletins.index');
    $trail->push('Criando novo Boletim', route('bulletins.create'));
});

//aqui passa parâmetro
Breadcrumbs::for('bulletins.edit', function (BreadcrumbTrail $trail, Bulletin $bulletin) {
    $trail->parent('bulletins.index');
    $trail->push('Editando Boletim: '.$bulletin->name_of_file, route('bulletins.edit',$bulletin->id));
});