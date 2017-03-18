<?php

namespace App\Http\Controllers;

use App\Album;
use App\AppUser;
use App\AppUsersPasswordReset;
use App\CustomField;
use App\debugjob;
use App\following;
use App\Gallery;
use App\Games;
use App\Interval;
use App\Level;
use App\LevelSport;
use App\News;
use App\Notification;
use App\Opponent;
use App\Positions;
use App\pushqueue;
use App\RoleUser;
use App\RosterStaff;
use App\SchoolRecord;
use App\Score;
use App\SportsList;
use App\tempforbase64;
use App\UserArn;
use App\usernotification;
use Aws\Laravel\AwsServiceProvider;
use Aws\Sns\SnsClient;
use Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Mail;
use stdClass;
use App\Roster;
use App\Season;
use App\Social;
use App\Sponsor;
use App\Staff;
use App\Student;
use App\Photo;
use App\Ad;
use App\Company;
use App\Video;
use Illuminate\Http\Request;
use App\School;
use App\Sport;
use App\UserSport;
use DateTime;
use App\User;
use App\SportIcon;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Validator;
use Aws\Laravel\AwsFacade as AWS;
use App\Push;

class APIControllerxx extends Controller
{
    /**
     * @param Request $request
     * handle incoming urls and then call appropriate method
     */
    public function handle(Request $request)
    {

        //check the action in the url using query method
        $action = $request->input('action');


        //get the ids from the request query method
        $schoolId = $request->input('school_id');
        $apiKey = $request->input('api_key');
        $sponsorId = $request->input('sponsor_id');
        $seasonId = $request->input('season_id');
        $staffId = $request->input('staff_id');
        $levelId = $request->input('level_id');
        $sportId = $request->input('sport_id');
        $gameId = $request->input('game_id');
        $studentId = $request->input('student_id');
        $year = $request->input('yr');
        $newsId = $request->input('news_id');
        $socialName = $request->input('social_name');
        $albumId = $request->input('album_id');
        $gameData = $request->input('gameData');
        $deviceId = $request->input('device_id');
        $deviceToken = $request->input('device_token');
        $userId = $request->input('user_id');
        $favourites = $request->input('sports_ids');
        $limit = $request->input('limit');

        //create the admin user for requests
        // other then api calls only one time on '/'
        if (!($request->input('action'))) {
            return redirect('/home');
        } //call the related api method to return the data
        else {
            if ($action == 'deviceRegister') {
                return $this->registerDevice($request);
            }
            if ($action == 'getAppData') {
                return $this->getAppData($schoolId, $apiKey);
            }
            if ($action == 'truncateScores') {
                return $this->truncateScores($request);
            }

            if ($action == 'getSponsorList') {
                return $this->getSponsorList($schoolId, $apiKey);
            }

            if ($action == 'getSponsor') {
                return $this->getSponsor($schoolId, $sponsorId);
            }

            if ($action == 'getLivestream') {
                return $this->getLivestream($schoolId);
            }


            if ($action == 'getStaffList') {
                return $this->getStaffList($schoolId, $seasonId);
            }

            if ($action == 'getStaff') {
                return $this->getStaff($schoolId, $staffId);
            }

            if ($action == 'getSchool') {
                return $this->getSchool($schoolId);
            }
            if ($action == 'getSport') {
                return $this->getSport($schoolId, $sportId);
            }
            if ($action == 'getSchedule') {
                return $this->getSchedule($schoolId, $sportId, $levelId, $seasonId);
            }

            if ($action == 'getGame') {
                return $this->getGame($request, $schoolId, $sportId, $levelId, $seasonId, $gameId, $gameData, $userId);
            }

            if ($action == 'getRosterList') {
                return $this->getRosterList($schoolId);
            }

            if ($action == 'getRoster') {
                return $this->getRoster($schoolId, $sportId, $levelId, $seasonId);
            }

            if ($action == 'getStudent') {
                return $this->getStudent($schoolId, $studentId, $sportId, $levelId);
            }

            if ($action == 'getNewsList') {
                return $this->getNewsList($schoolId, $sportId, $seasonId);
            }
            if ($action == 'getTopNews') {
                return $this->getTopNews($schoolId, $sportId, $limit);
            }

            if ($action == 'getNews') {
                return $this->getNews($schoolId, $newsId, $sportId);
            }

            if ($action == 'getMedia') {
                return $this->getMedia($schoolId, $sportId, $seasonId, $studentId);
            }


            if ($action == 'getMedia2') {
                return $this->getMedia2($schoolId, $sportId, $seasonId, $studentId);
            }

            if ($action == 'getAlbumList') {
                return $this->getAlbumList($schoolId, $sportId, $seasonId);
            }

            if ($action == 'getAlbum') {
                return $this->getAlbum($schoolId, $sportId, $seasonId, $albumId);
            }

            if ($action == 'getAboutCompany') {
                return $this->getAboutCompany($schoolId);
            }

            if ($action == 'getSocial') {
                return $this->getSocial($request);
            }
            if ($action == 'editProfile') {
                return $this->editProfile($request);
            }

            if ($action == 'signUp') {
                return $this->signUp($request);
            }
            if ($action == 'signIn') {
                return $this->signIn($request);
            }
            if ($action == 'favourite') {
                return $this->favourite($request);
            }
            if ($action == 'unFavourite') {
                return $this->unFavourite($request);
            }
            if ($action == 'settings') {
                return $this->settings($request);
            }
            if ($action == 'getScoreData') {
                return $this->getScoreData($request);
            }
            if ($action == 'followGame') {
                return $this->followGame($request);
            }
            if ($action == 'resetPassword') {
                return $this->resetPassword($request);
            }
            if ($action == 'saveDeviceToken') {
                return $this->saveDeviceToken($request);
            }
            if ($action == 'notification') {
                return $this->notification($request);
            }
            if ($action == 'getList') {
                return $this->getList($request);
            }
            if ($action == 'startGame') {
                return $this->startGame($request);
            }
            if ($action == 'updateScore') {
                return $this->updateScore($request);
            }
            if ($action == 'endRound') {
                return $this->endRound($request);
            }
            if ($action == 'boxScore') {
                return $this->boxScore($request);
            }

            if ($action == 'updateDeviceToken') {
                return $this->updateDeviceToken($request);
            }
            if ($action == 'testSns') {
                return $this->testSns($request);
            }
            if ($action == 'sandbox') {
                return $this->sandbox($request);
            }
            if ($action == 'updateFavouriteList') {
                return $this->updateFavouriteList($request);
            }

        }
    }


    /**
     * get app data api
     * @param $schoolId , $apiKey
     * @return Response
     */
    public function getAppData($schoolId, $apiKey)
    {

        $schools = School::
        with([
            'sport_list' => function ($q) {
                $q->select('sports.sport_name as sport_name', 'sports.id as sport_id', 'school_id', 'icon_url as path')
                    ->orderBy('sort_order', 'ASC');;
            },

        ])->select('app_name', 'id as school_id', 'name as school_name', 'school_logo',
            'school_color', 'school_color2', 'school_color3', 'id', 'has_livestream', 'sponsorButtonName')
            ->where('schools.id', $schoolId)
            ->first();

        //Add favourite list which is an array of favourite sports id
        $schools['favourite_list'] = $schools->favourite_sports->lists('sport_id');

        //Unset favourite_sports as it's added automatically by eager loading
        unset($schools['favourite_sports']);

        return response()->json($schools);
    }

    /**
     * returns the sponsors list
     * @param $schoolId
     * @param $apiKey
     */
    public function getSponsorList($schoolId, $apiKey)
    {

        $sponsors = Sponsor::where('school_id', $schoolId)
            ->select('id as sponsor_id', 'name as sponsor_name', 'logo as sponsor_logo', 'color as sponsor_color',
                'color2 as sponsor_color2', 'color3 as sponsor_color3')->orderBy('order', 'ASC')
            ->get();
        $sponsors->sponsor_color = '#000000';
        $sponsors->sponsor_color2 = '#000000';
        $sponsors->sponsor_color3 = '#000000';

        $arr = array('sponsor_list' => ($sponsors));
        return response()->json($arr);
    }

    public function getSponsor($schoolId, $sponsorId)
    {

        $sponsor = Sponsor::select('id', 'id as sponsor_id', 'name as sponsor_name', 'logo as sponsor_logo', 'logo2 as sponsor_logo2',
            'color as sponsor_color', 'color2 as sponsor_color2', 'color3 as sponsor_color3',
            'tagline as sponsor_tagline', 'bio as sponsor_bio', 'photo as sponsor_photo',
            'video as sponsor_video', 'address as sponsor_address', 'email as sponsor_address',
            'url as sponsor_url', 'email as sponsor_email', 'phone as sponsor_phone',
            'facebook as facebook_url', 'instagram as instagram_url', 'twitter as twitter_url', 'video_cover', 'video_title')
            ->where('school_id', $schoolId)->where('id', $sponsorId)
            ->OrderBy('order', 'asc')
            ->first();
        if ($sponsor->sponsor_video == '') $sponsor->sponsor_video = null;
        return response()->json($sponsor);
    }


    /**
     * returns the livestream url for school
     * @param $schoolId
     * @return mixed
     */
    public function getLivestream($schoolId)
    {
        $school = School::select('has_livestream', 'livestream_url')->where('id', $schoolId)->first();
        $arr = array();
        if ($school->has_livestream == 1) {
            $arr['liveStreamUrl'] = $school->livestream_url;
            $arr['liveStreamDesc'] = 'Generic Description for now';
            $arr['liveStreamNextDate'] = '01/31/2017';
        } else {
            $arr = null;
        }
        return response()->json($arr);
    }

