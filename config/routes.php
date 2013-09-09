<?php

Map::get('/', "pages#welcome");
Map::get('/welcome', "pages#welcome");
Map::get('/help', "pages#help");
Map::get('/about', "pages#about");
Map::get('/show', "pages#show");

Map::get('/posts', "posts#index");
Map::get('/posts/neo', "posts#neo");
Map::post('/posts', "posts#create");
Map::get('/posts/:id/edit', "posts#edit");
Map::get('/posts/:id', "posts#show");
Map::delete('/posts/:id', "posts#destroy");
Map::put('/posts/:id', "posts#update");

