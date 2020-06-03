<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jikan\MyAnimeList\MalClient;
use Jikan\Model\Genre\AnimeGenreList;

class JikanMal extends Controller
{
    public function index(int $year = 2000, $season = 'winter'){
        $jikan = new MalClient;
        $season = $jikan->getSeasonal(
            (new \Jikan\Request\Seasonal\SeasonalRequest(
                $year,
                $season
            ))
        );

        $retorno = [];
        foreach($season->getAnime() as $key => $value){
            array_push($retorno, [
                'airing_start' => $this->formatDate($value->getAiringStart(),'c'),
                'continuing' => $value->isContinuing(),
                'episodes' => $value->getEpisodes(),
                'genres' => $this->getArrayGenres($value->getGenres()),
                'image_url' => $value->getImageUrl(),
                'kids' => $value->isKids(),
                'licensors' => $value->getLicensors(),
                'mal_id' => $value->getMalId(),
                'members' => $value->getMembers(),
                'producers' => $this->getArrayProducers($value->getProducers()),
                'r18' => $value->isR18(),
                'score' => $value->getScore(),
                'synopsis' => $value->getSynopsis(),
                'title' => $value->getTitle(),
                'type' => $value->getType(),
                'url' => $value->getUrl()
            ]);
        }

        return response()->json($retorno);
    }


    public function season($year = 2000, $season = 'winter') {
        $jikan = new MalClient;
        $season = $jikan->getSeasonal(
            (new \Jikan\Request\Seasonal\SeasonalRequest(
                $year,
                $season
            ))
        );

        $retorno = [];
        foreach($season->getAnime() as $key => $value){
            array_push($retorno, [
                'airing_start' => $this->formatDate($value->getAiringStart(),'c'),
                'continuing' => $value->isContinuing(),
                'episodes' => $value->getEpisodes(),
                'genres' => $this->getArrayGenres($value->getGenres()),
                'imageUrl' => $value->getImageUrl(),
                'kids' => $value->isKids(),
                'licensors' => $value->getLicensors(),
                'malId' => $value->getMalId(),
                'members' => $value->getMembers(),
                'producers' => $this->getArrayProducers($value->getProducers()),
                'r18' => $value->isR18(),
                'score' => $value->getScore(),
                'synopsis' => $value->getSynopsis(),
                'title' => $value->getTitle(),
                'type' => $value->getType(),
                'url' => $value->getUrl()
            ]);
        }

        return response()->json($retorno);
    }


    public function reviews(int $id, int $page = 1){
        $jikan = new MalClient;

        $reviews = $jikan->getAnimeReviews(
            (new \Jikan\Request\Anime\AnimeReviewsRequest(
                $id,$page
            ))
        );
        $retorno = [];
        foreach($reviews as $key => $review){
           try{
                array_push(
                    $retorno,
                    [
                        'malId' => $review->getMalId(),
                        'url' => $review->getUrl(),
                        'helpfulCount' => $review->getHelpfulCount(),
                        'date' => $this->formatDate($review->getDate(),'c'),
                        'reviewer' => $this->getReviewer($review->getReviewer()),
                        'content' => $review->getContent()
                    ]
                );
           }catch(Exception $e){
            array_push(
                $retorno,
                [
                    'err' => $e . " key : " . $key
                ]);
           }
        }

        return response()->json($retorno);
    }

    public function genres(){
        $jikan = new MalClient;
        $retorno = [];
        $response = $jikan->getAnimeGenres(
            new \Jikan\Request\Genre\AnimeGenresRequest()
        );
        foreach($response->getGenres() as $key => $genre){
            array_push(
                $retorno,
                [
                    'count' => $genre->getCount(),
                    'name' => $genre->getName(),
                    'url' => $genre->getUrl()
                ]
            );
        }
        return response()->json(
           $retorno
        );
    }

    public function genre(int $genreid, int $page = 1){
        $jikan = new MalClient;
        $response = $jikan->getAnimeGenre(
            new \Jikan\Request\Genre\AnimeGenreRequest($genreid , $page)
        );
        $retorno = [];
        foreach($response->getAnime() as $key => $anime){
            array_push($retorno,array(
                'malId' => $anime->getMalId(),
                'url' => $anime->getUrl(),
                'title' => $anime->getTitle(),
                'imageUrl' => $anime->getImageUrl(),
                'synopsis' => $anime->getSynopsis(),
                'type' => $anime->getType(),
                'episodes' => $anime->getEpisodes(),
                'members' => $anime->getMembers(),
                'source' => $anime->getSource(),
                'score' => $anime->getScore(),
                'r18' => $anime->isR18(),
                'kids' => $anime->isKids(),
                'genres' => $this->getArrayGenres($anime->getGenres()),
                'airing_start' => $this->formatDate($anime->getAiringStart(),'c'),
                'producers' => $this->getArrayProducers($anime->getProducers()),
            ));
        }

        return response()->json(
            $retorno
        );
    }



    private function getArrayGenres($genres) : array{
        $gens = [];
        foreach($genres as $key => $value){
            array_push($gens, [
                'name' => $value->getName(),
                'url' => $value->getUrl()
            ]);
        }
        return $gens;
    }

    private function getReviewer($rev){
        $score =  $rev->getScores();
        return [
            'episodesSeen' => $rev->getEpisodesSeen(),
            'scores' => [
                'overall' => $score->getOverAll(),
                'story' => $score->getStory(),
                'animation' => $score->getAnimation(),
                'sound' => $score->getSound(),
                'character' => $score->getCharacter(),
                'enjoyment' => $score->getEnjoyment()
            ],
            'url' => $rev->getUrl(),
            'imageUrl' => $rev->getImageUrl(),
            'username' => $rev->getUserName()
        ];
    }

    private function getArrayProducers($producers){
        $prods = [];
        foreach($producers as $key => $value){
            array_push($prods, [
                'name' => $value->getName(),
                'url' => $value->getUrl()
            ]);
        }
        return $prods;
    }

    private function formatDate($date, $format){
        if(!is_null($date)){
            return date($format, $date->getTimestamp());
        }
        return "";
    }
}
