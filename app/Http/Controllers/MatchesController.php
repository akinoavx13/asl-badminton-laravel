<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests\MatchUpdateRequest;
use App\Match;
use App\Season;
use App\Team;
use App\Tournament;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MatchesController extends Controller
{
    public static function routes($router)
    {

        $router->pattern('match_id', '[0-9]+');

        $router->get('edit/{match_id}', [
            'uses' => 'MatchesController@edit',
            'as'   => 'match.edit',
        ]);

        $router->post('edit/{match_id}', [
            'uses' => 'MatchesController@update',
            'as'   => 'match.update',
        ]);

    }

    public function edit($match_id)
    {
        $match = Match::findOrFail($match_id);

        $matchSeries = $match->series()->first();

        if ($matchSeries != null) {
            $teams = [];

            $activeSeason = Season::active()->first();

            if ($match->next_match_winner_id != null && $match->team_number_winner != null) {
                $nextMatchWinner[$match->next_match_winner_id . '-' . $match->team_number_winner] = $matchSeries->name . ' , Match n° ' . $match->matches_number_in_table . ', Équipe n° ' . $match->team_number_winner;
            } else {
                $nextMatchWinner['none'] = 'Aucun';
            }

            if ($match->next_match_looser_id != null && $match->team_number_looser != null) {
                $nextMatchLooser[$match->next_match_looser_id . '-' . $match->team_number_looser] = $matchSeries->name . ' , Match n° ' . $match->matches_number_in_table . ', Équipe n° ' . $match->team_number_looser;
            } else {
                $nextMatchLooser['none'] = 'Aucun';
            }

            if ($activeSeason != null) {

                $tournament = Tournament::current($activeSeason->id)->first();

                if ($tournament != null) {
                    $series = $tournament->series()->where('series.category', $matchSeries->category)->get();
                    if (count($series) > 0) {
                        foreach ($series as $serie) {
                            $matches = $serie->matches()->get();
                            foreach ($matches as $m) {
                                foreach (['1', '2'] as $player) {
                                    $nextMatchLooser[$m->id . '-' . $player] = $serie->name . ' , Match n° ' . $m->matches_number_in_table . ', Équipe n° ' . $player;
                                    $nextMatchWinner[$m->id . '-' . $player] = $serie->name . ' , Match n° ' . $m->matches_number_in_table . ', Équipe n° ' . $player;
                                }
                            }
                        }
                    }
                }

                switch ($matchSeries->category) {
                    case 'S':
                        $simpleTeams = $this->listTeams('simple', $activeSeason->id);
                        $team = $this->getSimpleMatchTeam($match, $teams);

                        $teams['firstTeam'] = $team['firstTeam'];
                        if (!array_key_exists('none', $team['firstTeam'])) {
                            $teams['firstTeam'] += ['none' => 'Aucune équipe ...'];
                        }
                        $teams['firstTeam'] += $simpleTeams;

                        $teams['secondTeam'] = $team['secondTeam'];
                        if (!array_key_exists('none', $team['secondTeam'])) {
                            $teams['secondTeam'] += ['none' => 'Aucune équipe ...'];
                        }
                        $teams['secondTeam'] += $simpleTeams;

                        break;
                    case 'SH':
                        $simpleTeams = $this->listTeams('simple', $activeSeason->id, 'man');
                        $team = $this->getSimpleMatchTeam($match, $teams);
                        $teams['firstTeam'] = $team['firstTeam'];
                        $teams['firstTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['firstTeam'] += $simpleTeams;

                        $teams['secondTeam'] = $team['secondTeam'];
                        $teams['secondTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['secondTeam'] += $simpleTeams;
                        break;
                    case 'SD':
                        $simpleTeams = $this->listTeams('simple', $activeSeason->id, 'woman');
                        $team = $this->getSimpleMatchTeam($match, $teams);
                        $teams['firstTeam'] = $team['firstTeam'];
                        $teams['firstTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['firstTeam'] += $simpleTeams;

                        $teams['secondTeam'] = $team['secondTeam'];
                        $teams['secondTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['secondTeam'] += $simpleTeams;

                        break;
                    case 'D':
                        $doubleTeams = $this->listTeams('double', $activeSeason->id);
                        $team = $this->getDoubleOrMixteMatchTeam($match, $teams);
                        $teams['firstTeam'] = $team['firstTeam'];
                        $teams['firstTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['firstTeam'] += $doubleTeams;

                        $teams['secondTeam'] = $team['secondTeam'];
                        $teams['secondTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['secondTeam'] += $doubleTeams;
                        break;
                    case 'DH':
                        $doubleTeams = $this->listTeams('double', $activeSeason->id, 'man');
                        $team = $this->getDoubleOrMixteMatchTeam($match, $teams);
                        $teams['firstTeam'] = $team['firstTeam'];
                        $teams['firstTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['firstTeam'] += $doubleTeams;

                        $teams['secondTeam'] = $team['secondTeam'];
                        $teams['secondTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['secondTeam'] += $doubleTeams;
                        break;
                    case 'DD':
                        $doubleTeams = $this->listTeams('double', $activeSeason->id, 'woman');
                        $team = $this->getDoubleOrMixteMatchTeam($match, $teams);
                        $teams['firstTeam'] = $team['firstTeam'];
                        $teams['firstTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['firstTeam'] += $doubleTeams;

                        $teams['secondTeam'] = $team['secondTeam'];
                        $teams['secondTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['secondTeam'] += $doubleTeams;
                        break;
                    case 'M':
                        $mixteTeams = $this->listTeams('mixte', $activeSeason->id);
                        $team = $this->getDoubleOrMixteMatchTeam($match, $teams);
                        $teams['firstTeam'] = $team['firstTeam'];
                        $teams['firstTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['firstTeam'] += $mixteTeams;

                        $teams['secondTeam'] = $team['secondTeam'];
                        $teams['secondTeam'] += ['none' => 'Aucune équipe ...'];
                        $teams['secondTeam'] += $mixteTeams;
                        break;
                }

                return view('match.edit', compact('match', 'teams', 'nextMatchLooser', 'nextMatchWinner'));
            }
        }
        return redirect()->back()->with('error', 'Il faut une saison active et un tournoi !');

    }

    public function update(MatchUpdateRequest $request, $match_id)
    {
        $match = Match::findOrFail($match_id);

        $nextMatchWinnerId = null;
        $teamNumberWinner = null;
        if ($request->next_match_winner_id != 'none') {
            $infoNextMatchWinner = explode("-", $request->next_match_winner_id);
            $nextMatchWinnerId = $infoNextMatchWinner[0];
            $teamNumberWinner = $infoNextMatchWinner[1];
        }

        $nextMatchLooserId = null;
        $teamNumberLooser = null;
        if ($request->next_match_looser_id != 'none') {
            $infoNextMatchLooser = explode("-", $request->next_match_looser_id);
            $nextMatchLooserId = $infoNextMatchLooser[0];
            $teamNumberLooser = $infoNextMatchLooser[1];
        }

        $match->update([
            'matches_number_in_table' => $request->matches_number_in_table,
            'first_team_id'           => $request->first_team_id == 'none' ? null : $request->first_team_id,
            'second_team_id'          => $request->second_team_id == 'none' ? null : $request->second_team_id,
            'next_match_winner_id'    => $nextMatchWinnerId,
            'next_match_looser_id'    => $nextMatchLooserId,
            'team_number_winner'      => $teamNumberWinner,
            'team_number_looser'      => $teamNumberLooser,
        ]);

        return redirect()->route('tournament.index')->with('success', 'Le match a bien été modifié !');
    }

    private function getSimpleMatchTeam($match, $teams)
    {
        if ($match->first_team_id != null) {
            $team = User::select('users.name', 'users.forname', 'teams.id')
                ->join('players', 'players.user_id', '=', 'users.id')
                ->join('teams', 'teams.player_one', '=', 'players.id')
                ->where('teams.id', $match->first_team_id)
                ->first();
            if ($team != null) {
                $teams['firstTeam'] = [$match->first_team_id => Helpers::getInstance()->getTeamName($team->forname, $team->name)];
            } else {
                $teams['firstTeam'] = ['none' => 'Aucune équipe ...'];
            }
        } else {
            $teams['firstTeam'] = ['none' => 'Aucune équipe ...'];
        }

        if ($match->second_team_id != null) {
            $team = User::select('users.name', 'users.forname', 'teams.id')
                ->join('players', 'players.user_id', '=', 'users.id')
                ->join('teams', 'teams.player_one', '=', 'players.id')
                ->where('teams.id', $match->second_team_id)
                ->first();

            if ($team != null) {
                $teams['secondTeam'] = [$match->second_team_id => Helpers::getInstance()->getTeamName($team->forname, $team->name)];
            } else {
                $teams['secondTeam'] = ['none' => 'Aucune équipe ...'];
            }
        } else {
            $teams['secondTeam'] = ['none' => 'Aucune équipe ...'];
        }

        return $teams;
    }

    private function getDoubleOrMixteMatchTeam($match, $teams)
    {
        if ($match->first_team_id != null) {
            $team = Team::select('userOne.forname AS fornameOne',
                'userOne.name AS nameOne',
                'userTwo.forname AS fornameTwo',
                'userTwo.name AS nameTwo',
                'teams.id')
                ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
                ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
                ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
                ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
                ->where('teams.id', $match->first_team_id)
                ->first();
            if ($team != null) {
                $teams['firstTeam'] = [$match->first_team_id => Helpers::getInstance()->getTeamName($team->fornameOne, $team->nameOne,
                    $team->fornameTwo, $team->nameTwo)];
            } else {
                $teams['firstTeam'] = ['none' => 'Aucune équipe ...'];
            }
        } else {
            $teams['firstTeam'] = ['none' => 'Aucune équipe ...'];
        }

        if ($match->second_team_id != null) {
            $team = Team::select('userOne.forname AS fornameOne',
                'userOne.name AS nameOne',
                'userTwo.forname AS fornameTwo',
                'userTwo.name AS nameTwo',
                'teams.id')
                ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
                ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
                ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
                ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
                ->where('teams.id', $match->second_team_id)
                ->first();

            if ($team != null) {
                $teams['secondTeam'] = [$match->second_team_id => Helpers::getInstance()->getTeamName($team->fornameOne, $team->nameOne,
                    $team->fornameTwo, $team->nameTwo)];
            } else {
                $teams['secondTeam'] = ['none' => 'Aucune équipe ...'];
            }
        } else {
            $teams['secondTeam'] = ['none' => 'Aucune équipe ...'];
        }

        return $teams;
    }

    private function listTeams($type, $season_id, $gender = null)
    {
        $teams = [];
        $allTeams = null;

        if ($type === 'simple' && $gender == null) {
            $allTeams = Team::select('users.forname', 'users.name', 'teams.id')
                ->allSimpleTeamsNoGender($season_id)
                ->get();
        } elseif ($type === 'simple' && $gender != null) {
            $allTeams = Team::select('users.forname', 'users.name', 'teams.id')
                ->allSimpleTeams($gender, $season_id)
                ->get();
        } elseif ($type != 'simple' && $gender == null) {
            $allTeams = Team::select('userOne.forname AS fornameOne',
                'userOne.name AS nameOne',
                'userTwo.forname AS fornameTwo',
                'userTwo.name AS nameTwo',
                'teams.id')
                ->allDoubleOrMixteActiveTeamsNoGender($type, $season_id)
                ->get();
        } elseif ($type != 'simple' && $gender != null) {
            $allTeams = Team::select('userOne.forname AS fornameOne',
                'userOne.name AS nameOne',
                'userTwo.forname AS fornameTwo',
                'userTwo.name AS nameTwo',
                'teams.id')
                ->allDoubleOrMixteActiveTeams($type, $gender, $season_id)
                ->get();
        }

        if (count($allTeams) > 0) {
            foreach ($allTeams as $team) {
                if ($type === 'simple') {
                    $teams[$team->id] = Helpers::getInstance()->getTeamName($team->forname, $team->name);
                } else {
                    $teams[$team->id] = Helpers::getInstance()->getTeamName($team->fornameOne, $team->nameOne,
                        $team->fornameTwo, $team->nameTwo);
                }

            }
        }
        asort($teams);

        return $teams;
    }
}
