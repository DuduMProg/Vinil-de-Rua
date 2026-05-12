<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
        // Confere e-mail/senha sem efetivar o login
        if (!Auth::validate($request->only('email', 'password'))) {
            return back()
                ->withErrors(['email' => __('auth.failed')])
                ->onlyInput('email');
        }
        $user = User::where('email', $request->email)->first();
        // Gera código de 6 dígitos e guarda na sessão
        $code = (string) random_int(100000, 999999);
        $request->session()->put('2fa', [
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10)->timestamp,
            'remember' => $request->boolean('remember'),
        ]);
        // Envia o e-mail via Resend
        //Mail::to($user->email)->send(new TwoFactorCodeMail($code));
        return redirect('/two-factor?code='.$code);

    }
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}