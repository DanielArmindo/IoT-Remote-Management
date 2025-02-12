<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\SensorController;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Venda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $controllerAPI = new SensorController();

        $alarme = '';
        $porta_funcionarios = '';
        $porta_descargas = '';

        $carrinho = Venda::where('cod_utilizador', Auth::user()->id)->where('estado', 'carrinho')->first();

        if ($request->user()->type_user === 'S') {
            // API Endpoint: api/estado
            $alarme = $controllerAPI->estadoSistema(new Request(['alarme' => 1]))->getData(true);
            $alarme = $alarme['alarme'];

            $porta_funcionarios = $controllerAPI->estadoSistema(new Request(['porta_funcionarios' => 1]))->getData(true);
            $porta_funcionarios = $porta_funcionarios['estado'];

            $porta_descargas = $controllerAPI->estadoSistema(new Request(['porta_descargas' => 1]))->getData(true);
            $porta_descargas = $porta_descargas['estado'];
        }

        return view('dashboard', ['carrinho' => $carrinho, 'alarme' => $alarme, 'porta_funcionarios' => $porta_funcionarios, 'porta_descargas' => $porta_descargas]);
    }

    // To update user type
    public function index_profile(Request $request): View
    {
        return view('profile_type', [
            'user' => $request->user(),
        ]);
    }

    public function update_type(Request $request): RedirectResponse
    {
        $validatedData = $request['type_user'];

        $allowedTypes = ['V', 'A', 'S'];
        if (!in_array($validatedData, $allowedTypes)) {
            return redirect()->back()->withErrors(['type_user' => 'Invalid user type'])->withInput();
        }

        $request->user()->type_user = $validatedData;

        $request->user()->save();
        return Redirect::route('profile.type')->with('status', 'profile-updated');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
