<?php

Route::set('', function(){
    Index::CreateView('Index');
});

Route::set('login', function()
{
   Login::CreateView('Login');
});

Route::set('register', function()
{
    Register::CreateView('Register');
});

Route::set('statistics', function()
{
    Statistics::CreateView('Statistics');
});

Route::set('pagina_utilizator', function ()
{
   PaginaUtilizator::CreateView('PaginaUtilizator');
});

Route::set('pagina_artefact', function(){
    PaginaArtefact::CreateView('PaginaArtefact');
});

Route::set('pagina_alt_utilizator', function (){
   PaginaAltUtilizator::CreateView('PaginaAltUtilizator');
});

Route::set('index', function(){
    Index::CreateView('Index');
});

Route::set('editare_pg_utilizator', function (){
   EditarePaginaUtilizator::CreateView('EditarePaginaUtilizator');
});

Route::set('colectie_artefacte', function (){
   ColectieArtefacte::CreateView('ColectieArtefacte');
});

Route::set('adaugare_artefact', function(){
   AdaugareArtefact::CreateView('AdaugareArtefact');
});

