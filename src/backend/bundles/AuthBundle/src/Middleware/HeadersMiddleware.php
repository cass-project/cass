<?php
namespace Auth\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Service\AuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Stream;
use Zend\Stratigility\MiddlewareInterface;
use GuzzleHttp\Psr7\Request as R;
class HeadersMiddleware implements MiddlewareInterface
{
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {

        $data = json_encode([
            'email' => "artem.baydin@cass.io",
            'password' => 'a1fsfsA',
            'passwordAgain'=> 'a1fsfsA'
        ]);

        $r = new R("POST","",["Content-type"=>"text/json"],$data);
        //$body = new Stream('php://memory','w+');
        //$body->write($data);

        //$r = ServerRequestFactory::fromGlobals();

        //$r->withBody($body);

        var_dump($request);
        //$this->authService->signIn($r);

        die;




        $responseBuilder = new GenericRESTResponseBuilder($response);
        $responseBuilder->setStatusSuccess();
        /*

        try {
            $this->authService->signIn($request);
            $responseBuilder->setStatusSuccess();
        }catch (UnknownActionException $e) {
            $responseBuilder
                ->setStatusNotAllowed()
                ->setError($e)
            ;
        }

        */
        return $responseBuilder->build();
    }

}