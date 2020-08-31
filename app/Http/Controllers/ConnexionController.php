<?php

namespace App\Http\Controllers;

use Carbon\Carbon;


use App\Account;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ConnexionController extends Controller
{
    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ], [
            'email.required' => 'Veillez saissir votre e-mail',
            'email.email' => "format de l'email incorrect",
            'password.required' => "Veillez saisir votre mot de passe",
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ["Les informations d'identification fournies sont incorrectes."]
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response('Loggedout', 200);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:10',
            'email' => 'required|email',
            'password' => 'required',
            'pin_code' => 'required|string|digits_between:4,4',

        ]);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->pin_code = Hash::make($request->pin_code);

        $user->save();
        return response()->json('Registred', 200);
    }

    public function getCards(Request $request)
    {
        return $request->user()->accounts()->get();
    }

    public function addTransaction(Request $request)
    {

        $request->validate([
            'to' => 'required',
            'account_code' => 'required',
            'ammount' => 'required',
            'card_id' => 'required'
        ]);

        $card = Account::where('id', $request->card_id)->first();

        if ($card->sold < $request->ammount) {
            return response([
                'message' => 'fonds inssufissants pour completer la transaction',
            ], 403);
        }
        $account = Account::where('name', $request->account_code)->first();

        $card->sold -= $request->ammount;
        $account->sold += $request->ammount;

        $card->updated_at = now();
        $account->updated_at = now();

        $card->save();
        $account->save();

        $transaction = new Transaction();
        $transaction->user_id = $request->user()->id;
        $transaction->account_id = $account->id;
        $transaction->ammount = $request->ammount;
        $transaction->save();

        return response([
            'message' => 'success',
        ], 200);
    }

    public function singleCard(Request $request)
    {
        $card = Account::find($request->card_id);
        return response([
            'card' => $card
        ], 200);
    }

    public function addCard(Request $request)
    {
        //$exp = Carbon::createFromFormat('Y-m', now())->toDateTimeString();
        $exp = Carbon::now()->format('M, Y');
        $request->validate([
            'name' => 'required|max:40|string',
            'card_number' => 'required|integer|digits_between:15,16',
            'type' => 'required|string',
            'ccv' => 'required|string|digits_between:4,4',
            'exp' => 'required|after_or_equal:exp',

        ]);
        $account = new Account();
        $account->user_id = auth()->user()->id;
        $account->name = $request->name;
        $account->card_number = $request->card_number;
        $account->type = $request->type;
        $account->ccv = Hash::make($request->ccv);
        $account->exp = $request->exp;
        $account->sold = rand(2500, 80000);
        $account->created_at = now();
        $account->updated_at = now();
        $account->save();

        return response([
            'account' => $account
        ], 200);
    }

    public function checkPin(Request $request)
    {
        $request->validate([
            'pin_code' => 'required|string|digits_between:4,4',
        ]);
        $user = Auth::user();
        if (!$user || !Hash::check($request->pin_code, $user->pin_code)) {
            throw ValidationException::withMessages([
                'message' => ["code Pin incorrecte!!"]
            ]);
        } else {
            return response([
                'user' => $user
            ], 200);
        }
    }
}
