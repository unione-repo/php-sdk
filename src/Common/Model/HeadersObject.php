<?php

declare(strict_types=1);

namespace UniOne\Common\Model;

use UniOne\Client\Data;

/**
 * Contains email headers, maximum 50. Only headers with “X-” name prefix are accepted, all other are ignored,
 * for example X-UNIONE-Global-Language, X-UNIONE-Template-Engine. Standard headers "To," "CC," and "BCC" are
 * passed without the "X-." Yet, they are processed in a particular way and, as a result, have a number of
 * restrictions. You can find more details about it [here](/cc-and-bcc). If our support have approved omitting
 * standard unsubscription block for you, you can also pass List-Unsubscribe, List-Subscribe, List-Help,
 * List-Owner, List-Archive, In-Reply-To and References headers.
 */
final class HeadersObject implements \JsonSerializable
{
    public function __construct(
        /**
         * The language of the unsubscribe footer and unsubscribe page. Languages supported are: "be", "de", "en", "es",
         * "fr", "it", "pl", "pt", "ru", "ua", "kz".
         */
        public ?string $xUNIONEGlobalLanguage = null,
        /**
         * The template engine for handling the substitutions(merge tags), “simple”, “velocity”, “liquid” or “none”.
         * Default value is “simple”. Has a priority over the value allowed in the “template_engine” parameter.
         */
        public ?string $xUNIONETemplateEngine = null,
        /**
         * Fields beyond the named ones (any other key of the JSON object): name => value. A named field wins over the
         * same key here.
         *
         * @var array<string, string>
         */
        public array $extra = [],
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            xUNIONEGlobalLanguage: Data::string($data['X-UNIONE-Global-Language'] ?? null),
            xUNIONETemplateEngine: Data::string($data['X-UNIONE-Template-Engine'] ?? null),
            extra: Data::extra($data, ['X-UNIONE-Global-Language', 'X-UNIONE-Template-Engine'], static fn ($item) => Data::string($item) ?? ''),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'X-UNIONE-Global-Language' => $this->xUNIONEGlobalLanguage,
            'X-UNIONE-Template-Engine' => $this->xUNIONETemplateEngine,
        ], static fn (mixed $value): bool => $value !== null) + $this->extra;
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    public function jsonSerialize(): mixed
    {
        return Data::object($this->toArray());
    }
}
