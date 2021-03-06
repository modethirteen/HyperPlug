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
namespace modethirteen\Http\Tests\Mock\MockRequestMatcher;

use modethirteen\Http\Headers;
use modethirteen\Http\Mock\MockRequestMatcher;
use modethirteen\Http\Plug;
use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

class getBody_Test extends PlugTestCase  {

    /**
     * @test
     */
    public function Can_get_body() {

        // arrange
        $matcher = (new MockRequestMatcher(Plug::METHOD_POST, XUri::tryParse('http://example.com/bazz')))
            ->withHeaders(Headers::newFromHeaderNameValuePairs([
                ['X-Qux', 'foo']
            ]))
            ->withBody('bar');

        // act
        $result = $matcher->getBody();

        // assert
        $this->assertEquals('bar', $result);
    }
}
