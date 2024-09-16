<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use App\Models\Article;
use App\Models\User;
use App\Models\Panier;
use App\Models\Commande;

use App\Mail\new_order;
use App\Mail\confirm_order;


class StripeController extends Controller
{
    public function pay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token'=>'required|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
        }
    
        // Créer un nouvel utilisateur
        $validatedData=$validator->validated();

        $user = User::where("user_token",$validatedData["user_token"])->first();
        $paniers= Panier::where("user_id",$user->id)->where("standby",0)->get();
        $stripe = new \Stripe\StripeClient(env('SECRET_STRIPE_KEY'));
        $line_items = [];
        foreach($paniers as $panier) {
            $item = [];
            $article = Article::where("id",$panier->article_id)->first();
            $product = $stripe->products->retrieve($article->stripe_id, []);
            $item ["price"]=$product->default_price;
            $item["quantity"]=$panier->qte;
            array_push($line_items,$item);
        }
        
        Stripe::setApiKey(env('SECRET_STRIPE_KEY'));
        $YOUR_DOMAIN = env('APP_URL');
        $token = uniqid();
        // Créer une session de paiement
        $checkout_session = Session::create([
            
            'line_items' => $line_items,
            'customer_email'=>$user->email,
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/stripe/success/' . $token,
            'cancel_url' => $YOUR_DOMAIN . '/stripe/cancel/' . $token,
        ]);

        $this->create_commande($user->id,$checkout_session->id,$token);

        
        // Rediriger vers l'URL de la session de paiement
        //return redirect()->away($checkout_session->url);
        return response()->json(['message' => "success","url"=>$checkout_session->url], 200);
    }

    public function import_all_products()
        {
            try {
                // Récupérer tous les articles de votre base de données
                $articles =  Article::all();

                // Créer un client Stripe
                $stripe = new \Stripe\StripeClient(env('SECRET_STRIPE_KEY'));

                // Boucler à travers chaque article pour créer un produit Stripe et son prix
                foreach(($articles) as $article) {
                    // Créer le produit Stripe
                    $product = $stripe->products->create([
                        'name' => $article["nom"],
                        'description' => $article["short_description"],
                        //'images' => [$article["img_path"]],
                        // Vous pouvez également inclure d'autres paramètres comme 'type', 'attributes', etc.
                    ]);

                    // Créer le prix associé avec le produit créé
                    $price = $stripe->prices->create([
                        'unit_amount' => $article["prix"], 
                        'currency' => 'eur', 
                        'product' => $product->id, 
                    ]);
                    $stripe->products->update(
                        $product->id,
                        ['default_price' => $price->id],
                      );

                    $article->stripe_id=$product->id;
                    
                    $article->save();
                }
                
                return response()->json(['message' =>"sucess"], 200);

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 404);
            }
        }


        public function success($token_commande)
        {
            try {
                $commande = Commande::where("token",$token_commande)->first();
                
                $stripe = new \Stripe\StripeClient(env('SECRET_STRIPE_KEY'));
                $checkout = $stripe->checkout->sessions->retrieve(
                    $commande->checkout_id,
                    []
                  ); 

                  if ($checkout->payment_status !="paid") {
                    
                    return response()->json(['error' => $checkout], 404);
                  }
                  else {
                    
                    $user = User::where("id",$commande->user_id)->first();
                    $paniers = Panier::where("user_id",$user->id)
                                ->where("standby",0)
                                ->get();
                    foreach ($paniers as $panier) {
                        $panier->delete();
                    }
                    $commande->status="paid";
                    $commande->save();
                    $result = Mail::to("erwan.soria@gmail.com")->send(new new_order());
                    $result = Mail::to($user->email)->send(new confirm_order($commande->numero_commande));
                    
                    
                    return view("success");
                  }
                

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 404);
            }
        }

        public function cancel($token_commande)
        {
            try {
                $commande = Commande::where("token",$token_commande)->first();
                $commande->status("canceled");
                $commande->save();
                return view("cancel");

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 404);
            }
        }

        private function create_commande($user_id,$checkout_id,$token_commande) {
            try {
                $paniers=Panier::where("user_id",$user_id)
            ->where("standby","0")
            ->get();
            $articles=[];
            foreach ($paniers as $panier) {
                $articles[$panier->article_id]=$panier->qte;
            }
            $commande = new Commande();
            $commande->user_id=$user_id;
            $commande->checkout_id=$checkout_id;
            $commande->token=$token_commande;
            $commande->articles=json_encode($articles);
            $commande->livraison_estimee = Carbon::now()->addDays(7);

            $numeroCommande = strval(random_int(100000000, 999999999));

            // Assurez-vous que le numéro de commande est unique
            while (Commande::where('numero_commande', $numeroCommande)->exists()) {
                $numeroCommande = strval(random_int(100000000, 999999999));
            }
            $commande->numero_commande=$numeroCommande;
            $commande->save();
            return 0;
            }
            catch (\Exception $e) {
                throw $e;
            }
        }

    
    
}
