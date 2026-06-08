<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\Product;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

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
    public function show(Request $request): View
    {
        return view('profile.view', [
            'user' => $request->user(),

        ]);
    }

    public function recent(): View
    {
        $produtosIds = session()->get('produtos_vistos', []);
        $categoriasIds = session()->get('categorias_vistas', []);

        $produtos = empty($produtosIds)
            ? collect()
            : Product::with(['images', 'tag'])
                ->whereIn('id', $produtosIds)
                ->get()
                ->sortBy(fn($p) => array_search($p->id, $produtosIds));

        $categorias = empty($categoriasIds)
            ? collect()
            : Category::whereIn('id', $categoriasIds)
                ->get()
                ->sortBy(fn($c) => array_search($c->id, $categoriasIds));

        return view('profile.recently-viewed', [
            'produtos' => $produtos,
            'categorias' => $categorias,
        ]);
    }

    public function orders(Request $request): View
    {
        $orders = \App\Models\Order::with(['items.product.images'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('profile.orders', [
            'orders' => $orders,
            'user' => $request->user(),
        ]);
    }
}
