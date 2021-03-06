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
namespace modethirteen\Http\Tests\StringUtil;

use modethirteen\Http\StringUtil;
use modethirteen\Http\Tests\PlugTestCase;

class startsWithInvariantCase_Test extends PlugTestCase {

    /**
     * @test
     */
    public function String_starts_with() {

        // act
        $result = StringUtil::startsWithInvariantCase('FOObAR', 'fo');

        // assert
        $this->assertEquals(true, $result);
    }

    /**
     * @test
     */
    public function String_does_not_start_with() {

        // act
        $result = StringUtil::startsWithInvariantCase('foobar', 'gak');

        // assert
        $this->assertEquals(false, $result);
    }
}
