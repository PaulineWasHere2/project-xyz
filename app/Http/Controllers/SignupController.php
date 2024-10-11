<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use App\Services\CodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SignupController extends Controller
{
    public function signup_terms(Code $code):View {
        $invitedUser = $code->host_id;
        return view('auth.signup-terms', ['code'=>$code]);
    }
    public function signup_account(Code $code):View {
        $invitedUser = $code->host_id;
        return view('auth.signup-account', ['code'=>$code, 'invitedUser'=>$invitedUser]);
    }
    public function handleForm(Request $request)
    {
        // Vérifie si la checkbox est cochée
        if ($request->has('accept_terms')) {
            // Redirige vers la page /signup
            return redirect()->route('signup-account');
        } else {
            // Si la checkbox n'est pas cochée, redirige vers le formulaire avec un message d'erreur
            return redirect()->back()->with('error', 'Veuillez accepter les conditions pour continuer.');
        }
    }
        public function createUser(Request $request, Code $code)
    {
        // Validation des données du formulaire
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        // Si la validation échoue, rediriger avec les erreurs
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Création d'un nouvel utilisateur
        $user = new User();
        $user->name = fake()->name();
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password')); // Hashage du mot de passe
        $user->save(); // Sauvegarde dans la base de données

        // Génération de 5 codes et association à l'utilisateur
        $codes = CodeService::generateCode(5); // Assurez-vous que cette méthode génère 5 codes
        foreach ($codes as $codeValue) {
            $code = new Code();
            $code->code = $codeValue;  // Code généré
            $code->host_id = $user->id;  // Association avec l'utilisateur
            $code->save();  // Sauvegarde du code dans la base de données
        }

        // Mettre à jour de code d'invitation
        $code->update([
            'guest_id' => $user->id,
            'consumed_at' => now()
        ]);

        // Redirige l'utilisateur après l'inscription
        return redirect()->intended('/')->with('success', 'Votre compte a été créé avec succès!');
    }
    public function verifyCode(Request $request)
    {
       $validator = Validator::make($request->all());
    }
}
