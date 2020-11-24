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
namespace modethirteen\Http\Tests\HttpPlug\CurlInvoke;

use modethirteen\Http\Tests\HttpPlugTestCase;

class withTimeout_Test extends HttpPlugTestCase {

    /**
     * @test
     */
    public function Can_update_request_timeout_before_invocation() {

        // arrange
        $plug = $this->newHttpBinPlug()->at('delay', '10');

        // act
        $result = $plug->withTimeout(5)->get();

        // assert
        $this->assertEquals(0, $result->getStatus());
        $this->assertEquals(28, $result->getVal('errno'));
    }
}
