<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Commande;
use App\Models\Article;
use App\Models\User;

class CommandeController extends Controller
{
    public function get (Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'user_token'=>'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
            }

            $validatedData=$validator->validated();
    
            $user = User::where("user_token",$validatedData["user_token"])->first();
            $commandes = Commande::select("numero_commande","articles","livraison_estimee","status","updated_at")
            ->where("user_id",$user->id)
            ->whereDate("created_at", ">", Carbon::now()->subMonths(3))
            ->orderBy("created_at","DESC")
            ->get();
            $body = [];
            foreach ($commandes as $commande) {
                $row = [];
                $row["numero"]= $commande->numero_commande;
                $row["livraison_estimee"]= $commande->livraison_estimee;
                $row["status"]= $commande->status;
                $row["date_commande"]= $commande->updated_at;
                $articles = [];
                foreach (json_decode($commande->articles, true) as $article_id => $qte) {
                    $article = Article::where("id",$article_id)->first();
                    $element = [];
                    $element["nom"]=$article->nom;
                    $element["prix"]=$article->prix;
                    $element["short_desc"]=$article->short_description;
                    $element["img_path"]=$article->img_path;
                    $element["article_token"]=$article->token;
                    $element["qte"]=$qte;
                    array_push($articles,$element);
                }
                $row["articles"]=$articles;
                array_push($body,$row);
            }
            return response()->json(['message' => "success","body"=>$body], 200);

        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
        

    }
}
