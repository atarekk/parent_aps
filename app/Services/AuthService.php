<?php


namespace App\Services;


use App\Traits\ResponseTrait;

class AuthService
{
    use ResponseTrait;

    /**this function to check user credentials in database if true will return user token
     * @param object $credentials
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(object $credentials)
    {

        $credentials = [
            'email' => $credentials->email,
            'password' => $credentials->password
        ];
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('parentApsTask')->accessToken;
            return $this->sendSuccessResponse(['token-type' => 'Bearer',
                'token' => $token], "User login successfully");
        } else {
            return $this->sendErrorResponse(["Unauthenticated"], 403);
        }
    }


}
