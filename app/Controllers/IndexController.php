<?php
namespace App\Controllers;

use Swoft\App;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Log\Log;
use Swoft\View\Bean\Annotation\View;
use Swoft\Contract\Arrayable;
use Swoft\Http\Server\Exception\BadRequestException;
use Swoft\Http\Message\Server\Response;
use Swoft\Http\Message\Server\Request;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\BooksLogic;

/**
 * Class IndexController
 * @Controller()
 */
class IndexController
{
    /**
     *
     * @Inject()
     * @var BooksLogic
     */
    private $booksLogic;

    /**
     * @RequestMapping("/")
     * @param Response $response
     * @return Response
     */
    public function redirect(Response $response): Response
    {
        return $response->redirect('/books/');
    }

    /**
     * @RequestMapping("/login")
     * @param Response $response
     * @return Response
     */
    public function login(Response $response): Response
    {
        $client = $this->booksLogic->getGoogleClient();
        $scopes = [ \Google_Service_Oauth2::USERINFO_PROFILE ];
        $authUrl = $client->createAuthUrl($scopes);

        return $response->redirect($authUrl);
    }

    /**
     * @RequestMapping("/login/callback")
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function callback(Request $request, Response $response): Response
    {
        $code = $request->getQueryParams()['code'];
        $client = $this->booksLogic->getGoogleClient();
        $authResponse = $client->fetchAccessTokenWithAuthCode($code);

        if ($client->getAccessToken()) {
            $userInfo = $client->verifyIdToken();

            session()->put('user', [
                'id'      => $userInfo['sub'],
                'name'    => $userInfo['name'],
                'picture' => $userInfo['picture'],
            ]);
        }
        return $response->redirect("/", 302);
    }

    /**
     * @RequestMapping("/logout")
     * @param Response $response
     * @return Response
     */
    public function logout(Response $response): Response
    {
        session()->flush();
        return $response->redirect("/");
    }
}
