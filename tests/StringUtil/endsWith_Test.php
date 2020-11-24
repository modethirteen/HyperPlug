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
namespace modethirteen\Http\Tests\StringUtil;

use modethirteen\Http\StringUtil;
use modethirteen\Http\Tests\HttpPlugTestCase;

class endsWith_Test extends HttpPlugTestCase  {

    /**
     * @test
     */
    public function String_ends_with() {

        // act
        $result = StringUtil::endsWith('foobar', 'ar');

        // assert
        $this->assertEquals(true, $result);
    }

    /**
     * @test
     */
    public function String_does_not_end_with() {

        // act
        $result = StringUtil::endsWith('foobar', 'gak');

        // assert
        $this->assertEquals(false, $result);
    }
}