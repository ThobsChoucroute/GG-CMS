<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['json.response']], function () {
    /*
    |--------------------------------------------------------------------------
    | PRIVATE Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:api')->group(function() {
        // Auth
        Route::get('/user', 'AuthController@user')->name('users.show');
        Route::get('/logout', 'AuthController@logout')->name('logout');
        
        // Games
        Route::resource('games', 'GameController')->only(['store', 'update', 'destroy']);
        
        // Ranks
        Route::post('games/{game}/ranks', 'GameController@addRank')->name('games.ranks.store');
        Route::put('games/{game}/ranks/{rank}', 'GameController@updateRank')->name('games.ranks.update');
        Route::delete('games/{game}/ranks/{rank}', 'GameController@deleteRank')->name('games.ranks.store');
        
        // Players
        Route::resource('players', 'PlayerController')->only(['store', 'update', 'destroy']);
        Route::get('players/admins', 'PlayerController@admins')->name('players.admins');
        Route::post('players/{player}/game', 'PlayerController@addGame')->name('players.addGame');
        Route::delete('players/{player}/game', 'PlayerController@deleteGame')->name('players.deleteGame');
        Route::post('players/{player}/grantAdmin', 'PlayerController@grantAdmin')->name('players.admins.grant');
        Route::post('players/{player}/revokeAdmin', 'PlayerController@revokeAdmin')->name('players.admins.revoke');
        Route::post('players/{player}/visibility', 'PlayerController@changeVisibility')->name('players.admins.visibility');
        Route::post('players/regenerate/secret/keys', 'PlayerController@regenerateSecretKeys');
        
        // Teams
        Route::resource('teams', 'TeamController')->only(['store', 'update', 'destroy']);
        Route::post('teams/{team}/joinrequest/{player}', 'TeamController@joinRequest');
        Route::post('teams/{team}/joinrequest/{player}/{response}', 'TeamController@responseJoinRequest');
        Route::delete('teams/{team}/delete/player/{player}', 'TeamController@deletePlayer');
        
        // Tournaments
        Route::resource('tournaments', 'TournamentController')->only(['store', 'update', 'destroy']);
        Route::get('tournaments/payed/players', 'TournamentController@getPayedPlayers');
        Route::get('tournaments/{tournament}/cashprize/steps', 'TournamentController@getCashprizeSteps');
        
        // Posts
        Route::resource('posts', 'PostController')->only(['store', 'update', 'destroy']);
        
        // Rules
        Route::put('rules', 'RuleController@update')->name('rules.update');
        
        // Partners
        Route::resource('partners', 'PartnerController')->only(['store', 'update', 'destroy']);

        // Payment
        Route::get('payment/fail', 'PaymentController@failedPayment');
    });
    
    /*
    |--------------------------------------------------------------------------
    | PUBLIC Routes
    |--------------------------------------------------------------------------
    */
    
    // Auth
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/register', 'AuthController@register')->name('register');
    
    // Games
    Route::get('games/team', 'GameController@indexForTeam');
    Route::resource('games', 'GameController')->only(['index', 'show']);
    Route::get('games/{game}/players', 'GameController@players')->name('games.players');
    Route::get('games/{game}/teams', 'GameController@teams')->name('games.teams');
    Route::get('games/players/percentage', 'GameController@playersPercentage')->name('games.players.percentage');

    
    // Ranks
    Route::get('games/{game}/ranks', 'GameController@ranks')->name('games.ranks');
    Route::get('games/{game}/ranks/{rank}', 'GameController@showRank')->name('games.ranks.show');
    
    // Players
    Route::get('players/visible','PlayerController@index_site');
    Route::resource('players', 'PlayerController')->only(['index', 'show']);
    Route::get('players/{player}/games', 'PlayerController@games')->name('players.games');
    Route::get('players/{player}/teams', 'PlayerController@teams')->name('players.teams');
    Route::get('players/{player}/joinrequests', 'PlayerController@getPlayerJoinRequests');
    Route::get('players/count/new/players/month', 'PlayerController@countNewPlayersThisMonth');
    
    // Teams
    Route::get('teams/percentage', 'TeamController@teamPercentage')->name('teams.percentage');
    Route::resource('teams', 'TeamController')->only(['index', 'show']);
    Route::get('teams/{team}/players', 'TeamController@players')->name('teams.players');
    Route::get('teams/{team}/tournaments', 'TeamController@tournaments')->name('teams.tournaments');
    
    // Tournaments
    Route::get('tournaments/open', 'TournamentController@index_site');
    Route::get('tournaments/daysleft', 'TournamentController@tournamentsDaysLeft')->name('tournaments.daysleft');
    Route::resource('tournaments', 'TournamentController')->only(['index', 'show']);
    Route::get('tournaments/players/average', 'TournamentController@tournamentsAverageFilling')->name('tournaments.players.average');
    Route::get('tournaments/teams/percentage', 'TournamentController@teamsPercentage')->name('tournaments.teams.percentage');
    Route::get('tournaments/{tournament}/teams', 'TournamentController@teams')->name('tournaments.teams');
    Route::get('tournaments/{tournament}/players', 'TournamentController@players')->name('tournaments.players');
    Route::put('tournaments/{tournament}/register/players/{player}', 'TournamentController@registerPlayer');
    Route::put('tournaments/{tournament}/unregister/players/{player}', 'TournamentController@unregisterPlayer');
    Route::put('tournaments/{tournament}/register/teams/{team}', 'TournamentController@registerTeam');
    Route::put('tournaments/{tournament}/unregister/teams/{team}', 'TournamentController@unregisterTeam');
    
    // Posts
    Route::get('posts/public', 'PostController@index_site');
    Route::resource('posts', 'PostController')->only(['index', 'show']);
    
    // Rules
    Route::get('rules', 'RuleController@show')->name('rules.index');

    // Partners
    Route::resource('partners', 'PartnerController')->only(['index', 'show']);

    // Payment
    Route::get('payment/check/player/{player}', 'PaymentController@isPlayerPayed');
    Route::get('payment/{secretKey}/{tournament}', 'PaymentController@successfulPayment');
});
