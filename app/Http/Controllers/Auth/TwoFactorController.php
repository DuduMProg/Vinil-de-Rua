<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class TwoFactorController extends Controller
{
    public function show(Request $request)
    {
        if (!$request->session()->has('2fa')) {
            return redirect()->route('login');
        }

        $code = $request->session()->get('2fa')['code'] ?? null;

        return view('auth.two-factor', compact('code'));
    }
    public function verify(Request $request)
    {
        $request->validate(['code' => ['required', 'digits:6']]);
        $data = $request->session()->get('2fa');
        if (!$data || now()->timestamp > $data['expires_at']) {
            $request->session()->forget('2fa');
            return redirect()->route('login')
                ->withErrors(['code' => 'Código expirado, faça login novamente.']);
        }
        if ($request->code !== $data['code']) {
            return back()->withErrors(['code' => 'Código inválido.']);
        }
        Auth::loginUsingId($data['user_id'], $data['remember'] ?? false);
        $request->session()->forget('2fa');
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
    }
    public function resend(Request $request)
    {
        $data = $request->session()->get('2fa');
        if (!$data) {
            return redirect()->route('login');
        }
        $code = (string) random_int(100000, 999999);
        $data['code'] = $code;
        $data['expires_at'] = now()->addMinutes(10)->timestamp;
        $request->session()->put('2fa', $data);
        //Mail::to(User::find($data['user_id'])->email)
        //  ->send(new TwoFactorCodeMail($code));
        return redirect('/two-factor?code=' . $code);
    }
}