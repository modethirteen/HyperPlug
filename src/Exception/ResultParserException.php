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
namespace modethirteen\Http\Exception;

use Exception;
use modethirteen\Http\Result;

/**
 * Class ApiResultException
 *
 * @package modethirteen\Http\Exception
 */
class ResultParserException extends Exception {

    /**
     * @var Result
     */
    private Result $result;

    /**
     * @param Result $result
     * @param string $reason
     */
    public function __construct(Result $result, string $reason) {
        parent::__construct('Cannot parse result content: ' . $reason);
        $this->result = $result;
    }

    /**
     * @return Result
     */
    public function getResult() : Result {
        return $this->result;
    }
}
