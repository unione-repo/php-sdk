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
    /**
     * Template unique identifier. If you omit the "id" field then new template will be created. If you specify the
     * "id" field, the system will try to find a template with the specified id and edit it.
     *
     * @var string|null
     */
    private $id;

    /**
     * Template name.
     *
     * @var string
     */
    private $name;

    /**
     * Editor type, "html" or "visual". Default is "html". You can create a template with "visual" editor type only
     * in web interface.
     * Values: `EditorType` constants.
     *
     * @var string|null
     */
    private $editorType;

    /**
     * The [template engine](https://docs.unione.io/en/template-engines) for handling the substitutions(merge tags),
     * "simple", "velocity", "liquid" or "none". Default value is "simple".
     * Values: `TemplateEngine` constants.
     *
     * @var string|null
     */
    private $templateEngine;

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
     *
     * @var array<string, string>|null
     */
    private $globalSubstitutions;

    /**
     * Object for passing the metadata common for all the recipients, such as "key": "value". Max key quantity: 10.
     * Max key length: 64 symbols. Max value length: 1024 symbols. The metadata is returned by
     * [webhook](https://docs.unione.io/en/web-api-ref#webhook). To group single emails into a campaign, you can use
     * the system key 'campaign_id' with a value in the form of a non-negative decimal integer up to 128 bits or a
     * UUID in the format 'c7703772-453e-4c77-a9ae-9a1b94051b5a'. Incorrect values will be treated as '0'.
     *
     * @var array<string, string>|null
     */
    private $globalMetadata;

    /**
     * Contains HTML/plaintext/AMP parts of the email. Either html or plaintext part is required.
     *
     * @var BodyObject|null
     */
    private $body;

    /**
     * Email subject.
     * Example: `UniOne test email `.
     *
     * @var string|null
     */
    private $subject;

    /**
     * Sender's email.
     *
     * @var string
     */
    private $fromEmail;

    /**
     * Sender's name.
     * Example: `John Smith`.
     *
     * @var string|null
     */
    private $fromName;

    /**
     * Optional Reply-To email (in case it's different to sender's email)
     * Example: `email@example.com`.
     *
     * @var string|null
     */
    private $replyTo;

    /**
     * Optional Reply-To name (if reply_to email is specified and you want to display not only this email but also
     * the name)
     * Example: `John Smith`.
     *
     * @var string|null
     */
    private $replyToName;

    /**
     * 1 = click tracking is on (default), 0 = click tracking is off. To use track_links = 0, you need to ask support
     * to enable this feature.
     * Allowed values: `0`, `1`.
     * Example: `0`.
     *
     * @var int|null
     */
    private $trackLinks;

    /**
     * 1 = read tracking is on (default), 0=read tracking is off. To use track_read = 0, you need to ask support to
     * enable this feature.
     * Allowed values: `0`, `1`.
     * Example: `0`.
     *
     * @var int|null
     */
    private $trackRead;

    /**
     * Contains email headers, maximum 50. Only headers with “X-” name prefix are accepted, all other are ignored,
     * for example X-UNIONE-Global-Language, X-UNIONE-Template-Engine. Standard headers "To," "CC," and "BCC" are
     * passed without the "X-." Yet, they are processed in a particular way and, as a result, have a number of
     * restrictions. You can find more details about it [here](/cc-and-bcc). If our support have approved omitting
     * standard unsubscription block for you, you can also pass List-Unsubscribe, List-Subscribe, List-Help,
     * List-Owner, List-Archive, In-Reply-To and References headers.
     *
     * @var HeadersObject|null
     */
    private $headers;

    /**
     * Optional array of attachments
     *
     * @var list<AttachmentsArrayItem>|null
     */
    private $attachments;

    /**
     * Optional array of inline attachments, e.g. for including images in email instead of loading them from external
     * URL.
     *
     * @var list<InlineAttachmentsArrayItem>|null
     */
    private $inlineAttachments;

    public function __construct(string $name, string $fromEmail)
    {
        $this->name = $name;
        $this->fromEmail = $fromEmail;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(
            Data::string($data['name'] ?? null) ?? '',
            Data::string($data['from_email'] ?? null) ?? ''
        );
        $model->id = Data::string($data['id'] ?? null);
        $model->editorType = Data::string($data['editor_type'] ?? null);
        $model->templateEngine = Data::string($data['template_engine'] ?? null);
        $model->globalSubstitutions = Data::map($data['global_substitutions'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->globalMetadata = Data::map($data['global_metadata'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->body = Data::model(BodyObject::class, $data['body'] ?? null);
        $model->subject = Data::string($data['subject'] ?? null);
        $model->fromName = Data::string($data['from_name'] ?? null);
        $model->replyTo = Data::string($data['reply_to'] ?? null);
        $model->replyToName = Data::string($data['reply_to_name'] ?? null);
        $model->trackLinks = Data::int($data['track_links'] ?? null);
        $model->trackRead = Data::int($data['track_read'] ?? null);
        $model->headers = Data::model(HeadersObject::class, $data['headers'] ?? null);
        $model->attachments = Data::list($data['attachments'] ?? null, static function ($item) { return AttachmentsArrayItem::fromArray(Data::array($item) ?? []); });
        $model->inlineAttachments = Data::list($data['inline_attachments'] ?? null, static function ($item) { return InlineAttachmentsArrayItem::fromArray(Data::array($item) ?? []); });

        return $model;
    }

    /**
     * Template unique identifier.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Template unique identifier.
     *
     * @return $this
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Template name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Template name.
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Editor type, "html" or "visual".
     *
     * @return string|null
     */
    public function getEditorType(): ?string
    {
        return $this->editorType;
    }

    /**
     * Editor type, "html" or "visual".
     *
     * @param string|null $editorType Values: `EditorType` constants.
     *
     * @return $this
     */
    public function setEditorType(?string $editorType): self
    {
        $this->editorType = $editorType;

        return $this;
    }

    /**
     * The [template engine](https://docs.unione.io/en/template-engines) for handling the substitutions(merge tags),
     * "simple", "velocity", "liquid" or "none".
     *
     * @return string|null
     */
    public function getTemplateEngine(): ?string
    {
        return $this->templateEngine;
    }

    /**
     * The [template engine](https://docs.unione.io/en/template-engines) for handling the substitutions(merge tags),
     * "simple", "velocity", "liquid" or "none".
     *
     * @param string|null $templateEngine Values: `TemplateEngine` constants.
     *
     * @return $this
     */
    public function setTemplateEngine(?string $templateEngine): self
    {
        $this->templateEngine = $templateEngine;

        return $this;
    }

    /**
     * Object for passing the substitutions(merge tags) common for all recipients - e.g., company name.
     *
     * @return array<string, string>|null
     */
    public function getGlobalSubstitutions(): ?array
    {
        return $this->globalSubstitutions;
    }

    /**
     * Object for passing the substitutions(merge tags) common for all recipients - e.g., company name.
     *
     * @param array<string, string>|null $globalSubstitutions
     *
     * @return $this
     */
    public function setGlobalSubstitutions(?array $globalSubstitutions): self
    {
        $this->globalSubstitutions = $globalSubstitutions;

        return $this;
    }

    /**
     * Object for passing the metadata common for all the recipients, such as "key": "value".
     *
     * @return array<string, string>|null
     */
    public function getGlobalMetadata(): ?array
    {
        return $this->globalMetadata;
    }

    /**
     * Object for passing the metadata common for all the recipients, such as "key": "value".
     *
     * @param array<string, string>|null $globalMetadata
     *
     * @return $this
     */
    public function setGlobalMetadata(?array $globalMetadata): self
    {
        $this->globalMetadata = $globalMetadata;

        return $this;
    }

    /**
     * Contains HTML/plaintext/AMP parts of the email.
     */
    public function getBody(): ?BodyObject
    {
        return $this->body;
    }

    /**
     * Contains HTML/plaintext/AMP parts of the email.
     *
     * @return $this
     */
    public function setBody(?BodyObject $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Email subject.
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * Email subject.
     *
     * @return $this
     */
    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Sender's email.
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    /**
     * Sender's email.
     *
     * @return $this
     */
    public function setFromEmail(string $fromEmail): self
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Sender's name.
     */
    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    /**
     * Sender's name.
     *
     * @return $this
     */
    public function setFromName(?string $fromName): self
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Optional Reply-To email (in case it's different to sender's email)
     */
    public function getReplyTo(): ?string
    {
        return $this->replyTo;
    }

    /**
     * Optional Reply-To email (in case it's different to sender's email)
     *
     * @return $this
     */
    public function setReplyTo(?string $replyTo): self
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * Optional Reply-To name (if reply_to email is specified and you want to display not only this email but also
     * the name)
     */
    public function getReplyToName(): ?string
    {
        return $this->replyToName;
    }

    /**
     * Optional Reply-To name (if reply_to email is specified and you want to display not only this email but also
     * the name)
     *
     * @return $this
     */
    public function setReplyToName(?string $replyToName): self
    {
        $this->replyToName = $replyToName;

        return $this;
    }

    /**
     * 1 = click tracking is on (default), 0 = click tracking is off.
     */
    public function getTrackLinks(): ?int
    {
        return $this->trackLinks;
    }

    /**
     * 1 = click tracking is on (default), 0 = click tracking is off.
     *
     * @return $this
     */
    public function setTrackLinks(?int $trackLinks): self
    {
        $this->trackLinks = $trackLinks;

        return $this;
    }

    /**
     * 1 = read tracking is on (default), 0=read tracking is off.
     */
    public function getTrackRead(): ?int
    {
        return $this->trackRead;
    }

    /**
     * 1 = read tracking is on (default), 0=read tracking is off.
     *
     * @return $this
     */
    public function setTrackRead(?int $trackRead): self
    {
        $this->trackRead = $trackRead;

        return $this;
    }

    /**
     * Contains email headers, maximum 50.
     */
    public function getHeaders(): ?HeadersObject
    {
        return $this->headers;
    }

    /**
     * Contains email headers, maximum 50.
     *
     * @return $this
     */
    public function setHeaders(?HeadersObject $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Optional array of attachments
     *
     * @return list<AttachmentsArrayItem>|null
     */
    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    /**
     * Optional array of attachments
     *
     * @param list<AttachmentsArrayItem>|null $attachments
     *
     * @return $this
     */
    public function setAttachments(?array $attachments): self
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * Optional array of inline attachments, e.g. for including images in email instead of loading them from external
     * URL.
     *
     * @return list<InlineAttachmentsArrayItem>|null
     */
    public function getInlineAttachments(): ?array
    {
        return $this->inlineAttachments;
    }

    /**
     * Optional array of inline attachments, e.g. for including images in email instead of loading them from external
     * URL.
     *
     * @param list<InlineAttachmentsArrayItem>|null $inlineAttachments
     *
     * @return $this
     */
    public function setInlineAttachments(?array $inlineAttachments): self
    {
        $this->inlineAttachments = $inlineAttachments;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'editor_type' => $this->editorType,
            'template_engine' => $this->templateEngine,
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
            'attachments' => null === $this->attachments ? null : \array_map(static function (AttachmentsArrayItem $item) { return Data::object($item->toArray()); }, $this->attachments),
            'inline_attachments' => null === $this->inlineAttachments ? null : \array_map(static function (InlineAttachmentsArrayItem $item) { return Data::object($item->toArray()); }, $this->inlineAttachments),
        ], static function ($value): bool {
            return $value !== null;
        });
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return Data::object($this->toArray());
    }
}
