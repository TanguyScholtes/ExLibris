<?php

return [
    //- Default page -
    'default' => 'GET/book/index', //done

    //- Users management -
    'user_connect' => 'GET/user/connect', //done
    'user_login' => 'POST/user/login',  //done
	'user_logout' => 'GET/user/logout', //done

    //- Books CRUD -
    //CREATE
    'create_book' => 'GET/book/create',
    'save_book' => 'POST/book/save',
    //READ
    'index_book' => 'GET/book/index', //done
    'view_book' => 'GET/book/view', //done
    //UPDATE
    'edit_book' => 'GET/book/edit',
    'update_book' => 'POST/book/update',
    //DELETE
    'delete_book' => 'GET/book/delete',
    'erase_book' => 'POST/book/erase',

    //- Authors CRUD -
    //CREATE
    'create_author' => 'GET/author/create',
    'save_author' => 'POST/author/save',
    //READ
    'index_author' => 'GET/author/index', //done
    'view_author' => 'GET/author/view', //done
    //UPDATE
    'edit_author' => 'GET/author/edit',
    'update_author' => 'POST/author/update',
    //DELETE
    'delete_author' => 'GET/author/delete',
    'erase_author' => 'POST/author/erase',

    //- Publishers CRUD -
    //CREATE
    'create_publisher' => 'GET/publisher/create',
    'save_publisher' => 'POST/publisher/save',
    //READ
    'index_publisher' => 'GET/publisher/index', //done
    'view_publisher' => 'GET/publisher/view', //done
    //UPDATE
    'edit_publisher' => 'GET/publisher/edit',
    'update_publisher' => 'POST/publisher/update',
    //DELETE
    'delete_publisher' => 'GET/publisher/delete',
    'erase_publisher' => 'POST/publisher/erase',

    //- Types CRUD -
    //CREATE
    'create_type' => 'GET/type/create',
    'save_type' => 'POST/type/save',
    //READ
    'index_type' => 'GET/type/index', //done
    'view_type' => 'GET/type/view', //done
    //UPDATE
    'edit_type' => 'GET/type/edit',
    'update_type' => 'POST/type/update',
    //DELETE
    'delete_type' => 'GET/type/delete',
    'erase_type' => 'POST/type/erase',
];
