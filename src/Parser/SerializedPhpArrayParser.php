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
namespace modethirteen\Http\Parser;

use modethirteen\Http\Result;

/**
 * Class SerializedPhpArrayParser
 *
 * @package modethirteen\Http\Parser
 */
class SerializedPhpArrayParser extends ResultParserBase implements IResultParser {

    public function withMaxContentLength(int $length) : IResultParser {
        $parser = clone $this;
        $parser->maxContentLength = $length;
        return $parser;
    }

    public function toParsedResult(Result $result) : Result {

        // TODO (modethirteen, 20180422): ensure its safe to use ContentType::PHP here
        $contentType = $result->getContentType();
        if($contentType !== null && $contentType->toSubType() === 'php') {
            $this->validateContentLength($result);
            $body = $result->getVal('body', '');
            if(is_string($body) && $body !== '') {
                $result->setVal('body', unserialize($body));
            }
        }
        return $result;
    }
}
