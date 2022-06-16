<?php

namespace Gamify\Http\Controllers\Auth;

use Gamify\Http\Controllers\Controller;
use Gamify\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ChangePasswordController extends Controller
{
    use RedirectsUsers;

    /**
     * Constant representing an invalid password.
     *
     * @var string
     */
    const INVALID_PASSWORD = 'passwords.invalid';

    /**
     * Constant representing a successfully change password.
     *
     * @var string
     */
    const PASSWORD_CHANGED = 'passwords.changed';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showChangePasswordForm(): View
    {
        return view('auth.change_password');
    }

    public function change(Request $request): RedirectResponse
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $credentials = $this->credentials($request);

        $response = $this->validateAndPasswordChange($credentials);

        return $response == self::PASSWORD_CHANGED
            ? $this->sendChangedResponse($response)
            : $this->sendChangedFailedResponse($response);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'current-password' => [
                'required',
            ],
            'new-password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages(): array
    {
        return [];
    }

    /**
     * Get the password change credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request): array
    {
        return $request->only(
            'current-password', 'new-password', 'new-password_confirmation'
        );
    }

    /**
     * Validate a password change request and update password of the user.
     *
     * @param  array  $credentials
     * @return string|Authenticatable
     */
    protected function validateAndPasswordChange(array $credentials)
    {
        $user = $this->validateChange($credentials);

        // If the responses from the validate method is not a user instance, we will
        // assume that it is a redirect and simply return it from this method and
        // the user is properly redirected having an error message on the post.
        if (! $user instanceof User) {
            return $user;
        }

        $this->setNewPassword($user, $credentials['new-password']);

        return self::PASSWORD_CHANGED;
    }

    /**
     * Validate a password change request with the given credentials.
     *
     * @param  array  $credentials
     * @return string|Authenticatable
     *
     * @throws \UnexpectedValueException
     */
    protected function validateChange(array $credentials)
    {
        if (is_null($user = $this->getUser($credentials))) {
            return self::INVALID_PASSWORD;
        }

        return $user;
    }

    /**
     * Get the user with the given credentials.
     *
     * @param  array  $credentials
     * @return null|Authenticatable
     */
    protected function getUser(array $credentials): ?Authenticatable
    {
        /** @var User */
        $user = Auth::user();

        // Using current email from user, and current password sent with the request to authenticate the user
        if (! $this->guard()->attempt([
            $user->getAuthIdentifierName() => $user->getAuthIdentifier(),
            'password' => $credentials['current-password'],
        ])) {
            // authentication fails
            return null;
        }

        return $user;
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Set the given user's password.
     *
     * @param  \Gamify\Models\User  $user
     * @param  string  $password
     * @return void
     */
    protected function setNewPassword(User $user, string $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        $this->guard()->login($user);
    }

    /**
     * Set the user's password.
     *
     * @param  \Gamify\Models\User  $user
     * @param  string  $password
     * @return void
     */
    protected function setUserPassword(User $user, string $password): void
    {
        // Password hash is done by a mutator on User model.
        // $user->password = Hash::make($password);
        $user->password = $password;
    }

    protected function sendChangedResponse(string $response): RedirectResponse
    {
        return redirect($this->redirectPath())
            ->with('success', __($response));
    }

    protected function sendChangedFailedResponse(string $response): RedirectResponse
    {
        return redirect()->back()
            ->withErrors(['password' => __($response)]);
    }

    /**
     * Where to redirect users after registration.
     *
     * @return string
     */
    protected function redirectTo(): string
    {
        return route('password.change');
    }
}
