<?php
// app/Services/Auth/JsonGuard.php 
namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use LogicException;

class JwtGuard implements Guard
{
    protected $request;
    protected $provider;
    protected $user;
    private $payload;
 
  /** 
* Create a new authentication guard. 
* 
* @param \Illuminate\Contracts\Auth\UserProvider $provider 
* @param \Illuminate\Http\Request $request 
* @return void 
*/
    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
        $this->payload = $this->getPayload();
        $this->user = $this->getUser();
    }
 
    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check(){    
        $date = new Carbon();
        $currentDate = $date->getTimestamp();

        if($this->payload === false) return false;

        if(
            $currentDate >= $this->payload->tokenInfo->nbt 
            && $currentDate < $this->payload->tokenInfo->exp
        ) return true;

        return false;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest(){}

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user(){
        return $this->user;
    }

    public function role(){
        return $this->user->role;
    }


    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id(){
        return !is_null($this->user) ? $this->user->id : null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = []){}

    /**
     * Determine if the guard has a user instance.
     *
     * @return bool
     */
    public function hasUser(){}

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return $this
     */
    public function setUser(Authenticatable $user){}

    private function getUser()
    {
        if($this->payload === false) return null;

        return $this->provider->retrieveById($this->payload->user->id);
    }

    private function getPayload()
    {
        if(!request()->hasHeader('Authorization')) return false;

        try {
            return JWT::decode(request()->bearerToken(), new Key(env('JWT_SECRET'), 'HS256'));        
        } catch (LogicException $e) {
            return false;
        }
        
    }
}