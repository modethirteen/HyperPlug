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
namespace modethirteen\Http\Tests\HttpResult;

use modethirteen\Http\Content\ContentType;
use modethirteen\Http\HttpResult;
use modethirteen\Http\Tests\HttpPlugTestCase;

class __clone_Test extends HttpPlugTestCase {

    /**
     * @test
     */
    public function Can_deep_copy() {

        // arrange
        $result = (new HttpResult());
        $result->setVal('type', ContentType::JSON);

        // act
        $cloned = clone $result;
        $cloned->setVal('type', ContentType::XML);

        // assert
        $this->assertEquals(ContentType::JSON, $result->getVal('type'));
        $this->assertEquals(ContentType::XML, $cloned->getVal('type'));
    }
}
