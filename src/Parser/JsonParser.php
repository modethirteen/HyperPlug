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
namespace modethirteen\Http\Parser;

use modethirteen\Http\HttpResult;

/**
 * Class JsonParser
 *
 * @package modethirteen\Http\Parser
 */
class JsonParser extends HttpResultParserBase implements IHttpResultParser {

    public function withMaxContentLength(int $length) : IHttpResultParser {
        $parser = clone $this;
        $parser->maxContentLength = $length;
        return $parser;
    }

    public function toParsedResult(HttpResult $result) : HttpResult {
        $contentType = $result->getContentType();
        if($contentType !== null && $contentType->isJson()) {

            /** @noinspection PhpUnhandledExceptionInspection */
            $this->validateContentLength($result);
            $body = $result->getVal('body', '');
            if(is_string($body)) {
                $result->setVal('body', json_decode($body, true));
            }
        }
        return $result;
    }
}