<?php declare(strict_types=1);
/**
 * HttpPlug
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
namespace modethirteen\Http\Tests\XUri;

use modethirteen\Http\Tests\HttpPlugTestCase;
use modethirteen\Http\XUri;

class getQueryParam_Test extends HttpPlugTestCase {

    /**
     * @test
     */
    public function Can_get_param() {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/foo/bar?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->getQueryParam('a');

        // assert
        $this->assertEquals('b', $result);
    }

    /**
     * @test
     */
    public function Can_get_empty_param() {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/foo/bar?a=b&c=d#fragment';

        // act
        $result = XUri::tryParse($uriStr)->getQueryParam('somerandomparam');

        // assert
        $this->assertEquals('', $result);
    }

    /**
     * @test
     */
    public function Can_get_numeric_param() {

        // arrange
        $uriStr = 'http://user:password@test.mindtouch.dev/foo/bar?a=b&123=d&c=#fragment';

        // act
        $result = XUri::tryParse($uriStr)->getQueryParam('123');

        // assert
        $this->assertEquals('d', $result);
    }
}