    public function getSport($schoolId, $sportId)
    {

        $sport = Sport::  with([
            'sport_levels' => function ($q) {
                $q->select('levels.id as level_id', 'levels.name as level_name')
                    ->orderBy('sort_order', 'ASC')
                    ->get();
            },

            'season_list' => function ($q) {
                $q->select('seasons.id as season_id', 'seasons.name as season_name', 'seasons.id')
                    ->get();
            },

        ])
            ->
            select('sports.id as sport_id', 'sports.id', 'sports.sport_name as sport_name',
                'season_id', 'sports.photo as sport_photo', 'sport_name as sport_name', 'icon_url as icon_url')
            ->where('school_id', $schoolId)
            ->where('sports.id', $sportId)->first();


        $latest_news = News::select('news.id', 'news.id as news_id', 'news.title as news_title', 'news.intro as news_teaser',
            'news.image as news_photo', 'news.link as news_url', 'news_date')
            ->join('news_sport', 'news_sport.news_id', '=', 'news.id')
            ->where('news_sport.sport_id', $sportId)
            ->orderBy('news_date', 'DESC')
            ->first();


        $lastGame = Games::select('games.id as game_id', 'game_date', DB::raw('LEFT(DATE_FORMAT(game_date,\'%W\'), 3) as day_of_week'),
            'result as game_result', 'home_away as game_vs_at',
            DB::raw('case when opponents_id = 0 then game_tournaments.meet_name else schools.name end as opp_name'),
            DB::raw('case when opponents_score > our_score then opponents_score when opponents_score = our_score then our_score else our_score end as school_score '),
            DB::raw('case when opponents_score < our_score then opponents_score when opponents_score = our_score then opponents_score else our_score end as opp_score'),
            'schools.short_name as opp_nick',
            DB::raw('case when opponents_id = 0 then game_tournaments.logo else schools.school_logo end as opp_logo'),
            'rosters.level_id')
            ->leftjoin('game_tournaments', 'games.id', '=', 'game_tournaments.games_id')
            ->leftjoin('schools', 'games.opponents_id', '=', 'schools.id')
            ->leftjoin('rosters', 'rosters.id', '=', 'games.roster_id')
            ->leftjoin('sports', 'sports.id', '=', 'rosters.sport_id')
            ->where('result', '<>', '')
            ->wherenotnull('result')
            ->where('sports.id', $sportId)
            ->where('sports.school_id', $schoolId)
            ->where('rosters.level_id', '=', '1')
            ->whereDate('game_date', '<', Carbon::now()->toDateString())
            ->orderBy('game_date', 'DESC')
            ->first();

        $record = '0-0';
        if ($lastGame) {
            $record = SchoolRecord::select('record')->where('game_id', '=', $lastGame->game_id)->first();
            $record = $record->record;
        }


        $nextGame = Games::select('games.id as game_id', 'our_score as school_score',
            'home_away as game_vs_at',
            DB::raw('case when opponents_id = 0 then game_tournaments.meet_name else schools.name end as opp_name'),
            'schools.short_name as opp_nick', 'game_date', DB::raw('LEFT(DATE_FORMAT(game_date,\'%W\'), 3) as day_of_week'), 'game_time',
            DB::raw('case when opponents_id = 0 then game_tournaments.logo else schools.school_logo end as opp_logo'),
            'opponents_score as opp_score', 'rosters.level_id')
            ->leftjoin('game_tournaments', 'games.id', '=', 'game_tournaments.games_id')
            ->leftjoin('schools', 'games.opponents_id', '=', 'schools.id')
            ->leftjoin('rosters', 'rosters.id', '=', 'games.roster_id')
            ->leftjoin('sports', 'sports.id', '=', 'rosters.sport_id')
            ->where('sports.id', $sportId)
            ->where('sports.school_id', $schoolId)
            ->where('rosters.level_id', '=', '1')
            ->where('game_date', '>=', new DateTime('today'))
            ->orderBy('game_date', 'ASC')
            ->first();

        $latest_album = Album::select('album.id')->join('album_sport', 'album_sport.album_id', '=', 'album.id')->where('sport_id', '=', $sportId)->orderBy('album.date', 'DESC')->first();
        $latestPhotos = null;

        if ($latest_album) {
            $latestPhotos = Photo::select('photos.id as photo_id', 'photos.large as photo_large',
                'photos.thumb as photo_thumb')
                ->where('album_id', $latest_album->id)->orderBy('photos.created_at', 'ASC')->get();
        }
        $latestVideo = Roster::select('videos.id as video_id', 'videos.title as video_title', 'videos.video_cover as video_video_cover',
            'videos.url as video_url', 'videos.video_date as video_date')
            ->join('roster_video', 'roster_video.roster_id', '=', 'rosters.id')
            ->join('sports', 'sports.id', '=', 'rosters.sport_id')
            ->join('videos', 'videos.id', '=', 'roster_video.video_id')
            ->orderBy('videos.video_date', 'DESC')
            ->where('sports.id', $sportId)
            ->where('sports.school_id', $schoolId)->first();

        $adDetails = Ad::where('sport_id', $sportId)->where('type_id', '6')->where('school_id', $schoolId)->first();
        $arr = array();


        $arr['sport_id'] = $sport->sport_id;
        $arr['sport_name'] = $sport->sport_name;
        $arr['sport_record'] = $record;
        $arr['sport_photo'] = $sport->sport_photo;
        $arr['latest_news'] = $latest_news;
        $arr['season_list'] = $sport->season_list;
        $arr['sport_levels'] = $sport->sport_levels;
        $arr['last_game'] = $lastGame;
        $arr['next_game'] = $nextGame;
        $arr['latest_video'] = $latestVideo;
        $arr['latest_photos'] = $latestPhotos;
        $arr['ad_details'] = $adDetails;

        //dd($sport->sport_id);
        return response()->json($arr);
    }


    /**
     * get staff list based on the school id and optional season_id
     * @param $schoolId
     * @param $seasonId
     * @return mixed
     */
    public function getStaffList($schoolId, $seasonId)
    {
        if ($seasonId) {
            $staff = Staff::select('id as staff_id', 'photo as staff_photo',
                DB::raw('CONCAT(staff.first_name, " ", staff.last_name) AS staff_name'),
                'title as staff_title', 'staff.email as staff_email ',
                'description as staff_bio', 'phone as staff_phone')
                ->where('school_id', $schoolId)->where('season_id', $seasonId)
                ->orderby('order', 'ASC')->get();

            $arr = array('staff_list' => ($staff));
            return response()->json($arr);
        } else {
            $staff = Staff::select('id as staff_id', 'photo as staff_photo',
                DB::raw('CONCAT(staff.first_name, " ", staff.last_name) AS staff_name'),
                'title as staff_title', 'staff.email as staff_email ',
                'description as staff_bio', 'phone as staff_phone')
                ->where('school_id', $schoolId)
                ->orderby('order', 'ASC')->get();

            $arr = array('staff_list' => ($staff));
            return response()->json($arr);
        }
    }

    /**
     * get staff list based on the school id
     * @param $schoolId
     * @param $staffId
     * @return mixed
     */
    public function getStaff($schoolId, $staffId)
    {
        $staff = Staff::select('id as staff_id', 'description as staff_bio', DB::raw('CONCAT(staff.first_name, " ", staff.last_name) AS staff_name'), 'title as staff_title',
            'email as staff_email', 'phone as staff_phone')
            ->where('school_id', $schoolId)->where('id', $staffId)->first();

        return $staff;
    }


    /**
     * @param $schoolId
     * @return mixed
     */
    public function getSchool($schoolId)
    {
//        $school = School::with([
//            'social_list' => function ($q) {
//                $q->select('id', 'socialLinks_id', 'youtube as youtube_url', 'facebook as facebook_url',
//                    'instagram as instagram_url', 'twitter as twitter_url')->first();
//            }
//        ])->select('id', 'id as school_id', 'name as school_name', 'school_logo', 'school_color',
//            'school_color2', 'school_tagline', 'bio as school_bio', 'photo as school_photo',
//            'video as school_video', 'adress as school_address', 'website as school_url',
//            'phone as school_phone', 'video_cover', 'school_email')->where('id', $schoolId)->first();

        $school = School::select('id', 'id as school_id', 'name as school_name', 'school_logo', 'school_color',
            'school_color2', 'school_tagline', 'bio as school_bio', 'photo as school_photo',
            'video as school_video',
            'adress as school_address',
            'website as school_url',
            'phone as school_phone', 'video_cover', 'school_email', 'video as youtube_url', 'facebook as facebook_url',
            'instagram as instagram_url', 'twitter as twitter_url', 'play_store as googlestore', 'apple_store as applestore',
            'adress', 'city', 'state', 'zip')->where('id', $schoolId)->first();

        if ($school->facebook_url == '') $school->facebook_url = null;
        if ($school->twitter_url == '') $school->twitter_url = null;
        if ($school->instagram_url == '') $school->instagram_url = null;
        if ($school->school_video == '') $school->school_video = null;

        return $school;
    }


    /**
     * @param $schoolId
     * @param $levelId
     * @param $seasonId
     * @param $sportId
     * @return string
     */

