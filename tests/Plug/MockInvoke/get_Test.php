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
namespace modethirteen\Http\Tests\Plug\MockInvoke;

use modethirteen\Http\Content\ContentType;
use modethirteen\Http\Exception\ResultParserContentExceedsMaxContentLengthException;
use modethirteen\Http\Headers;
use modethirteen\Http\Mock\MockPlug;
use modethirteen\Http\Parser\JsonParser;
use modethirteen\Http\Parser\SerializedPhpArrayParser;
use modethirteen\Http\Plug;
use modethirteen\Http\Result;
use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

/**
 * @note mock large response content lengths
 */
class get_Test extends PlugTestCase  {

    /**
     * @test
     */
    public function Can_unserialize_json_when_max_content_length_is_not_reached() {

        // arrange
        $uri = XUri::tryParse('test://example.com/foo');
        $body = json_encode(['foo' => ['bar', 'baz']]);
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(Plug::METHOD_GET, $uri),
            (new Result())
                ->withStatus(200)
                ->withHeaders(Headers::newFromHeaderNameValuePairs([
                    [Headers::HEADER_CONTENT_TYPE, ContentType::JSON],
                    [Headers::HEADER_CONTENT_LENGTH, strval(strlen($body))]
                ]))
                ->withBody($body)
        );
        $plug = new Plug($uri);

        // act
        $parser = (new JsonParser())->withMaxContentLength(50000);
        $result = $plug->withResultParser($parser)->get();

        // assert
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals(['foo' => ['bar', 'baz']], $result->getBody()->toArray());
    }

    /**
     * @test
     */
    public function Can_unserialize_json_with_custom_media_type_when_max_content_length_is_not_reached() {

        // arrange
        $uri = XUri::tryParse('test://example.com/foo');
        $body = json_encode(['foo' => ['bar', 'baz']]);
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(Plug::METHOD_GET, $uri),
            (new Result())
                ->withStatus(200)
                ->withHeaders(Headers::newFromHeaderNameValuePairs([
                    [Headers::HEADER_CONTENT_TYPE, 'application/jwk-set+json; charset=UTF-8'],
                    [Headers::HEADER_CONTENT_LENGTH, strval(strlen($body))]
                ]))
                ->withBody($body)
        );
        $plug = new Plug($uri);

        // act
        $parser = (new JsonParser())->withMaxContentLength(50000);
        $result = $plug->withResultParser($parser)->get();

        // assert
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals(['foo' => ['bar', 'baz']], $result->getBody()->toArray());
    }

    /**
     * @test
     */
    public function Will_throw_if_cannot_unserialize_json() {

        // arrange
        $uri = XUri::tryParse('test://example.com/foo');
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(Plug::METHOD_GET, $uri),
            (new Result())
                ->withStatus(200)
                ->withHeaders(Headers::newFromHeaderNameValuePairs([
                    [Headers::HEADER_CONTENT_TYPE, ContentType::JSON],
                    [Headers::HEADER_CONTENT_LENGTH, '1000']
                ]))
        );
        $plug = new Plug($uri);

        // act
        $resultContentLength = 0;
        $maxContentLength = 0;
        $exceptionThrown = false;
        try {
            $parser = (new JsonParser())->withMaxContentLength(500);
            $plug->withResultParser($parser)->get();
        } catch(ResultParserContentExceedsMaxContentLengthException $e) {
            $resultContentLength = $e->getResultContentLength();
            $maxContentLength = $e->getMaxContentLength();
            $exceptionThrown = true;
        }

        // assert
        $this->assertEquals(1000, $resultContentLength);
        $this->assertEquals(500, $maxContentLength);
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     */
    public function Can_unserialize_php_when_max_content_length_is_not_reached() {

        // arrange
        $uri = XUri::tryParse('test://example.com/foo');
        $body = serialize(['foo' => ['bar', 'baz']]);
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(Plug::METHOD_GET, $uri),
            (new Result())
                ->withStatus(200)
                ->withHeaders(Headers::newFromHeaderNameValuePairs([
                    [Headers::HEADER_CONTENT_TYPE, ContentType::PHP],
                    [Headers::HEADER_CONTENT_LENGTH, strval(strlen($body))]
                ]))
                ->withBody($body)
        );
        $plug = new Plug($uri);

        // act
        $parser = (new SerializedPhpArrayParser())->withMaxContentLength(50000);
        $result = $plug->withResultParser($parser)->get();

        // assert
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals(['foo' => ['bar', 'baz']], $result->getBody()->toArray());
    }

    /**
     * @test
     */
    public function Will_throw_if_cannot_unserialize_php() {

        // arrange
        $uri = XUri::tryParse('test://example.com/foo');
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(Plug::METHOD_GET, $uri),
            (new Result())
                ->withStatus(200)
                ->withHeaders(Headers::newFromHeaderNameValuePairs([
                    [Headers::HEADER_CONTENT_TYPE, ContentType::PHP],
                    [Headers::HEADER_CONTENT_LENGTH, '5000']
                ]))
        );
        $plug = new Plug($uri);

        // act
        $resultContentLength = 0;
        $maxContentLength = 0;
        $exceptionThrown = false;
        try {
            $parser = (new SerializedPhpArrayParser())->withMaxContentLength(200);
            $plug->withResultParser($parser)->get();
        } catch(ResultParserContentExceedsMaxContentLengthException $e) {
            $resultContentLength = $e->getResultContentLength();
            $maxContentLength = $e->getMaxContentLength();
            $exceptionThrown = true;
        }

        // assert
        $this->assertEquals(5000, $resultContentLength);
        $this->assertEquals(200, $maxContentLength);
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     */
    public function Can_unserialize_empty_php_body() {

        // arrange
        $uri = XUri::tryParse('test://example.com/foo');
        MockPlug::register(
            $this->newDefaultMockRequestMatcher(Plug::METHOD_GET, $uri),
            (new Result())
                ->withStatus(200)
                ->withHeaders(Headers::newFromHeaderNameValuePairs([
                    [Headers::HEADER_CONTENT_TYPE, ContentType::PHP],
                    [Headers::HEADER_CONTENT_LENGTH, '0']
                ]))
                ->withBody('')
        );
        $plug = new Plug($uri);

         // act
        $parser = (new SerializedPhpArrayParser())->withMaxContentLength(50000);
        $result = $plug->withResultParser($parser)->get();

        // assert
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals('', $result->getBody()->getVal('body'));
    }
}
