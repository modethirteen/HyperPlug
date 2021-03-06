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

use InvalidArgumentException;

/**
 * Class FileContent
 *
 * @package modethirteen\Http\Content
 */
class FileContent implements IContent {

    /**
     * @var string
     */
    private string $filePath;

    /**
     * @var ContentType|null
     */
    private ?ContentType $contentType;

    /**
     * @param string $filePath
     * @param ContentType|null $contentType - if null or stream the content type will be determined from file path
     */
    public function __construct(string $filePath, ContentType $contentType = null) {
        if(!is_file($filePath)) {
            throw new InvalidArgumentException('File path does not exist: ' . $filePath);
        }
        $this->filePath = $filePath;
        if($contentType === null) {
            $contentType = ContentType::newFromString(ContentType::STREAM);
        }
        if($contentType !== null && $contentType->isStream()) {
            $finfo = finfo_open(FILEINFO_MIME);
            if($finfo !== false) {
                $text = finfo_file($finfo, $filePath);
                if($text !== false) {
                    $contentType = ContentType::newFromString($text);
                }
                finfo_close($finfo);
            }
        }
        $this->contentType = $contentType;
    }

    public function getContentType() : ?ContentType {
        return $this->contentType;
    }

    public function toRaw() : string {
        return $this->filePath;
    }

    public function toString() : string {
        return $this->filePath;
    }

    public function __toString() : string {
        return $this->toString();
    }
}
