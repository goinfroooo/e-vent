<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\change_email;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Mail\inscription;
use App\Models\Adress;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function create(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'birthday' => 'required|date_format:Y-m-d',
                'email' => 'required|email|unique:users|max:255',
                'adress' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'password' => 'required|string|min:6',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
            }
        
            // Créer un nouvel utilisateur
            $validatedData=$validator->validated();
            $token_email = Uuid::uuid4()->toString();
            $appUrl = env('APP_URL');
            $url = $appUrl .':8000'.'/user/activate/';

    
            $activationLink = $url .urlencode($validatedData["email"])."/". $token_email; 

            // Envoi de l'e-mail d'activation
            Mail::to($validatedData["email"])->send(new inscription($activationLink));
    
            $adress = $this->get_or_create_adress ($validatedData["adress"]);

            
            $user = new User();
            $user->name = $validatedData['name'];
            $user->birthday = Carbon::createFromFormat('Y-m-d', $validatedData['birthday'])->toDateString();
            $user->email = $validatedData['email'];
            $user->mail_token = $token_email;
            $user->adresse_livraison_id =$adress->id;
            $user->adresse_facturation_id = $adress->id;
            $user->phone = $validatedData["phone"];
            $user->password = bcrypt($validatedData['password']); // Hasher le mot de passe
            $user->save();
    
            // Retourner une réponse appropriée
            return response()->json(['message' =>"sucess"], 200);
            
            
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            return response()->json(['error' => $e->getMessage()], 404);
            throw $e;
        }
    }

    public function get_connected(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                
                'connexion_email' => 'required|email|max:255',
                'connexion_password' => 'required|string|min:6',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
            }
            // Créer un nouvel utilisateur
            $validatedData=$validator->validated();

            $user = User::where('email', $validatedData["connexion_email"])->first();
    
            if (!$user) {
                return response()->json(['message' => 'Email non trouvé'], 404);
            }
        
            // Vérifier si le mot de passe correspond
            if (!Hash::check($validatedData["connexion_password"], $user->password)) {
                return response()->json(['message' => 'Mot de passe incorrect'], 401);
            }

            if ($user->email_verified_at == NULL) {
                return response()->json(['message' => 'email non verifié'], 401);
            }
            
            $adresse_livraison = Adress::where("id",$user->adresse_livraison_id)->first();
            $adresse_facturation = Adress::where("id",$user->adresse_facturation_id)->first();
            $content = [];
            $content["name"]=$user->name;
            $content["birthday"]=$user->birthday;
            $content["email"]=$user->email;
            $content["adresse_livraison"]=$adresse_livraison->adress;
            $content["adresse_facturation"]=$adresse_facturation->adress;
            $content["phone"]=$user->phone;
            $content["user_token"]=$user->user_token;
            $content["created_at"]=$user->created_at;

            return response()->json($content, 200);
            
            
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            return response()->json(['error' => $e->getMessage()], 404);
            throw $e;
        }
    }

    public function update_profil(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'user_token'=>'required|string|max:255',
                'name' => 'required|string|max:255',
                'birthday' => 'required|date_format:Y-m-d',
                'adresse_livraison' => 'required|string|max:500',
                'adresse_facturation' => 'required|string|max:500',
                'phone' => 'required|string|max:20',
                
            ]);
            
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
            }
        
            // Créer un nouvel utilisateur
            $validatedData=$validator->validated();
            $user = User::where("user_token",$validatedData["user_token"])->first();

            if (!$user) {
                return response()->json(['error' => "l'utilisateur n'existe pas"], 200);
            }
            
            $adresse_livraison= $this->get_or_create_adress($validatedData["adresse_livraison"]);
            $adresse_facturation= $this->get_or_create_adress($validatedData["adresse_facturation"]);

            $user->name = $validatedData['name'];
            $user->birthday = Carbon::createFromFormat('Y-m-d', $validatedData['birthday'])->toDateString();
            $user->adresse_livraison_id = $adresse_livraison->id;
            $user->adresse_facturation_id = $adresse_facturation->id;
            $user->phone = $validatedData["phone"];
            $user->save();
    
            // Retourner une réponse appropriée
            return response()->json(['message' => "sucess"], 200);
            
            
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            return response()->json(['message' => $e->getMessage()], 200);
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function validate($email,$token)
    {
        
        try {
            $user= User::where("email",$email)->where("mail_token",$token)->first();
            if($user) {
                if ($user->email_verified_at != NULL ) {
                    return response()->json(['message' => "acount already verified"], 200);
                }
                else {
                    $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
                    $user->save();
                    return response()->json(['message' => "acount activated"], 200);
                }
            }
            else {
                return response()->json(['message' => "no user account corresponding"], 200);
            }
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            return response()->json(['error' => $e->getMessage()], 404);
            throw $e;
        }
    }

    public function change_mail (Request $request)
    {
        
        try {
            $validator = Validator::make($request->all(), [
                
                'new_mail' => 'required|email|max:255',
                'user_token' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
            }
            // Créer un nouvel utilisateur
            $validatedData=$validator->validated();

            if (user::where("email",$validatedData["new_mail"])->first()){
                return response()->json(['error' => "email already taken"], 404);
            }
            $user=User::where("user_token",$validatedData["user_token"])->first();

            if(!$user) {
                return response()->json(['error' => "L'utilisateur demandé n'existe pas"], 404);
            }
            else {
                $token_email = Uuid::uuid4()->toString();
                $appUrl = env('APP_URL');
                $url = $appUrl .':8000'.'/user/activate_new_mail/';

        
                $activationLink = $url .urlencode($validatedData["new_mail"])."/". $token_email; 

                // Envoi de l'e-mail d'activation
                $result = Mail::to($validatedData["new_mail"])->send(new change_email($activationLink));

                if ($result) {
                    $user->pending_mail = $validatedData["new_mail"];
                    $user->mail_token = $token_email;
                    $user->save();
                    return response()->json(['message' => "sucess"], 200);
                }
                else {
                    return response()->json(['error' => "echec mail confirmation"], 404);
                }
                
            }
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            return response()->json(['error' => $e->getMessage()], 404);
            throw $e;
        }
    }

    public function validate_new_mail($email,$token)
    {
        
        try {
            $user= User::where("pending_mail",$email)->where("mail_token",$token)->first();
            if($user) {

                $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
                $user->email = $email;
                $user->save();
                return response()->json(['message' => "email_changed_successfully"], 200);
            }
            else {
                return response()->json(['message' => "no user account corresponding"], 200);
            }
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            return response()->json(['error' => $e->getMessage()], 404);
            throw $e;
        }
    }

    private function get_or_create_adress($adress_submited)
    {
        
        $adress = Adress::where ("adress",$adress_submited)->first();
            if (!$adress) {
                $adress = new Adress();
                $adress->adress=$adress_submited;
                $adress->save();
            }
            return $adress;
    }

}
