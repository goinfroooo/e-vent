<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use App\Models\Article;
use App\Models\article as ModelsArticle;
use App\Models\Stock;
use App\Models\Panier;

class ArticleController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function get_all(Request $request)
    {
        $articles = Article::select('nom', 'prix', 'short_description','img_path','token','options')->get();
        return $articles;
    }

    public function get_one(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article_token' => 'required|string|max:255',
            
        ]);

        if ($validator->fails()) {
            return "invalide request data"; //Si pas de token on arrete la
        }
        $validatedData=$validator->validated();

        //On essaie de récupèrer l'id qui correspond au token
        $article = Article::where('token', $validatedData["article_token"])->first();
        

        if ($article) {
            $stock = Stock::where ("article_id",$article->id)->first();
            $qte_in_cart=0;
            $panier = Panier::where("article_id",$article->id)->get();
            foreach ($panier as $item) {
                $qte_in_cart+= $item->qte;
            
                // Faites ce que vous avez besoin de faire avec chaque élément ici
            }
            $content = [];
            $content["nom"]=$article->nom;
            $content["prix"]=$article->prix;
            $content["short_desc"]=$article->short_desc;
            $content["description"]=$article->description;
            $content["img_path"]=$article->img_path;
            $content["token"]=$article->token;
            $content["stock"]=$stock->qte-$qte_in_cart;
            return response()->json(['content' => $content], 200);

        } else {
            // Si le token fourni n'existe pas, on renvoit une erreur 404
            return response()->json(['message' => 'aucun article correspondant'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,)
    {
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
