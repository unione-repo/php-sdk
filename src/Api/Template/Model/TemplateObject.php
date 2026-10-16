<?php

declare(strict_types=1);

namespace UniOne\Api\Template\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\AttachmentsArrayItem;
use UniOne\Common\Model\BodyObject;
use UniOne\Common\Model\HeadersObject;
use UniOne\Common\Model\InlineAttachmentsArrayItem;
use UniOne\Common\Model\TemplateEngine;

/**
 * Object with all the template properties.
 */
final class TemplateObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Template name.
         */
        public string $name,
        /**
         * Sender's email.
         */
        public string $fromEmail,
        /**
         * Template unique identifier. If you omit the "id" field then new template will be created. If you specify the
         * "id" field, the system will try to find a template with the specified id and edit it.
         */
        public ?string $id = null,
        /**
         * Editor type, "html" or "visual". Default is "html". You can create a template with "visual" editor type only
         * in web interface.
         */
        public EditorType|string|null $editorType = null,
        /**
         * The [template engine](https://docs.unione.io/en/template-engines) for handling the substitutions(merge tags),
         * "simple", "velocity", "liquid" or "none". Default value is "simple".
         */
        public TemplateEngine|string|null $templateEngine = null,
        /**
         * Object for passing the substitutions(merge tags) common for all recipients - e.g., company name. If the
         * substitution names are duplicated in object "substitutions", the values of the variables will be taken from
         * the object "substitutions". The substitutions can be used in the following parameters:
         *
         * - body.html
         * - body.plaintext
         * - body.amp
         * - subject
         * - from_name
         * - options.unsubscribe_url
         * A substitution name can consist from latin characeters, numbers and "_" symbol, and should start with the
         * letter.
         * @var array<string, string>|null
         */
        public ?array $globalSubstitutions = null,
        /**
         * Object for passing the metadata common for all the recipients, such as "key": "value". Max key quantity: 10.
         * Max key length: 64 symbols. Max value length: 1024 symbols. The metadata is returned by
         * [webhook](https://docs.unione.io/en/web-api-ref#webhook). To group single emails into a campaign, you can use
         * the system key 'campaign_id' with a value in the form of a non-negative decimal integer up to 128 bits or a
         * UUID in the format 'c7703772-453e-4c77-a9ae-9a1b94051b5a'. Incorrect values will be treated as '0'.
         * @var array<string, string>|null
         */
        public ?array $globalMetadata = null,
        /**
         * Contains HTML/plaintext/AMP parts of the email. Either html or plaintext part is required.
         */
        public ?BodyObject $body = null,
        /**
         * Email subject.
         * Example: `UniOne test email `.
         */
        public ?string $subject = null,
        /**
         * Sender's name.
         * Example: `John Smith`.
         */
        public ?string $fromName = null,
        /**
         * Optional Reply-To email (in case it's different to sender's email)
         * Example: `email@example.com`.
         */
        public ?string $replyTo = null,
        /**
         * Optional Reply-To name (if reply_to email is specified and you want to display not only this email but also
         * the name)
         * Example: `John Smith`.
         */
        public ?string $replyToName = null,
        /**
         * 1 = click tracking is on (default), 0 = click tracking is off. To use track_links = 0, you need to ask support
         * to enable this feature.
         * Allowed values: `0`, `1`.
         * Example: `0`.
         */
        public ?int $trackLinks = null,
        /**
         * 1 = read tracking is on (default), 0=read tracking is off. To use track_read = 0, you need to ask support to
         * enable this feature.
         * Allowed values: `0`, `1`.
         * Example: `0`.
         */
        public ?int $trackRead = null,
        /**
         * Contains email headers, maximum 50. Only headers with “X-” name prefix are accepted, all other are ignored,
         * for example X-UNIONE-Global-Language, X-UNIONE-Template-Engine. Standard headers "To," "CC," and "BCC" are
         * passed without the "X-." Yet, they are processed in a particular way and, as a result, have a number of
         * restrictions. You can find more details about it [here](/cc-and-bcc). If our support have approved omitting
         * standard unsubscription block for you, you can also pass List-Unsubscribe, List-Subscribe, List-Help,
         * List-Owner, List-Archive, In-Reply-To and References headers.
         */
        public ?HeadersObject $headers = null,
        /**
         * Optional array of attachments
         * @var list<AttachmentsArrayItem>|null
         */
        public ?array $attachments = null,
        /**
         * Optional array of inline attachments, e.g. for including images in email instead of loading them from external
         * URL.
         * @var list<InlineAttachmentsArrayItem>|null
         */
        public ?array $inlineAttachments = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: Data::string($data['name'] ?? null) ?? '',
            fromEmail: Data::string($data['from_email'] ?? null) ?? '',
            id: Data::string($data['id'] ?? null),
            editorType: Data::enum(EditorType::class, Data::string($data['editor_type'] ?? null)),
            templateEngine: Data::enum(TemplateEngine::class, Data::string($data['template_engine'] ?? null)),
            globalSubstitutions: Data::map($data['global_substitutions'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            globalMetadata: Data::map($data['global_metadata'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            body: Data::model(BodyObject::class, $data['body'] ?? null),
            subject: Data::string($data['subject'] ?? null),
            fromName: Data::string($data['from_name'] ?? null),
            replyTo: Data::string($data['reply_to'] ?? null),
            replyToName: Data::string($data['reply_to_name'] ?? null),
            trackLinks: Data::int($data['track_links'] ?? null),
            trackRead: Data::int($data['track_read'] ?? null),
            headers: Data::model(HeadersObject::class, $data['headers'] ?? null),
            attachments: Data::list($data['attachments'] ?? null, static fn ($item) => AttachmentsArrayItem::fromArray(Data::array($item) ?? [])),
            inlineAttachments: Data::list($data['inline_attachments'] ?? null, static fn ($item) => InlineAttachmentsArrayItem::fromArray(Data::array($item) ?? [])),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'editor_type' => Data::value($this->editorType),
            'template_engine' => Data::value($this->templateEngine),
            'global_substitutions' => Data::object($this->globalSubstitutions),
            'global_metadata' => Data::object($this->globalMetadata),
            'body' => null === $this->body ? null : Data::object($this->body->toArray()),
            'subject' => $this->subject,
            'from_email' => $this->fromEmail,
            'from_name' => $this->fromName,
            'reply_to' => $this->replyTo,
            'reply_to_name' => $this->replyToName,
            'track_links' => $this->trackLinks,
            'track_read' => $this->trackRead,
            'headers' => null === $this->headers ? null : Data::object($this->headers->toArray()),
            'attachments' => null === $this->attachments ? null : \array_map(static fn (AttachmentsArrayItem $item) => Data::object($item->toArray()), $this->attachments),
            'inline_attachments' => null === $this->inlineAttachments ? null : \array_map(static fn (InlineAttachmentsArrayItem $item) => Data::object($item->toArray()), $this->inlineAttachments),
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    public function jsonSerialize(): mixed
    {
        return Data::object($this->toArray());
    }
}
