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
namespace modethirteen\Http\Content;

/**
 * Class UrlEncodedFormDataContent
 *
 * @package modethirteen\Http\Content
 */
class UrlEncodedFormDataContent implements IContent {

    /**
     * @var ContentType|null
     */
    private $contentType;

    /**
     * @var string[]
     */
    private array $data;

    /**
     * @param string[] $data - name/value pairs of form data
     */
    public function __construct(array $data) {
        $this->contentType = ContentType::newFromString(ContentType::FORM_URLENCODED);
        $this->data = $data;
    }

    public function __clone() {

        // deep copy internal data objects and arrays
        $this->contentType = unserialize(serialize($this->contentType));
        $this->data = unserialize(serialize($this->data));
    }

    public function getContentType() : ?ContentType {
        return $this->contentType;
    }

    public function toRaw() : string {
        return $this->toString();
    }

    public function toString() : string {
        return http_build_query($this->data);
    }

    public function __toString() : string {
        return $this->toString();
    }
}