    /**
     * @param $schoolId
     * @param $sportId
     * @param $levelId
     * @param $seasonId
     * @return string
     */
    public function getSchedule($schoolId, $sportId, $levelId)
    {
        $schedule = Games::select('games.id as game_id', 'rosters.sport_id', 'our_score as school_score', 'result as game_result',
            DB::raw('
            case when home_away = \'home\' and opponents_id = 0 then game_tournaments.meet_name
            when home_away = \'away\' and opponents_id = 0 then concat(\'@ \', game_tournaments.meet_name)
            when home_away = \'home\' and opponents_id != 0 then schools.name
            else concat(\'@ \', schools.name) end as opp_name'),
            'games.game_date as validate_date', 'home_away as game_vs_at', 'schools.short_name as opp_nick',
            DB::raw('case when opponents_id = 0 then game_tournaments.logo else schools.school_logo end as opp_logo'),
            'opponents_score as opp_score', 'games.roster_id', DB::raw('DATE_FORMAT(games.game_date,\'%b %e %Y\') as game_date'),
            'game_time', 'rosters.level_id', 'games.status', 'school_records.record as record')
            ->leftjoin('schools', 'games.opponents_id', '=', 'schools.id')
            ->leftjoin('game_tournaments', 'games.id', '=', 'game_tournaments.games_id')
            ->join('rosters', 'rosters.id', '=', 'games.roster_id')
            ->leftjoin('school_records', 'school_records.game_id', '=', 'games.id')
            ->where('games.school_id', $schoolId)
            ->orderBy('validate_date', 'ASC');

        //if optional sport id is present
        //check sport if form rosters
        if ($sportId) {
            $schedule = $schedule->where('rosters.sport_id', $sportId);
        }

        //return results for level id optional param
        if ($levelId) {
            $schedule = $schedule->where('rosters.level_id', $levelId);
        }
        $sportListId = Sport::select('sport_id')->where('id', $sportId)->first();

        /**
         * return results for season id optional param
         */


        /**
         * result for required param schoolId
         */
        $arr = array();
        foreach ($schedule->get() as $key => $item) {
            $adDetails = Roster::select('ads.id as ad_id', 'ads.name as ad_name', 'ads.url as ad_url',
                'ads.image as ad_image', 'sponsors.id as sponsor_id', 'sponsors.name as sponsor_name')
                ->join('sponsors', 'sponsors.id', '=', 'rosters.games_advertiser')
                ->join('ads', 'sponsors.id', '=', 'ads.sponsor_id')
                ->where('rosters.school_id', $schoolId)
                ->where('rosters.id', $item->roster_id)
                ->first();

            $future = 1;

            if ($sportListId->sport_id == 7 || $sportListId->sport_id == 33) {

                if ($item->school_score < $item->opp_score) {
                    $scorestring = $item->school_score . '-' . $item->opp_score;
                } elseif ($item->school_score > $item->opp_score) {
                    $scorestring = $item->opp_score . '-' . $item->school_score;
                } else {
                    $scorestring = $item->school_score . '-' . $item->opp_score;
                }
            } else {
                if ($item->school_score > $item->opp_score) {
                    $scorestring = $item->school_score . '-' . $item->opp_score;
                } elseif ($item->school_score < $item->opp_score) {
                    $scorestring = $item->opp_score . '-' . $item->school_score;
                } else {
                    $scorestring = $item->school_score . '-' . $item->opp_score;
                }

            }

            if ($item->game_result) {
                //game was in the past
                $future = 0;
            }

            $arr[$key]["game_id"] = $item->game_id;
            $arr[$key]["game_date"] = $item->game_date;
            $arr[$key]["formal_date"] = $item->validate_date;
            $arr[$key]["game_location"] = $item->game_location;
            $arr[$key]["game_vs_at"] = $item->game_vs_at;
            $arr[$key]["game_result"] = $item->game_result;
            $arr[$key]["game_result"] = $item->game_result;
            $arr[$key]["school_score"] = $item->school_score;
            $arr[$key]["opp_name"] = $item->opp_name;
            $arr[$key]["opp_nick"] = $item->opp_nick;
            $arr[$key]["opp_logo"] = $item->opp_logo;
            $arr[$key]["opp_score"] = $item->opp_score;
            $arr[$key]["future"] = $future;
            $arr[$key]["day_of_week"] = date('l', strtotime($item->game_date));
            $arr[$key]["ad_details"] = $adDetails;
            $arr[$key]["level_id"] = $item->level_id;
            $arr[$key]["game_time"] = $item->game_time;
            $arr[$key]["gameFlag"] = $item->status;
            $arr[$key]["finalScore"] = $scorestring;
            $arr[$key]["record"] = $item->record;;
        }

        $adDetails = Ad::where('sport_id', $sportId)->where('type_id', '4')->where('school_id', $schoolId)->first();

        $arr = array('game_list' => $arr, 'ad_details' => $adDetails);
        return response()->json($arr);
    }


    /**
     * @param $schoolId
     * @param $sportId
     * @param $levelId
     * @param $seasonId
     * @param $gameIdget
     *
     */
    public function getGame(Request $request, $schoolId, $sportId, $levelId, $seasonId, $gameId, $gameData, $userId)
    {
        debugjob::create([
            'section' => 'signin',
            'message' => $request->fullUrl()
        ]);

        $game = Games::select('games.id as game_id',
            DB::raw('DATE_FORMAT(games.game_date,\'%W, %M %D %Y\') as game_date'),
            DB::raw('case when result is null then 1  when result =\'\' then 1 else 0 end as future'),
            ('games.game_date as formal_date'),
            'game_time as game_time',
            'locations.name as game_location',
            'locations.address as game_address',
            'locations.map_url as game_map_url',
            'home_away as game_vs_at',
            'result as game_result',
            'games.opponents_score as opp_score',
            'schools.name as school_name',
            'schools.short_name as school_nick',
            DB::raw('case when opponents_id = 0 then game_tournaments.meet_name else schools.name end as opp_name'),
            'schools.short_name as opp_nick',
            'schools.school_logo as opp_logo',
            'our_score as school_score',
            'games.status as gameFlag',
            'school_records.record as record',
            'rosters.id as roster_id',
            DB::raw('case when opponents_id = 0 then game_tournaments.logo else schools.school_logo end as opp_logo')

        )
            ->leftjoin('locations', 'games.locations_id', '=', 'locations.id')
            ->leftjoin('schools', 'schools.id', '=', 'games.opponents_id')
            ->leftjoin('school_records', 'school_records.game_id', '=', 'games.id')
            ->leftjoin('game_tournaments', 'games.id', '=', 'game_tournaments.games_id')
            ->join('rosters', 'rosters.id', '=', 'games.roster_id')
            ->where('games.id', $gameId)->first();

        if ($game->game_result) {
            //game was in the past
            $game->future_date = 0;
        }

        $game->isScoreGameActive = 0;
        $game->isAdmin = 0;
        $cmsuser = User::where('appuser_id', $userId)->first();
        if ($cmsuser) {
            $userrole = RoleUser::where('user_id', $cmsuser->id)->first();
        } else {
            $userrole = null;
        }
        if ($userrole) {
            if ($userrole->role_id < 4) {
                //$game->isScoreGameActive = 1;
                $game->isAdmin = 1;
            } elseif ($userrole->role_id >= 4) {
                if ($userrole->sport_id == $sportId)
                    //$game->isScoreGameActive = 1;
                    $game->isAdmin = 1;
            }
        }
        if ($game->formal_date) {
            $timestamp = Carbon::today()->toDateTimeString();
            if ($game->formal_date <= $timestamp) {
                $game->isScoreGameActive = 1;
            }
        }


        if ($game->gameFlag == 1) {
            $scores = Score::where('game_id', $gameId)->get();

                $game->opp_score = $scores->sum('opponent_score');
                $game->school_score = $scores->sum('school_score');

            }



        $foo = School::select('school_logo', 'name', 'short_name')->where('id', '=', $schoolId)->first();
        $game->school_logo = $foo->school_logo;
        $game->school_name = $foo->name;
        $game->school_nick = $foo->short_name;


        if ($game->game_location == '') {
            $game->game_location = null;
        }
        if ($game->game_address == '') {
            $game->game_address = null;
        }
        if ($game->game_map_url == '') {
            $game->game_map_url = null;
        }
        if ($game->game_vs_at == '') {
            $game->game_vs_at = null;
        }
        if ($game->game_result == '') {
            $game->game_result = null;
        }
        if ($game->school_score == '') {
            $game->school_score = null;
        }
        if ($game->school_name == '') {
            $game->school_name = null;
        }
        if ($game->school_nick == '') {
            $game->school_nick = null;
        }
        if ($game->opp_name == '') {
            $game->opp_name = null;
        }
        if ($game->opp_nick == '') {
            $game->opp_nick = null;
        }
        if ($game->opp_logo == '') {
            $game->opp_logo = null;
        }
        if ($game->opp_score == '') {
            $game->opp_score = null;
        }
        if ($game->game_time == '') {
            $game->game_time = null;
        }
        if ($game->record == '') {
            $game->record = null;
        }
        if ($game->roster_id == '') {
            $game->groster_id = null;
        }
        if ($game->school_logo == '') {
            $game->school_logo = null;
        }


        $rosterid = $game->roster_id;


        $news = Games::find($gameId)->game_news()->select('news.id as news_id', 'news.title as news_title',
            'news.intro as news_teaser', 'news.image as news_photo',
            'news_date as news_date',
            'link as news_url',
            'news.id')
            ->get();

        $gameAlbums = Album::select('album.name as photo_album_name', 'album.id as album_id',
            DB::raw('DATE_FORMAT(album.created_at,\'%m/%e/%Y\') as photo_album_date'))
            ->join('album_games', 'album_games.album_id', '=', 'album.id')
            ->orderBy('album.created_at', 'DESC')
            ->where('album_games.games_id', $gameId);

        $arr = array();
        foreach ($gameAlbums->get() as $key => $item) {

            $gamePhotos = Games::select('photos.id as photo_id', 'photos.large as photo_large',
                'photos.thumb as photo_thumb')
                ->join('album_games', 'album_games.games_id', '=', 'games.id')
                ->join('album', 'album.id', '=', 'album_games.album_id')
                ->join('photos', 'photos.album_id', '=', 'album.id')
                ->orderBy('photos.created_at', 'ASC')
                ->where('album.id', $item->album_id)
                ->get();

            $arr[$key]["photo_album_name"] = $item->photo_album_name;
            $arr[$key]["photo_album_date"] = $item->photo_album_date;
            $arr[$key]["album_id"] = $item->album_id;
            $arr[$key]["photos"] = $gamePhotos;

        }

        $gameVideo = Video::select('videos.id as video_id', 'videos.title as video_title',
            DB::raw('DATE_FORMAT(videos.video_date,\'%m/%e/%Y\') as video_date'),
            'videos.url as video_url')
            ->join('games_video', 'games_video.video_id', '=', 'videos.id')
            ->where('games_video.games_id', $gameId)
            ->orderBy('videos.video_date', 'DESC')
            ->get();

        $date_array = Games::select('id as game_id',
            DB::raw('concat(\'<b>\' , upper(DATE_FORMAT(game_date,\'%a\')), \'</b>\',\'<br>\',upper(DATE_FORMAT(game_date,\'%b %e\')) ) as display_date'))
            ->where('roster_id', '=', $rosterid)->orderby('game_date', 'asc')
            ->get();

        $adDetails = Ad::where('sport_id', $sportId)->where('type_id', '4')->where('school_id', $schoolId)->first();


        //Get the game
        $scoregame = Games::where('id', $gameId)->first();

        //$isOT = 0;
        //if ($game->status == 4) {
        //    $isOT = 1;
        //}
        $isEndGame = 0;
        if ($scoregame->status == 2) {
            $isEndGame = 1;
        }

        $scores = [];

        //Loop through game scores and populate the scores array
        foreach ($scoregame->scores as $score) {

            if ($score->interval_type == 'round') {
                $scores[] = [
                    'round' => $score->interval,
                    'team_a_score' => $score->school_score,
                    'team_b_score' => $score->opponent_score,
                    'time' => $score->time,
                    'isOT' => 0
                ];
            }

            if ($score->interval_type == 'over_time') {
                $scores[] = [
                    'over_time' => $score->interval, 'AWS' => Aws\Laravel\AwsFacade::class,
                    'team_a_score' => $score->school_score,
                    'team_b_score' => $score->opponent_score,
                    'time' => $score->time,
                    'isOT' => 1
                ];
            }

            if ($score->interval_type == 'penalty_kick') {
                $scores['panelty_kick'][] = [
                    'team_a_flag' => $score->school_score,
                    'team_b_flag' => $score->opponent_score,
                    'isOT' => 0
                ];
            }
        }

        if (isset($scores['panelty_kick'])) {
            $scores[] = [
                'panelty_kick' => $scores['panelty_kick']
            ];

            unset($scores['panelty_kick']);
        }

        $following = following::where('game_id', $gameId)
            ->where('user_id', $userId)
            ->first();
        $follow = 0;
        if ($following) {
            $follow = 1;
        }

        $game->game_video = $gameVideo;
        $game->game_news = $news;
        $game->game_photos = $arr;
        $game->gameDate = $date_array;
        $game->ad_details = $adDetails;
        $game->scores = count($scores) ? $scores : null;
        $game->isEndGame = $isEndGame;
        $game->follow = $follow;

        return $game;

    }

    /**
     * @param $schoolId
     * @return mixed
     */
    public function getRosterList($schoolId)
    {
        $rostersList = Sport::with([
            'sport_levels' => function ($q) {
                $q->select('levels.id as level_id', 'levels.name as level_name')
                    ->orderBy('sort_order', 'ASC')
                    ->get();
            },
            'season_list' => function ($q) {
                $q->select('seasons.id as season_id', 'seasons.name as season_name',
                    'seasons.id')
                    ->get();
            }


        ])
            ->select('sports.id as sport_id', 'sports.id', 'sports.season_id',
                'sport_id')
            ->where('sports.school_id', $schoolId)
            ->get();


        $data = array();
        if ($rostersList) {
            foreach ($rostersList as $key => $item) {
                //get the sport name and icon
                $sportNameAndIcon = SportsList::where('id', $item->sports_id)->first();

                if ($sportNameAndIcon) {
                    $data[$key]['sport_id'] = $item->sport_id;
                    $data[$key]['sport_name'] = $sportNameAndIcon->name;
                    $data[$key]['sport_levels'] = $item->sport_levels;
                    $data[$key]['season_list'] = $item->season_list;
                }
            }
        }

        $arr = array('sport' => $data);
        return response()->json($arr);
    }

    /**
     * @param $schoolId
     * @param $sportId
     * @param $levelId
     * @param $seasonId
     * @return mixed
     */
    public function getRoster($schoolId, $sportId, $levelId, $seasonId)
    {

        if (!($schoolId && $sportId && $levelId)) {
            return json_encode(json_decode('{}'));
        } else {

            $roster = Roster::join('rosters_students', 'rosters_students.roster_id', '=', 'rosters.id')
                ->join('students', 'students.id', '=', 'rosters_students.student_id')
                ->select('students.id as student_id', DB::raw('CONCAT(students.first_name, " ", students.last_name) AS student_name'),
                    'rosters_students.position as student_position', 'rosters_students.photo as student_photo',
                    DB::raw('case when `rosters_students`.`jersy` = \'\' then null else CONCAT("#", `rosters_students`.`jersy`) end as student_number'),
                    DB::raw('case when `height_feet` = 0 then null else CONCAT(students.height_feet, "\'", students.height_inches, "\"") end AS student_height'),
                    'students.weight as student_weight',
                    DB::raw('case when rosters.is_female = 1 then null  when Weight = \'\'  then null else CONCAT(students.weight) end as student_weight'),
                    'students.academic_year as student_year', 'students.academic_year as pLevel',
                    'rosters.id as roster_id', 'rosters.level_id as level_id', 'rosters.level_id',
                    DB::raw('CASE WHEN rosters.level_id = \'1\' THEN 1 ELSE 0 END AS pro_flag'), 'students.first_name', 'students.last_name')
                ->where('rosters.school_id', $schoolId)
                ->where('rosters.sport_id', $sportId)
                ->where('rosters.level_id', $levelId)
                ->OrderBy(DB::raw('cast(rosters_students.jersy AS UNSIGNED)'), 'ASC')
                ->orderBy('students.last_name', 'ASC')
                ->get();
            // ->union($staff)->get();
            $adDetails = Ad::where('sport_id', $sportId)->where('type_id', '1')->where('school_id', $schoolId)->first();

            $arr = array('student_list' => $roster, 'ad_details' => $adDetails);
            return response()->json($arr);

            return json_encode(json_decode('{}'));
        }
    }

    /**
     * @param $schoolId
     * @param $studentId
     * @param $sportId
     * @param $levelId
     * @param $seasonId
     * @param $year
     *
     *
     * incomplete
     * pro sports, videos, photos remaining
     *
     */
    public function getStudent($schoolId, $studentId, $sportId, $levelId)
    {
        $rid = Roster::select('id')
            ->where('sport_id', $sportId)
            ->where('level_id', $levelId)
            ->where('school_id', $schoolId)
            ->first();

        $count = Student::withoutGlobalScope('concatName')->select('students.id as student_id')
            ->join('rosters_students', 'rosters_students.student_id', '=', 'students.id')
            ->where('students.id', $studentId)->get();

        $student = Student::withoutGlobalScope('concatName')->select('students.id as student_id', 'students.first_name', 'students.last_name',
            DB::raw('case when `height_feet` = 0 then null else CONCAT(students.height_feet, "\'", students.height_inches, "\"") end AS student_height'),
            DB::raw('CASE WHEN rosters.level_id = \'1\' THEN 1  WHEN rosters.level_id = \'3\' THEN 1 WHEN rosters.level_id = \'4\' THEN 1 ELSE 0 END AS pro_flag'),
            DB::raw('case when rosters.is_female = 1 then null  when Weight = \'\'  then null else CONCAT(students.weight) end as student_weight'),
            'sports.photo as pro_cover_photo', 'students.academic_year as student_year',
            'rosters_students.photo as student_photo', 'rosters_students.number as student_number',
            'rosters_students.full_photo as pro_head_photo', 'rosters_students.position as student_position',
            DB::raw('case when `rosters_students`.`jersy` = \'\' then null else CONCAT("#", `rosters_students`.`jersy`) end as student_number'))
            ->join('rosters_students', 'rosters_students.student_id', '=', 'students.id')
            ->join('rosters', 'rosters.id', '=', 'rosters_students.roster_id')
            ->join('sports', 'sports.id', '=', 'rosters.sport_id')
            ->where('students.id', $studentId)
            ->where('rosters.sport_id', $sportId)
            ->where('rosters.level_id', $levelId)
            ->get();


        if (count($count) > 1) {
            $rosters = Student::withoutGlobalScope('concatName')->select('students.id as student_id', DB::raw('CONCAT(students.first_name, " ", students.last_name) AS student_name'),
                DB::raw('CONCAT(students.height_feet, "\'", students.height_inches, "\"") AS student_height'),
                'weight as student_weight', DB::raw('CASE WHEN rosters.level_id = \'1\' THEN 1 ELSE 0 END AS pro_flag'), 'sports.photo as pro_cover_photo',
                'rosters_students.photo as student_photo', 'rosters_students.number as student_number',
                'rosters_students.full_photo as pro_head_photo', 'rosters_students.position as student_position',
                'sports.id as sport_id', 'sports.sport_name as sport_name', 'sports.highlight_video as highlight_video', 'rosters_students.roster_id')
                ->join('rosters_students', 'rosters_students.student_id', '=', 'students.id')
                ->join('rosters', 'rosters.id', '=', 'rosters_students.roster_id')
                ->join('sports', 'sports.id', '=', 'rosters.sport_id')
                ->where('students.id', $studentId)
                ->where('rosters.level_id', '=', '1')
                ->orderby('rosters.season_id', 'ASC');

        } else {
            $rosters = Student::withoutGlobalScope('concatName')->select('students.id as student_id', DB::raw('CONCAT(students.first_name, " ", students.last_name) AS student_name'),
                DB::raw('CONCAT(students.height_feet, "\'", students.height_inches, "\"") AS student_height'),
                'weight as student_weight', DB::raw('CASE WHEN rosters.level_id = \'1\' THEN 1 ELSE 0 END AS pro_flag'), 'sports.photo as pro_cover_photo',
                'rosters_students.photo as student_photo', 'rosters_students.number as student_number',
                'rosters_students.full_photo as pro_head_photo', 'rosters_students.position as student_position',
                'sports.id as sport_id', 'sports.sport_name as sport_name', 'sports.highlight_video as highlight_video', 'rosters_students.roster_id')
                ->join('rosters_students', 'rosters_students.student_id', '=', 'students.id')
                ->join('rosters', 'rosters.id', '=', 'rosters_students.roster_id')
                ->join('sports', 'sports.id', '=', 'rosters.sport_id')
                ->where('students.id', $studentId);
        }


        $rosarr = array();
        foreach ($rosters->get() as $key => $item) {
            //possible problem, need to bring album.date in
            $sportPhotos = Photo::select('photos.id as photo_id', 'photos.large as photo_large',
                'photos.thumb as photo_thumb')
                ->join('photo_student', 'photo_student.photo_id', '=', 'photos.id')
                ->join('album_roster', 'album_roster.album_id', '=', 'photos.album_id')
                ->where('photo_student.student_id', $studentId)
                ->where('album_roster.roster_id', $item->roster_id)->orderBy('photos.created_at', 'DESC')->get();
            $news = News::select('news.id as news_id', 'news.intro as news_teaser', 'title as news_title', 'image as news_photo', 'news_date as news_date', 'link as news_url')
                ->join('news_student', 'news_student.news_id', '=', 'news.id')
                ->join('news_sport', 'news_sport.news_id', '=', 'news.id')
                ->where('news_student.student_id', $studentId)
                ->where('news_sport.sport_id', $item->sport_id)
                ->orderBy('news_date', 'DESC')
                ->get();
            $videos = Video::select('id as video_id', 'title as video_title', 'video_date as video_date', 'url as video_url', 'video_cover')
                ->join('student_video', 'student_video.video_id', '=', 'videos.id')
                ->join('sport_video', 'sport_video.video_id', '=', 'videos.id')
                ->where('student_video.student_id', $studentId)
                ->where('sport_video.sport_id', $item->sport_id)
                ->orderBy('videos.video_date', 'DESC')
                ->get();

            $rosarr[$key]["sport_id"] = $item->sport_id;
            $rosarr[$key]["sport_name"] = $item->sport_name;
            $rosarr[$key]["highlight_video"] = $item->highlight_video;
            $rosarr[$key]["photos"] = $sportPhotos->count() ? $sportPhotos : null;
            $rosarr[$key]["news"] = $news->count() ? $news : null;
            $rosarr[$key]["videos"] = $videos->count() ? $videos : null;


        }

        $adDetails = Ad::where('sport_id', $sportId)->where('type_id', '1')->where('school_id', $schoolId)->first();
        $customData = CustomField::select('custom_fields.custom_label', 'custom_fields_data.custom_data')
            ->join('custom_fields_data', 'custom_fields_data.custom_field_id', '=', 'custom_fields.id')
            ->where('student_id', $studentId)->distinct();

        if ($customData->count() == 0) {

            $customData = CustomField::select('custom_fields.custom_label', DB::raw('\'\' as custom_data'))
                ->where('school_id', $schoolId)->distinct();;
        }


        $arr = array($student, 'pro_sports' => $rosarr, 'custom_fields' => $customData->get(), 'ad_detials' => $adDetails);
        return response()->json($arr);

    }


    public function getNewsList($schoolId, $sportId, $seasonId)
    {


        $newsList = Sport::join('news_sport', 'news_sport.sport_id', '=', 'sports.id')
            ->join('news', 'news.id', '=', 'news_sport.news_id')
            ->select('news.id', 'news.id as news_id', 'title as news_title', 'intro as news_teaser',
                'image as news_photo', 'news_date', 'link as news_url', 'news.school_id')
            ->where('news.school_id', $schoolId)
            ->where('sports.id', $sportId)
            ->orderBy('news_date', 'Desc')
            ->get();
        if ($newsList->first()) {
            foreach ($newsList as $key => $item) {

                $adDetails = News::select('ads.id as ad_id', 'ads.name as ad_name', 'ads.url as ad_url',
                    'ads.image as ad_image', 'sponsors.id as sponsor_id', 'sponsors.name as sponsor_name')
                    ->join('news_roster', 'news_roster.news_id', '=', 'news.id')
                    ->join('rosters', 'news_roster.roster_id', '=', 'rosters.id')
                    ->join('sponsors', 'sponsors.id', '=', 'rosters.news_advertiser')
                    ->join('ads', 'ads.sponsor_id', '=', 'sponsors.id')
                    ->where('news.school_id', $schoolId)
                    ->where('news.id', $item->news_id)
                    ->first();

                $arr[$key]["news_id"] = $item->news_id;
                $arr[$key]["news_title"] = $item->news_title;
                $arr[$key]["news_teaser"] = $item->news_teaser;
                $arr[$key]["news_photo"] = $item->news_photo;
                $arr[$key]["news_date"] = $item->news_date;
                $arr[$key]["news_url"] = $item->news_url;
                $arr[$key]["ad_details"] = $adDetails;
            }

            $adDetails = Ad::where('sport_id', $sportId)->where('type_id', '3')->where('school_id', $schoolId)->first();
            $arr = array('news_list' => $arr, 'ad_details' => $adDetails);
            return response()->json($arr);
        }


        /**
         * return results for school_id
         */
        $newsList = null;
        $adDetails = Ad::where('sport_id', $sportId)->where('type_id', '3')->where('school_id', $schoolId)->first();
        $arr = array('news_list' => $newsList, 'ad_details' => $adDetails);
        return response()->json($arr);
    }


    public function getTopNews($schoolId, $sportId, $limit)
    {

        if ($limit) {
            if ($sportId != '') {
                $newsList = Sport::join('news_sport', 'news_sport.sport_id', '=', 'sports.id')
                    ->join('news', 'news.id', '=', 'news_sport.news_id')
                    ->select('news.id', 'news.id as news_id', 'title as news_title', 'intro as news_teaser',
                        'image as news_photo', 'news_date', 'link as news_url', 'news.school_id')
                    ->where('news.school_id', $schoolId)
                    ->where('sports.id', $sportId)
                    ->orderBy('news_date', 'Desc')
                    ->take($limit)
                    ->get();
            } else {
                $newsList = Sport::join('news_sport', 'news_sport.sport_id', '=', 'sports.id')
                    ->join('news', 'news.id', '=', 'news_sport.news_id')
                    ->select('news.id', 'news.id as news_id', 'title as news_title', 'intro as news_teaser',
                        'image as news_photo', 'news_date', 'link as news_url', 'news.school_id')
                    ->where('news.school_id', $schoolId)
                    ->orderBy('news_date', 'Desc')
                    ->take($limit)
                    ->get();
            }

        } else {
            if ($sportId) {
                $newsList = Sport::join('news_sport', 'news_sport.sport_id', '=', 'sports.id')
                    ->join('news', 'news.id', '=', 'news_sport.news_id')
                    ->select('news.id', 'news.id as news_id', 'title as news_title', 'intro as news_teaser',
                        'image as news_photo', 'news_date', 'link as news_url', 'news.school_id')
                    ->where('news.school_id', $schoolId)
                    ->where('sports.id', $sportId)
                    ->orderBy('news_date', 'Desc')
                    ->get();
            } else {
                $newsList = Sport::join('news_sport', 'news_sport.sport_id', '=', 'sports.id')
                    ->join('news', 'news.id', '=', 'news_sport.news_id')
                    ->select('news.id', 'news.id as news_id', 'title as news_title', 'intro as news_teaser',
                        'image as news_photo', 'news_date', 'link as news_url', 'news.school_id')
                    ->where('news.school_id', $schoolId)
                    ->orderBy('news_date', 'Desc')
                    ->get();
            }
        }

        if ($newsList->first()) {
            foreach ($newsList as $key => $item) {

                $arr[$key]["news_id"] = $item->news_id;
                $arr[$key]["news_title"] = $item->news_title;
                $arr[$key]["news_teaser"] = $item->news_teaser;
                $arr[$key]["news_photo"] = $item->news_photo;
                $arr[$key]["news_date"] = $item->news_date;
                $arr[$key]["news_url"] = $item->news_url;

            }
            $arr = array('news_list' => $arr);
            return response()->json($arr);
        }


        /**
         * return results for school_id
         */
        $newsList = null;
        $adDetails = Ad::where('sport_id', $sportId)->where('type_id', '3')->where('school_id', $schoolId)->first();
        $arr = array('news_list' => $newsList, 'ad_details' => $adDetails);
        return response()->json($arr);
    }


    /**
     * @param $schoolId
     * @param $newsId
     * return specific news
     */
    public function getNews($schoolId, $newsId, $sportId)
    {
        $news = News::select('id as news_id', 'title as news_title',
            DB::raw('CONCAT(LEFT(content , 20), \'....\') as news_teaser'),
            'image as news_photo',
            DB::raw('DATE_FORMAT(news_date,\'%m/%e/%Y\') as news_date'),
            'link as news_url', 'author as news_credit', 'content as news_content')
            ->where('school_id', $schoolId)
            ->where('id', $newsId)
            ->first();

        $adDetails = Ad::where('type_id', '3')->where('sport_id', $sportId)->where('school_id', $schoolId)->first();
        $arr = array('news_list' => $news, 'ad_details' => $adDetails);
        return response()->json($arr);

    }

    /**
     * @param $schoolId
     * @param $sportId
     * @param $seasonId
     * @param $studentId
     *
     * school_id is required param
     *
     */
    public function getMedia($schoolId, $sportId)
    {
        $media = Album::with([
            'photos' => function ($q) {
                $q->select('photos.id', 'photos.id as photo_id', 'photos.thumb as photo_thumb',
                    'photos.large as photo_large', 'photos.album_id')->orderBy('photos.created_at', 'ASC')
                    ->get();
            }
        ])
            ->select('album.id as album_id', 'album.name as album_name',
                DB::raw('DATE_FORMAT(album.date,\'%m/%e/%Y\') as album_date'),
                'album.url as album_url', 'album.id')
            ->join('album_sport', 'album_sport.album_id', '=', 'album.id')
            ->where('album.school_id', $schoolId)
            ->where('sport_id', $sportId)
            ->orderBy('album.date', 'DESC')
            ->get();
        $vid = Video::select('videos.id as video_id', 'videos.title as video_title', 'videos.video_date as video_date',
            'videos.url as video_url', 'videos.video_cover')
            ->join('sport_video', 'sport_video.video_id', '=', 'videos.id')
            ->orderBy('videos.video_date', 'DESC')
            ->where('sport_video.sport_id', $sportId)
            ->get();

        $adDetails = Ad::where('sport_id', $sportId)->where('type_id', '2')->where('school_id', $schoolId)->first();
        $arr = array('albums' => array('album' => $media, 'videos' => $vid, 'ad_details' => $adDetails));
        return response()->json($arr);
    }


    /**
     * @param $schoolId
     * @param $sportId
     * @param $seasonId
     * return albums list
     * season id is optional
     */


    public
    function getMedia2($schoolId, $sportId, $seasonId, $studentId)
    {
        $media = Album::with([
            'photos' => function ($q) {
                $q->select('photos.id', 'photos.id as photo_id', 'photos.thumb as photo_thumb',
                    'photos.large as photo_large', 'photos.album_id')->orderBy('created_at', 'ASC')
                    ->get();
            }
        ])
            ->select('album.id as album_id', 'album.name as album_name', 'album.date as album_date',
                'album.url as album_url', 'album.id')->get();


        return response()->json($media);
    }


    public
    function getAlbumList($schoolId, $sportId, $seasonId)
    {


        $albumsList = Album::select('album.id as album_id', 'album.name as album_name', 'date as album_date',
            'url as album_url', 'sports.sport_name as sport_name')
            ->join('album_roster', 'album_roster.album_id', '=', 'album.id')
            ->join('rosters', 'album_roster.roster_id', '=', 'rosters.id')
            ->join('sports', 'rosters.sport_id', '=', 'sports.id')
            ->where('album.school_id', $schoolId)
            ->where('sports.id', $sportId);
        $arr = array();
        $adDetails = Ad::where('sport_id', $sportId)->where('type_id', '2')->where('school_id', $schoolId)->first();
        foreach ($albumsList->get() as $key => $item) {
            $photos = Photo::select('id as photo_id', 'thumb', 'large as photo_large', 'thumb as photo_thumb')
                ->where('album_id', $item->album_id)
                ->take(7)->get();
            $arr[$key]["album_id"] = $item->album_id;
            $arr[$key]["album_name"] = $item->album_name;
            $arr[$key]["album_date"] = $item->album_date;
            $arr[$key]["album_url"] = $item->album_url;
            $arr[$key]["sport_name"] = $item->sport_name;

            $arr[$key]["photos"] = $photos;
        }

        $arr = array('albums' => array($arr, 'ad_details' => $adDetails));
        return response()->json($arr);


    }


    /**
     * @param $schoolId
     * @param $sportId
     * @param $seasonId
     * @param $albumId
     *
     * return specific album
     */
    public
    function getAlbum($schoolId, $sportId, $seasonId, $albumId)
    {

        //all are required params
        if ($schoolId && $sportId && $albumId) {
            $albumsList = Album::select('album.id as album_id', 'album.name as album_name',
                DB::raw('DATE_FORMAT(album.created_at,\'%m/%d/%Y\') as album_date'),
                'url as album_url', 'sports.sport_name as sport_name')
                ->join('album_roster', 'album_roster.album_id', '=', 'album.id')
                ->join('rosters', 'album_roster.roster_id', '=', 'rosters.id')
                ->join('sports', 'rosters.sport_id', '=', 'sports.id')
                ->where('album.school_id', $schoolId)
                ->where('sports.id', $sportId)
                ->where('album.id', $albumId);

            //optional param
            if ($seasonId) {
                $albumsList = $albumsList->where('album.season_id', $seasonId);
            }

            $photos = Photo::select('id as photo_id', 'thumb', 'large as photo_large', 'thumb as photo_thumb')
                ->where('album_id', $albumId)
                ->get();
            $adDetails = Ad::where('sport_id', $sportId)->where('type_id', '2')->where('school_id', $schoolId)->first();
            if ($albumsList->first()) {
                $arr['album_id'] = $albumsList->first()->album_id;
                $arr['album_name'] = $albumsList->first()->album_name;
                $arr['album_date'] = $albumsList->first()->album_date;
                $arr['album_url'] = $albumsList->first()->album_url;
                $arr['sport_name'] = $albumsList->first()->sport_name;
                $arr['photos'] = $photos;
                $arr['ad_details'] = $adDetails;

                return response()->json($arr);
            }
        }
    }

    /**
     * @param $schoolId required param
     * @param $sportId
     * @param $socialName
     *incomplete html formatted feed
     */
    public
    function getSocial($request)
    {
        $social = Sport::select('facebook', 'twitter', 'instagram')
            ->where('id', $request->sport_id)->first();
        if ($social->facebook == '') $social->facebook = null;
        if ($social->twitter == '') $social->twitter = null;
        if ($social->instagram == '') $social->instagram = null;

        $ar = array();
        $ar['facebook'] = $social->facebook;
        $ar['twitter'] = $social->twitter;
        $ar['instagram'] = $social->instagram;
        $adDetails = Ad::where('sport_id', $request->sport_id)->where('type_id', '6')->where('school_id', $request->schoolId)->first();
        if ($adDetails) {
            if ($adDetails->url == '') $adDetails->url = 'null';
            if ($adDetails->image == '') $adDetails->image = 'null';

            $ad = array();
            $ad['url'] = $adDetails->url;
            $ad['image'] = $adDetails->image;
        } else {
            $ad = null;

        }
        $ar['ad_details'] = $ad;
        return response()->json($ar);
    }

    /**
     * @param $schoolId
     *
     * not implemented yet;
     */
    public
    function getAboutCompany($schoolId)
    {

        $stores = School::select('play_store', 'apple_store')->where('id', $schoolId)->first();
        $company = array();
        $social = new stdClass();

        $company['company_name'] = 'REPU';
        $company['company_email'] = 'info@repusports.com';
        $company['company_logo'] = 'https://s3-us-west-2.amazonaws.com/repitsports/img/repu_400.png';
        $company['company_bio'] = 'REPU provides a complete digital ecosystem specifically designed for high school and college athletic programs. At the center of the experience is the iOS and Android mobile app which drives unlimited revenue, builds fan engagement and is a powerful recruiting tool for student athletes.';
        $company['company_url'] = 'http://www.repitsports.com/';
        $company['company_phone'] = '(760) 593-7779';
        $company['review_ios'] = 'itms-apps://itunes.apple.com/app/id' . $stores->apple_store;
        $company['review_android'] = 'https://play.google.com/store/apps/details?id=' . $stores->play_store . '&hl=en';
        $company['bg_color'] = '#777777';
        $social->facebook_url = 'http://https//www.facebook.com/gosideline';
        $social->twitter_url = 'http://https//twitter.com/gosideline';
        $social->instaram_url = 'http://https//www.instagram.com/gosideline';
        $company['company_social'] = $social;
        return response()->json($company);
    }

    /**
     * @param Request $request
     * @return
     */
    public
    function signUp(Request $request)
    {

        //$post = Input::all();
        $resultArray = json_encode($request->all());

        // $content = $request->getContent();
        debugjob::create([
            'section' => 'postdata',
            'message' => $resultArray
        ]);

        //Validate inputs
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:app_users',
            'paswd' => 'required|min:6',
            'udid' => 'required',
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        if ($request->input('user_image') == 'null') {
            $user = AppUser::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'user_name' => $request->input('first_name') . "_" . $request->input('last_name'),
                'email' => $request->input('email'),
                'paswd' => bcrypt($request->input('paswd')),
                'udid' => $request->input('udid')
            ]);
        } else {
            //Create new user
            $user = AppUser::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'user_name' => $request->input('first_name') . "_" . $request->input('last_name'),
                'email' => $request->input('email'),
                'paswd' => bcrypt($request->input('paswd')),
                'user_image' => $request->input('user_image') ? uploadImage($request->input('user_image'), '/uploads/users/') : '',
                'udid' => $request->input('udid')
            ]);
        }
        $schoolsports = Sport::where('school_id', $request->school_id)->get();
        $notifications = Notification::get();
        //joe nest loop for each sport with notification id of X do notify function
        foreach ($schoolsports as $schoolsport) {


            $n = $notifications->where('sport_list_id', $schoolsport->sport_id);
            foreach ($n as $notify) {

                $create = usernotification::create([
                    'user_id' => $user->id,
                    'notification_id' => $notify->id,
                    'sport_id' => $schoolsport->id,
                    'flag' => 1
                ]);

            }


        }

        $notificationList = [];

        //Check if there're notifications
        if ($user->notifications->count()) {
            //Loop through notification and populate notificationList array with the needed data
            foreach ($user->notifications->sortBy('sort_order') as $notification) {
                $notificationList[] = [
                    'notification_id' => $notification->id,
                    'notification_title' => $notification->title,
                    'sport_id' => $notification->pivot->sport_id,
                    'notification_flag' => $notification->pivot->flag,
                    'notification_uid' => $notification->pivot->id,
                ];
            }
        }


        //Return user data
        return response()->json([
            'status' => 1,
            'user_name' => $user->user_name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'user_image_url' => $user->user_image ?: 'http://cms.repitsports.com/img/800x800user.png',
            'user_id' => $user->id,
            'notifications' => $notificationList
        ]);
    }


    public
    function editProfile(Request $request)
    {

        $resultArray = json_encode($request->all());

        // $content = $request->getContent();
        debugjob::create([
            'section' => 'postdata',
            'message' => $resultArray
        ]);

        $appuser = AppUser::where('id', '=', $request->user_id)->first();

        if ($request->old_password) {
            if ($request->input('user_image')) {
                if (Hash::check($request->old_password, $appuser->paswd)) {
                    $appuser->update([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'user_image' => $request->input('user_image') ? uploadImage($request->input('user_image'), '/uploads/users/') : '',
                        'paswd' => bcrypt($request->new_password)
                    ]);
                } else {
                    if (Hash::check($request->old_password, $appuser->paswd)) {
                        $appuser->update([
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'email' => $request->email,
                            'paswd' => bcrypt($request->new_password)
                        ]);
                    }
                }
            } else {
                return response()->json('Old Password is Invalid');
            }
        } else {
            if ($request->input('user_image')) {
                $appuser->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'user_image' => $request->input('user_image') ? uploadImage($request->input('user_image'), '/uploads/users/') : '',

                ]);
            } else {
                $appuser->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                ]);

            }
        }
        return response()->json([

            'first_name' => $appuser->first_name,
            'last_name' => $appuser->last_name,
            'email' => $appuser->email,
            'user_image_url' => $appuser->user_image,
            'user_id' => $appuser->id,
            'status' => 1,
            'done' => ''
        ]);

    }


    /**
     * @param Request $request
     * @return
     */
    public
    function signIn(Request $request)
    {
        debugjob::create([
            'section' => 'signin',
            'message' => $request->fullUrl()
        ]);

        //Validate inputs
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'paswd' => 'required'
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        //Check if there's a user with this email
        if ($user = AppUser::where('email', $request->input('email'))->first()) {
            //Check password
            if (Hash::check($request->input('paswd'), $user->paswd)) {
                //Return user data
                return response()->json([
                    'status' => 1,
                    'user_name' => $user->user_name,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'user_image_url' => url($user->user_image),
                    'user_id' => $user->id,
                    'is_admin' => $user->is_admin
                ]);
            }
        }

        return response()->json([
            'status' => 0,
            'errors' => ['These credentials do not match our records.']
        ]);
    }

    /**
     * @param Request $request
     * @return
     */
    public
    function favourite(Request $request)
    {
        debugjob::create([
            'section' => 'favourite',
            'message' => $request->fullUrl()
        ]);
        //Validate inputs
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:app_users,id',
            'sport_id' => 'required|numeric|exists:sports,id'
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        //Get the user
        $user = AppUser::find($request->input('user_id'));

        //Attach the sport
        $user->sports()->syncWithoutDetaching([$request->input('sport_id')]);

        return response()->json([
            'status' => 1,
            'done' => ''
        ]);
    }

    /**
     * @param Request $request
     * @return
     */
    public
    function unFavourite(Request $request)
    {
        debugjob::create([
            'section' => 'unfavourite',
            'message' => $request->fullUrl()
        ]);
        //Validate inputs
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:app_users,id',
            'sport_id' => 'required|numeric|exists:sports,id',
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        //Get the user
        $user = AppUser::find($request->input('user_id'));

        //Detach the sport
        $user->sports()->detach($request->input('sport_id'));

        return response()->json([
            'status' => 1,
            'done' => ''
        ]);
    }

    /**
     * @param Request $request
     * @return
     */
    public
    function settings(Request $request)
    {
        debugjob::create([
            'section' => 'settings',
            'message' => $request->fullUrl()
        ]);
        //Validate inputs
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:app_users,id',
            'sport_id' => 'required|numeric|exists:sports,id',
            'setting_id' => 'required|numeric|exists:settings,id',
            'value' => 'required|numeric'
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        //Get the user
        $user = AppUser::find($request->input('user_id'));

        //Attach the setting to user with sport_id and value
        $user->settings()->syncWithoutDetaching([
            $request->input('setting_id') => [
                'sport_id' => $request->input('sport_id'),
                'value' => $request->input('value')
            ]
        ]);

        return response()->json([
            'status' => 1,
            'done' => ''
        ]);
    }

    public
    function getScoreData($request)
    {
        debugjob::create([
            'section' => 'getScoreData',
            'message' => $request->fullUrl()
        ]);
        //Validate inputs
        $validator = Validator::make($request->all(), [
            'game_id' => 'required|numeric|exists:games,id',
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        //Get the game
        $game = Games::find($request->input('game_id'));

        //Get the game scores
        $scores = $game->scores;

        return response()->json([
            'status' => 1,
            'score_data' => $scores
        ]);
    }

    public
    function followGame($request)
    {
        debugjob::create([
            'section' => 'followGame',
            'message' => $request->fullUrl()
        ]);
        /**
         * //Validate inputs
         * $validator = Validator::make($request->all(), [
         * 'user_id' => 'required|numeric|exists:app_users,id',
         * 'game_id' => 'required|numeric|exists:games,id',
         * 'sport_id' => 'required|numeric|exists:sports,id',
         * 'game' => 'required|numeric',
         * ]);
         *
         * //Check if validation fails
         * if ($validator->fails()) {
         * //Return validation messages
         * return response()->json([
         * 'status' => 0,
         * 'errors' => $validator->messages()
         * ]);
         * }
         *
         * //Get the user
         * $user = AppUser::find($request->input('user_id'));
         *
         * //Attach the game to users followed games with sport_id and game
         * $user->followedGames()->syncWithoutDetaching([
         * $request->input('game_id') => [
         * 'sport_id' => $request->input('sport_id'),
         * 'game' => $request->input('game'),
         * ]
         * ]);
         */
        $userArn = UserArn::where('user_id', $request->input('user_id'))->first();

        if (!$userArn) {

            $endpoints = School::select('gcm', 'apns')->where('id', $request->school_id)->first();

            if ($request->is_ios != 1) {
                $p_arn = $endpoints->gcm;
            } else {
                $p_arn = $endpoints->apns;
            }

            $user = AppUser::find($request->input('user_id'));
            if ($user) {

                $user->update([

                    'device_token' => $request->device_token
                ]);


                $snsClient = SnsClient::factory(array(
                    'credentials' => array(
                        'key' => 'AKIAI5INJXCDBJJY4UOA',
                        'secret' => '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',
                    ),
                    'region' => 'us-west-2',
                    'version' => 'latest'
                ));
                $result = $snsClient->createPlatformEndpoint([

                    'PlatformApplicationArn' => $p_arn, // REQUIRED
                    'Token' => $request->device_token, // REQUIRED
                ]);
                $arn = $result['EndpointArn'];
                $identity = UserArn::create(['user_id' => $request->user_id,
                    'device_token' => $request->device_token,
                    'device_arn' => $arn,
                    'school_id' => $request->school_id,
                    'ios' => $request->is_ios
                ]);

                if ($request->follow == 1) {
                    following::create([
                        'game_id' => $request->input('game_id'),
                        'user_id' => $request->input('user_id'),
                        'arn' => $arn,
                        'ios' => $request->is_ios
                    ]);
                } else {
                    following::where('game_id', $request->input('game_id'))
                        ->where('user_id', $request->input('user_id'))
                        ->delete();
                }
            }
        } else {

            if ($request->follow == 1) {
                following::create([
                    'game_id' => $request->input('game_id'),
                    'user_id' => $request->input('user_id'),
                    'arn' => $userArn->device_arn,
                    'ios' => $userArn->ios
                ]);

            } else {
                following::where('game_id', $request->input('game_id'))
                    ->where('user_id', $request->input('user_id'))
                    ->delete();
            }
        }
        return response()->json([
            'status' => 1,
            'done' => ''
        ]);
    }

    public
    function resetPassword($request)
    {
        debugjob::create([
            'section' => 'resetPassword',
            'message' => $request->fullUrl()
        ]);
        //Validate inputs
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:app_users,email',
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        //Get email
        $email = $request->input('email');

        //Get email user
        $user = AppUser::where('email', $email)->first();

        //Create a hashed token
        $token = hash_hmac('sha256', Str::random(40), 'secret');

        //Delete any old created token for this user
        AppUsersPasswordReset::where('email', $email)->delete();

        //Create the reset info
        AppUsersPasswordReset::create([
            'email' => $email,
            'token' => $token,
            'created_at' => new Carbon
        ]);

        //Create reset link
        $resetLink = route('app.password.reset', ['token' => $token]);

        //Send email
        //Mail::send('emails.reset-password', compact('resetLink', 'user'), function ($m) use ($user, $email) {
        //   $m->to($user->email, $user->user_name)->subject('Your Password Reset Link');
        // });

        return response()->json([
            'status' => 1,
            'done' => ''
        ]);
    }

    public
    function saveDeviceToken($request)
    {
        debugjob::create([
            'section' => 'savedevicetoken',
            'message' => $request->fullUrl()
        ]);
        //SAVES UDID NOT TOKEN
        //Validate inputs
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:app_users,id',
            'udid' => 'required',
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        //Get the user
        $user = AppUser::find($request->input('user_id'));

        //Update user udid
        $user->udid = $request->input('udid');

        //Save user
        $user->save();

        return response()->json([
            'status' => 1,
            'done' => ''
        ]);
    }

    public
    function notification($request)
    {
        debugjob::create([
            'section' => 'notification',
            'message' => $request->fullUrl()
        ]);
        //Validate inputs
        $validator = Validator::make($request->all(), [
            'uid' => 'required|numeric|exists:user_notification,id',

            'flag' => 'required|boolean',
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }


        DB::update('UPDATE user_notification SET flag =  ? WHERE id = ?',
            [$request->input('flag'), $request->input('uid')]);


        return response()->json([
            'status' => 1,
            'done' => ''
        ]);
    }

    public
    function getList($request)
    {
        debugjob::create([
            'section' => 'getlist',
            'message' => $request->fullUrl()
        ]);


        //Validate inputs
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:app_users,id',
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        //Get the user
        $user = AppUser::find($request->input('user_id'));
        $usersports = UserSport::select('sport_id')
            ->where('user_id', $request->input('user_id'))->get();

        $usersportfirst = UserSport::select('sport_id')
            ->where('user_id', $request->input('user_id'))
            ->orderBy('sport_id', 'ASC')->first();
        if (!$usersportfirst) {
            $firstid = 0;
        } else {
            $firstid = $usersportfirst->sport_id;
        }
        $favelist = [];
        //dd($usersports);
        if ($firstid == 0 && $usersports->count() == 1) {

            $favelist = [];
        } else {

            foreach ($usersports as $usersport) {
                $favelist[] = $usersport->sport_id;
            }
        }
        //Set notification list to empty array
        $notificationList = [];

        //Check if there're notifications
        if ($user->notifications->count()) {
            //Loop through notification and populate notificationList array with the needed data
            foreach ($user->notifications->sortBy('sort_order') as $notification) {
                $notificationList[] = ['notification_id' => $notification->id,
                    'notification_title' => $notification->title,
                    'sport_id' => $notification->pivot->sport_id,
                    'notification_flag' => $notification->pivot->flag,
                    'notification_uid' => $notification->pivot->id,];
            }
        }

        return response()->json([
            'status' => 1,
            'favourite_list' => $favelist,
            'notification_list:Array' => $notificationList
        ]);

    }

    public
    function startGame($request)
    {
        debugjob::create([
            'section' => 'startGame',
            'message' => $request->fullUrl()
        ]);
        //Validate inputs
        $validator = Validator::make($request->all(), [
            'game_id' => 'required|numeric|exists:games,id',
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        //Get the game
        $game = Games::find($request->input('game_id'));

        //Update game status to 1 which mean game started
        $game->update(['status' => 1]);


        $game->scores()->create([
            'school_score' => 0,
            'opponent_score' => 0,
            'interval' => 1,
            'interval_type' => 'round',
            'status' => 1 // 1 means started
        ]);

        return response()->json([
            'status' => 1,
            'done' => ''
        ]);
    }

    public
    function updateScore($request)
    {
        $resultArray = json_encode($request->all());

        // $content = $request->getContent();
        debugjob::create([
            'section' => 'postdata',
            'message' => $resultArray
        ]);

        if ($request->isHomeGame == 'true') {
            $team_a_score = $request->input('team_b_score');
            $team_b_score = $request->input('team_a_score');
        } else {
            $team_a_score = $request->input('team_a_score');
            $team_b_score = $request->input('team_b_score');
        }
        //as we go down team a is school b is opponent
        //Validate inputs
        $validator = Validator::make($request->all(), [
            // 'game_id' => 'required|numeric|exists:games,id',
            'team_a_score' => 'required_without:panelty_kick|numeric',
            'team_b_score' => 'required_without:panelty_kick|numeric',
            'time' => 'required',
            'round' => 'numeric',
            'over_time' => 'numeric',
            'panelty_kick' => 'json',
            'isHomeGame' => 'required',
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        //Get the game
        $game = Games::find($request->input('game_id'));
        $gameStatus = $game->status;

        if ($request->input('round')) { //If round given

            //Check if round exists
            $round = $game->scores()
                ->where('interval_type', 'round')
                ->where('interval', $request->input('round'))
                ->first();

            if ($round) { //If exist update

                $round->where('interval_type', 'round')
                    ->where('interval', $request->input('round'))
                    ->where('game_id', $request->input('game_id'))
                    ->update([
                        'school_score' => $team_a_score,
                        'opponent_score' => $team_b_score,
                        'time' => $request->input('time')
                    ]);

            } else { //Else create

                $game->scores()->create([
                    'game_id' => $request->input('game_id'),
                    'school_score' => $team_a_score,
                    'opponent_score' => $team_b_score,
                    'time' => $request->input('time'),
                    'interval' => $request->input('round'),
                    'interval_type' => 'round',
                    'status' => 1 // 1 means started
                ]);

            }


        } elseif ($request->input('over_time')) { //Else if over_time given

            //Check if round exists
            $overTime = $game->scores()
                ->where('interval_type', 'over_time')
                ->where('interval', $request->input('over_time'))
                ->first();


            if ($overTime) { //If exist update

                $overTime
                    ->where('interval_type', 'over_time')
                    ->where('interval', $request->input('over_time'))
                    ->where('game_id', $request->input('game_id'))
                    ->update([
                        'school_score' => $team_a_score,
                        'opponent_score' => $team_b_score,
                        'time' => $request->input('time')
                    ]);

            } else { //Else create

                $game->scores()->create([
                    'game_id' => $request->input('game_id'),
                    'school_score' => $team_a_score,
                    'opponent_score' => $team_b_score,
                    'time' => $request->input('time'),
                    'interval' => $request->input('over_time'),
                    'interval_type' => 'over_time',
                    'status' => 1 // 1 means started
                ]);

            }

        } elseif ($penalties = json_decode($request->input('panelty_kick'), true)) { //Else if panelty_kick given

            foreach ($penalties['panelty_kick'] as $key => $value) {

                //Check if round exists
                $penalty = $game->scores()
                    ->where('interval_type', 'penalty_kick')
                    ->where('interval', $key + 1)
                    ->first();

                if ($penalty) { //If exist update

                    $penalty->where('interval_type', 'penalty_kick')
                        ->where('interval', $key + 1)
                        ->where('game_id', $request->input('game_id'))
                        ->update([
                            'school_score' => $value['team_a_flag'],
                            'opponent_score' => $value['team_b_flag']
                        ]);

                } else { //Else create

                    $game->scores()->create([
                        'game_id', $request->input('game_id'),
                        'school_score' => $value['team_a_flag'],
                        'opponent_score' => $value['team_b_flag'],
                        'interval' => $key + 1,
                        'interval_type' => 'penalty_kick',
                        'status' => 1 // 1 means started
                    ]);

                }
            }
        }
        /**
         * 02/20 Joe removing, seems to need to be moved to endround due to an endgame paramater being passed there
         * else {
         *
         * //Compare score to know the result
         * if ($team_a_score > $team_b_score) {
         * $result = 'W'; //  Win
         * } elseif ($team_a_score < $team_b_score) {
         * $result = 'L'; // Lose
         * } else {
         * $result = 'D'; // Draw
         * }
         *
         * //Update game
         * $game->update([
         * 'our_score' => $team_a_score,
         * 'opponents_score' => $team_b_score,
         * 'time' => $request->input('time'),
         * 'result' => $result
         * ]);
         *
         * }
         */

        if ($gameStatus == 2) {
            $updatescores = updateRecords($game->id, $game->roster_id);
        }

        return response()->json([
            'status' => 1,
            'done' => ''
        ]);
    }

    public
    function endRound($request)
    {
        debugjob::create([
            'section' => 'endRound',
            'message' => $request->fullUrl()
        ]);
        /**
         * //Validate inputs
         * $validator = Validator::make($request->all(), [
         * 'game_id' => 'required|numeric|exists:games,id',
         * 'round' => 'numeric',
         * 'over_time' => 'numeric',
         * 'panelty_kick' => 'numeric',
         * ]);
         *
         * //Check if validation fails
         * if ($validator->fails()) {
         * //Return validation messages
         * return response()->json([
         * 'status' => 0,
         * 'errors' => $validator->messages()
         * ]);"abbv_name" "short_name"
         * }
         */
        //Get the game
        $game = Games::find($request->input('game_id'));
        if ($game->opponent->abbv_name) {
            $opponentName = $game->opponent->abbv_name;
        } elseif ($game->opponent->short_name) {
            $opponentName = $game->opponent->short_name;
        } else {
            $opponentName = $game->opponent->name;
        }
        $scoolabbbv = School::select('abbv_name')->where('id', $request->school_id)->first();

        //set up variables to be used for push
        $sportlist = Sport::select('sport_id', 'round_type', 'sport_name')->where('id', $request->sport_id)->first();
        //dd($request, $sportlist);

        $round = $request->round;
        $pushbody = $request->highlight;
        $batch = uniqid();


        //set up varaibles to be used in the push regardless of game state

        $scores = Score::where('game_id', $request->game_id)->get();

        $school_score = $scores->sum('school_score');
        $opponent_score = $scores->sum('opponent_score');

        if ($school_score < $opponent_score) {
            $scorestring = $opponentName . ' ' . $opponent_score . ' - ' . $scoolabbbv->abbv_name . ' ' . $school_score;
            $wl = '(loss)';
        } elseif ($school_score > $opponent_score) {
            $scorestring = $scoolabbbv->abbv_name . ' ' . $school_score . ' - ' . $opponentName . ' ' . $opponent_score;
            $wl = '(win)';
        } else {
            $scorestring = $scoolabbbv->abbv_name . ' ' . $school_score . ' - ' . $opponentName . ' ' . $opponent_score;
            $wl = '(tie)';
        }
        //end push varaibles

        if ($request->input('round')) { //If round given
            //Check if round exists
            $round = $game->scores()
                ->where('interval_type', 'round')
                ->where('interval', $request->input('round'))
                ->first();
            //get interval $sportlist
            $interval = Interval::where('sport_list_id', $sportlist->sport_id)->where('round', $request->input('round'))->first();
            if ($round) { //If exist update

                $round->where('interval_type', 'round')
                    ->where('interval', $request->input('round'))
                    ->update([
                        'status' => 2, // 2 means ended
                        'highlight' => $request->input('highlight') ?: $round->highlight
                    ]);
                $title = $scorestring . ' ' . $interval->values;
            }

            if ($request->input('isEndGame') == 'true') {
                $game->update([
                    'status' => 2, // 2 means ended
                    'highlight' => $request->input('highlight') ?: $game->highlight
                ]);

                $title = $scorestring . ' (FINAL)';
            } else {
                $newinterval = ($request->input('round')) + 1;
                $game->scores()->create([
                    'school_score' => 0,
                    'opponent_score' => 0,
                    'interval' => $newinterval,
                    'interval_type' => 'round',
                    'status' => 1 // 1 means started
                ]);
            }


        } elseif ($request->input('over_time')) { //Else if over_time given

            //Check if round exists
            $overTime = $game->scores()
                ->where('interval_type', 'over_time')
                ->where('interval', $request->input('over_time'))
                ->first();


            if ($overTime) { //If exist update

                $overTime->where('interval_type', 'over_time')
                    ->where('interval', $request->input('over_time'))
                    ->update([
                        'status' => 2, // 2 means ended
                        'highlight' => $request->input('highlight') ?: $overTime->highlight
                    ]);
                $game->update([
                    'status' => 4 // 4 is for OT
                ]);
            }

        } elseif ($request->input('panelty_kick')) { //Else if panelty_kick given

            //Check if penalty exists
            $penalty = $game->scores()
                ->where('interval_type', 'penalty_kick')
                ->where('interval', $request->input('panelty_kick'))
                ->first();

            if ($penalty) { //If exist update

                $penalty->where('interval_type', 'penalty_kick')
                    ->where('interval', $request->input('panelty_kick'))
                    ->update([
                        'status' => 2, // 2 means ended
                        'highlight' => $request->input('highlight') ?: $penalty->highlight
                    ]);
                $game->update([
                    'status' => 3 // 3 is for Penalty
                ]);
            }

        } else {
            //Update game
            $game->update([
                'status' => 2, // 2 means ended
                'highlight' => $request->input('highlight') ?: $game->highlight
            ]);
        }
        //you have end round and end game to delineate messages
        if ($request->input('isEndGame') == 'true') {
            $notificationid = Notification::select('id')->where('sport_list_id', $sportlist->sport_id)->where('title', '=', 'End Game')->first();
        } else {
            $notificationid = Notification::select('id')->where('sport_list_id', $sportlist->sport_id)->where('title', 'like', '%' . 'Scores' . '%')->first();
        }
        $endpoints = usernotification::select('device_arn', 'ios')
            ->join('user_arns', 'user_arns.user_id', '=', 'user_notification.user_id')
            ->where('notification_id', $notificationid->id)
            ->where('flag', '1')
            ->where('school_id', $request->school_id)
            ->distinct();


        Push::create([
            'id' => $batch,
            'category' => $sportlist->sport_name . ' Scores',
            'message' => $title . '. ' . $pushbody,
            'schoolid' => $request->school_id,
            'sport' => $request->sport_id,
        ]);

        foreach ($endpoints->get() as $endpoint) {

            $queue = pushqueue::create([
                'id' => uniqid(),
                'endpoint' => $endpoint->device_arn,
                'title' => $sportlist->sport_name . ' Scores',
                'body' => $title . '. ' . $pushbody,
                'school' => $request->school_id,
                'batch' => $batch,
                'ios' => $endpoint->ios
            ]);
        }

        $following = following::where('game_id', $request->input('game_id'))->get();

        foreach ($following as $f) {

            pushqueue::create([
                'id' => uniqid(),
                'endpoint' => $f->arn,
                'title' => $sportlist->sport_name . ' Scores',
                'body' => $title . '. ' . $pushbody,
                'school' => $request->school_id,
                'batch' => $batch,
                'ios' => $f->ios
            ]);
        }

        //gameplan...
        //sum up the  scores for the game
        //move this up to combine code, if its painfull slow offload to a worker


        if ($request->input('isEndGame') == 'true') {

            $scores = Score::where('game_id', $request->input('game_id'))->get();

            $school_score = $scores->sum('school_score');
            $opponent_score = $scores->sum('opponent_score');

            if ($school_score == $opponent_score) {
                $result = 'T';
                $w = 0;
                $l = 0;
                $t = 1;
            } elseif
            ($school_score > $opponent_score
            ) {
                $result = 'W';
                $w = 1;
                $l = 0;
                $t = 0;
            } else {
                $result = 'L';
                $w = 0;
                $l = 1;
                $t = 0;
            }


            if ($schoolRecord = SchoolRecord::where('game_id', '=', $request->input('game_id'))->first()) {

                $schoolRecord->update([
                    'w' => $w,
                    'l' => $l,
                    't' => $t,

                ]);

                $records = SchoolRecord::where('roster_id', $game->roster_id)->get();


                foreach ($records as $r) {
                    $dates = $r->game_date;
                    $minutes = $r->minutes_from_midnight;

                    $foo = DB::select('SELECT sum(w) as w, sum(l) as l, sum(t) as t  FROM school_records
            where game_date <= ? and roster_id = ? or game_date = ? and minutes_from_midnight <= ? and roster_id = ? ',
                        [$dates, $game->roster_id, $dates, $minutes, $game->id]);
                    $resultArray = json_decode(json_encode($foo), true);
                    $isTie = $resultArray[0]['t'];
                    if ($isTie == 0) {
                        $record = $resultArray[0]['w'] . "-" . $resultArray[0]['l'];
                    } else {
                        $record = $resultArray[0]['w'] . "-" . $resultArray[0]['l'] . "-" . $resultArray[0]['t'];
                    }
                    SchoolRecord::where('id', '=', $r->id)->first()->update(array('record' => $record));

                }

                $game->update([
                    'our_score' => $school_score,
                    'opponents_score' => $opponent_score,
                    'result' => $result,
                    'status' => 2, // 2 means ended
                    'highlight' => $request->input('highlight') ?: $game->highlight
                ]);


            } else {

                return response()->json([
                    'status' => 0,
                    'done' => 'failed record update'
                ]);

            }
        }


        return response()->json([
            'status' => 1,
            'done' => ''
        ]);

    }


    public
    function boxScore($request)
    {
        debugjob::create([
            'section' => 'boxScore',
            'message' => $request->fullUrl()
        ]);
        //Validate inputs
        $validator = Validator::make($request->all(), [
            'game_id' => 'required|numeric|exists:games,id'
        ]);

        //Check if validation fails
        if ($validator->fails()) {
            //Return validation messages
            return response()->json([
                'status' => 0,
                'errors' => $validator->messages()
            ]);
        }

        //Get the game
        $game = Games::find($request->input('game_id'));

        //$isOT = 0;
        //if ($game->status == 4) {
        //    $isOT = 1;
        //}
        $isEndGame = 0;
        if ($game->status == 2) {
            $isEndGame = 1;
        }

        $scores = [];

        //Loop through game scores and populate the scores array

        foreach ($game->scores as $score) {

            if ($score->interval_type == 'round') {
                if ($game->home_away == 'Away') {
                    $team_a_score = $score->school_score;
                    $team_b_score = $score->opponent_score;
                } else {
                    $team_a_score = $score->opponent_score;
                    $team_b_score = $score->school_score;
                }
                $scores[] = [
                    'round' => $score->interval,
                    'team_a_score' => $team_a_score,
                    'team_b_score' => $team_b_score,
                    'time' => $score->time,
                    'isOT' => 0
                ];
            }

            if ($score->interval_type == 'over_time') {
                if ($game->home_away == 'Away') {
                    $team_a_score = $score->school_score;
                    $team_b_score = $score->opponent_score;
                } else {
                    $team_a_score = $score->opponent_score;
                    $team_b_score = $score->school_score;
                }
                $scores[] = [
                    'over_time' => $score->interval, 'AWS' => Aws\Laravel\AwsFacade::class,
                    'team_a_score' => $team_a_score,
                    'team_b_score' => $team_b_score,
                    'time' => $score->time,
                    'isOT' => 1
                ];
            }

            if ($score->interval_type == 'penalty_kick') {
                if ($game->home_away == 'Away') {
                    $team_a_score = $score->school_score;
                    $team_b_score = $score->opponent_score;
                } else {
                    $team_a_score = $score->opponent_score;
                    $team_b_score = $score->school_score;
                }
                $scores['panelty_kick'][] = [
                    'team_a_score' => $team_a_score,
                    'team_b_score' => $team_b_score,
                    'isOT' => 0
                ];
            }
        }

        if (isset($scores['panelty_kick'])) {
            $scores[] = [
                'panelty_kick' => $scores['panelty_kick']
            ];

            unset($scores['panelty_kick']);
        }


        return response()->json([
            'status' => 1,
            'isEndGame' => $isEndGame,
            //'isOT' => $isOT,
            'scores' => count($scores) ? $scores : null
        ]);
    }


    /**
     * registers the device
     * @param $deviceId
     * @return $id
     */
    public
    function registerDevice($request)
    {
        debugjob::create([
            'section' => 'registerdevice',
            'message' => $request->fullUrl()
        ]);
        $user = AppUser::where('udid', '=', $request->device_id)->first();

        if ($user) {
            return response()->json($user->id);
        } else {


            if ($request) {

                $appUser = AppUser::create([
                    'user_name' => '' . Carbon::now()->toDateTimeString(),
                    'email' => '' . Carbon::now()->toDateTimeString(),
                    'paswd' => 'unregistered',
                    'user_image' => 'unregistered',
                    'is_admin' => '0',
                    'udid' => $request->device_id,
                    'school_id' => $request->school_id
                ]);


                //loop through available sports and create favorites and notifications
                $schoolsports = Sport::where('school_id', $request->school_id)->get();
                $notifications = Notification::get();
                //joe nest loop for each sport with notification id of X do notify function
                foreach ($schoolsports as $schoolsport) {


                    $n = $notifications->where('sport_list_id', $schoolsport->sport_id);

                    foreach ($n as $notify) {

                        $create = usernotification::create([
                            'user_id' => $appUser->id,
                            'notification_id' => $notify->id,
                            'sport_id' => $schoolsport->id,
                            'flag' => 1
                        ]);
                    }
                }

                $notificationList = [];

                //Check if there're notifications
                if ($appUser->notifications->count()) {
                    //Loop through notification and populate notificationList array with the needed data
                    foreach ($appUser->notifications as $notification) {

                        $notificationList[] = [
                            'notification_id' => $notification->id,
                            'notification_title' => $notification->title,
                            'sport_id' => $notification->pivot->sport_id,
                            'notification_flag' => $notification->pivot->flag,
                            'notification_uid' => $notification->pivot->id,
                        ];
                    }
                }


                //return response()->json($appUser->id);
                return response()->json([
                    'user_id' => $appUser->id,
                    'notificationList' => $notificationList
                ]);
            } else {
                return "failed";
            }
        }
    }

    public
    function updateDeviceToken($request)
    {
        debugjob::create([
            'section' => 'updatedevicetoken',
            'message' => $request->fullUrl()
        ]);
        $invalid = 0;
        $userarn = UserArn::where('user_id', $request->user_id);

        $user = AppUser::find($request->input('user_id'));
        if ($request->device_token) {
            if ($user->device_token != $request->device_token) {
                $invalid = 1;


                foreach ($userarn->get() as $u) {

                    $snsClient = SnsClient::factory(array(
                        'credentials' => array(
                            'key' => 'AKIAI5INJXCDBJJY4UOA',
                            'secret' => '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',
                        ),
                        'region' => 'us-west-2',
                        'version' => 'latest'
                    ));

                    $result = $snsClient->deleteEndpoint(array(
                        // EndpointArn is required
                        'EndpointArn' => $u->device_arn,
                    ));
                }
                $userarn->delete();
            }
        }
        if (!$userarn->get()) {
            $invalid = 1;
        }

        if ($invalid == 1) {

            $endpoints = School::select('gcm', 'apns')->where('id', $request->school_id)->first();

            if ($request->is_ios != 1) {
                $p_arn = $endpoints->gcm;
            } else {
                $p_arn = $endpoints->apns;
            }

            if ($user) {

                $user->update([

                    'device_token' => $request->device_token
                ]);


                $snsClient = SnsClient::factory(array(
                    'credentials' => array(
                        'key' => 'AKIAI5INJXCDBJJY4UOA',
                        'secret' => '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',
                    ),
                    'region' => 'us-west-2',
                    'version' => 'latest'
                ));
                $result = $snsClient->createPlatformEndpoint([

                    'PlatformApplicationArn' => $p_arn, // REQUIRED
                    'Token' => $request->device_token, // REQUIRED
                ]);
                $arn = $result['EndpointArn'];
                $identity = UserArn::create(['user_id' => $request->user_id,
                    'device_token' => $request->device_token,
                    'device_arn' => $arn,
                    'school_id' => $request->school_id,
                    'ios' => $request->is_ios
                ]);

                return response()->json('done');
            } else {
                return "failed";
            }
        }
        return response()->json('done');
    }


    public
    function truncateScores()
    {
        //this is for app team during testing
        DB::statement('delete from scores');

        return response()->json([
            'status' => 1,
            'done' => ''
        ]);
    }


    public
    function testSns(Request $request)
    {
        //Control batch size of Lambda Consumer
        $messages = pushqueue::where('push_date', null)->orWhere('push_date', '<', Carbon::now())->take(500);

        $arr = array();

        //foreach ($messages->get() as $key => $item) {
        foreach ($messages->get() as $key => $item) {
            $arr[$key]['id'] = $item->id;
            $arr[$key]['endpoint'] = $item->endpoint;
            $arr[$key]['title'] = $item->title;
            $arr[$key]['body'] = $item->body;
            $arr[$key]['batch'] = $item->batch;
            $arr[$key]['ios'] = $item->ios;

        }
        //Remove from subsequesnt polls
        $messages->delete();

        return response()->json($arr);
    }


    public
    function sandbox(Request $request)
    {
        $cmsusers = User::all();


        foreach ($cmsusers as $c){

            $appuser = AppUser::where('email' , $c->email);
           $foo = $appuser->first();
            if ($foo) {

                $appuser->update([
                    'first_name' => $c->first_name,
                    'last_name' => $c->last_name,
                    'email' => $c->email,
                    'paswd' => $c->password
                ]);
            } else {

                AppUser::create([
                    'first_name' => $c->first_name,
                    'last_name' => $c->last_name,
                    'email' => $c->email,
                    'paswd' => $c->password
                ]);

                }
            }
        return response()->json('yay');
    }

    /**
     * saves favourite sports
     * for a user
     * @param $userId
     * @param $favourites
     */
    public
    function updateFavouriteList($request)
    {
        debugjob::create([
            'section' => 'favourite',
            'message' => $request->fullUrl()
        ]);
        //dd($request->all());
        $userId = $request->input('user_id');
        $favourites = $request->input('sports_ids');
        if ($userId && $favourites) {
            $favouriteList = explode(',', $favourites);
            if ($favouriteList) {
                $app = AppUser::where('id', $userId)->first();
                if ($app) {
                    $app->sports()->sync($favouriteList);
                    return response()->json([
                        'favourite_list' => $favouriteList
                    ]);
                } else {
                    return "this user id does not exists.";
                }
            } else {
                return "Sports ids are required.";
            }
        } else {
            return "both user id and list of sports ids are required.";
        }
    }
}
