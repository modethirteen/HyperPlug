<?php declare(strict_types=1);
/**
 * HyperPlug
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace modethirteen\Http\Tests\Result;

use modethirteen\Http\Content\ContentType;
use modethirteen\Http\Result;
use modethirteen\Http\Tests\PlugTestCase;

class getContentType_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_get_content_type() {

        // arrange
        $data = [
            'status' => 200,
            'body' => [
                'foo' => [
                    '@id' => '123',
                    '@baz' => 'qux',
                    'baz' => [
                        '#text' => 'fred',
                        '@foo' => 'abc'
                    ]
                ]
            ],
            'type' => 'application/json; charset=utf-8'
        ];
        $result = new Result($data);

        // act
        $result = $result->getContentType();

        // assert
        $this->assertInstanceOf(ContentType::class, $result);
        $this->assertEquals('application/json; charset=utf-8', $result->toString());
    }

    /**
     * @test
     */
    public function Can_get_null_if_content_type_is_not_set() {

        // arrange
        $data = [
            'status' => 200,
            'body' => [
                'foo' => [
                    '@id' => '123',
                    '@baz' => 'qux',
                    'baz' => [
                        '#text' => 'fred',
                        '@foo' => 'abc'
                    ]
                ]
            ]
        ];
        $result = new Result($data);

        // act
        $result = $result->getContentType();

        // assert
        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function Can_get_null_if_content_type_is_invalid() {

        // arrange
        $data = [
            'status' => 200,
            'body' => [
                'foo' => [
                    '@id' => '123',
                    '@baz' => 'qux',
                    'baz' => [
                        '#text' => 'fred',
                        '@foo' => 'abc'
                    ]
                ]
            ],
            'type' => 'quxx'
        ];
        $result = new Result($data);

        // act
        $result = $result->getContentType();

        // assert
        $this->assertNull($result);
    }
}
