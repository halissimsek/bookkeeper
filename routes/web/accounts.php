<?php

Route::resource('accounts', 'AccountsController', ['names' => [
    'index'   => 'bookkeeper.accounts.index',
    'show'    => 'bookkeeper.accounts.show',
    'create'  => 'bookkeeper.accounts.create',
    'store'   => 'bookkeeper.accounts.store',
    'edit'    => 'bookkeeper.accounts.edit',
    'update'  => 'bookkeeper.accounts.update',
    'destroy' => 'bookkeeper.accounts.destroy',
]]);

Route::get('accounts/search', [
    'uses' => 'AccountsController@search',
    'as'   => 'bookkeeper.accounts.search']);
