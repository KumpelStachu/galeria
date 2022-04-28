<?php
namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

final class JwtDecorator implements OpenApiFactoryInterface
{
    public function __construct(
        private OpenApiFactoryInterface $decorated
    ) {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Token'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ]);
        $schemas['Credentials'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'user',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'pass',
                ],
            ],
        ]);

        $registerPathItem = new Model\PathItem(
            ref: 'Register',
            post: new Model\Operation(
                operationId: 'postRegisterItem',
                tags: ['Auth'],
                responses: [
                    '200' => [
                        'description' => 'Get JWT token',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Token',
                                ],
                            ],
                        ],
                    ],
                    
                    '400' => [
                        'description' => 'username/password is required'
                    ],
                    '409' => [
                        'description' => 'user already exists',
                        // 'content' => [
                        //     'application/json' => [
                        //         'schema' => [
                        //             'type' => 'object',
                        //             'properties' => [
                        //                 'type' => [
                        //                     'type' => 'string',
                        //                     'example' => 'https://tools.ietf.org/html/rfc2616#section-10'
                        //                 ],
                        //                 'title' => [
                        //                     'type' => 'string',
                        //                     'example' => 'An error occurred'
                        //                 ],
                        //                 'status' => [
                        //                     'type' => 'integer',
                        //                     'example' => 409
                        //                 ],
                        //                 'detail' => [
                        //                     'type' => 'string',
                        //                     'example' => 'Conflict'
                        //                 ],
                        //             ]
                        //         ],
                        //     ],
                        // ],
                    ],
                ],
                summary: 'Register',
                requestBody: new Model\RequestBody(
                    description: 'Register',
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials',
                            ],
                        ],
                    ]),
                ),
            ),
        );
        $tokenPathItem = new Model\PathItem(
            ref: 'JWT Token',
            post: new Model\Operation(
                operationId: 'postCredentialsItem',
                tags: ['Auth'],
                responses: [
                    '200' => [
                        'description' => 'Get JWT token',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Token',
                                ],
                            ],
                        ],
                    ],
                ],
                summary: 'Get JWT token to login.',
                requestBody: new Model\RequestBody(
                    description: 'Generate new JWT Token',
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials',
                            ],
                        ],
                    ]),
                ),
            ),
        );
        
        $openApi->getPaths()->addPath('/api/register', $registerPathItem);
        $openApi->getPaths()->addPath('/api/token', $tokenPathItem);

        return $openApi;
    }
}
