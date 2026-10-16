<?php

declare(strict_types=1);

namespace UniOne\Api\Email\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\AttachmentsArrayItem;
use UniOne\Common\Model\BodyObject;
use UniOne\Common\Model\HeadersObject;
use UniOne\Common\Model\InlineAttachmentsArrayItem;
use UniOne\Common\Model\TemplateEngine;

/**
 * Object containing all message properties.
 */
final class MessageObject implements \JsonSerializable
{
    /**
     * Contains recipient emails, substitutions(merge tags) and metadata.
     *
     * @var list<MessageObjectRecipientsItem>
     */
    private $recipients;

    /**
     * Optional identifier of the template that had been created by
     * [template/set](https://docs.unione.io/en/web-api-ref#template-set) method. If template_id is passed then
     * fields from the template are used instead of missed email/send parameters. E.g. if "body" parameter in
     * email/send is omitted, "body" from template will be used. If "subject" in email/send is omitted, "subject"
     * from template will be used.
     * Example: `00000000-0000-0000-0000-000000000000`.
     *
     * @var string|null
     */
    private $templateId;

    /**
     * An array of strings. The maximum string length is 100 characters. You can include up to 4 strings which must
     * be unique. No more than 10 000 tags are allowed per project; if you try to add more, email/send will return an
     * error. You may use tags to categorize emails by your own criteria, and they will be passed along by event-dump
     * methods.
     *
     * @var list<string>|null
     */
    private $tags;

    /**
     * Whether to skip or not appending default unsubscribe footer. 1=skip, 0=append, default is 0. You should [ask
     * support](https://cp.unione.io/en/support) to approve
     * usage of skip_unsubscribe=1. [Read more](https://docs.unione.io/en/unsubscribe-link).
     * Allowed values: `0`, `1`.
     * Example: `0`.
     *
     * @var int|null
     */
    private $skipUnsubscribe;

    /**
     * The language of the unsubscribe footer and unsubscribe page. Languages supported are: "be", "de", "en", "es",
     * "fr", "it", "pl", "pt", "ru", "ua", "kz".
     * Example: `en`.
     *
     * @var string|null
     */
    private $globalLanguage;

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
     * @var BodyObject
     */
    private $body;

    /**
     * Email subject.
     * Example: `UniOne test email `.
     *
     * @var string
     */
    private $subject;

    /**
     * Sender's email. Required only if template_id parameter is empty.
     * Example: `email@example.com`.
     *
     * @var string|null
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
     * (allowed values 0 or 1, default 0) If set to 1, the global unavailability list will be ignored. Even if the
     * address was found to be unreachable while sending other UniOne users' emails, or its owner has issued
     * complaints, the message will still be sent. The setting may be ignored for certain addresses.
     * Allowed values: `0`, `1`.
     * Example: `0`.
     *
     * @var int|null
     */
    private $bypassGlobal;

    /**
     * (allowed values 0 or 1, default 0) If set to 1, the current user's or project's unavailability list will be
     * ignored. Works only if bypass_global is set to 1.
     * Allowed values: `0`, `1`.
     * Example: `0`.
     *
     * @var int|null
     */
    private $bypassUnavailable;

    /**
     * (allowed values 0 or 1, default 0) If set to 1, the current list of unsubscribed addresses for this account or
     * project will be ignored. Works only if bypass_global is set to 1. The setting is available only for users that
     * have been granted the right to omit the unsubscribe link (to request, please contact
     * [support](https://cp.unione.io/en/support)).
     * Allowed values: `0`, `1`.
     * Example: `0`.
     *
     * @var int|null
     */
    private $bypassUnsubscribed;

    /**
     * (allowed values 0 or 1, default 0) If set to 1, the user's or project's complaint list will be ignored. Works
     * only if bypass_global is set to 1. The setting is available only for users that have been granted the right to
     * omit the unsubscribe link (to request, please contact [support](https://cp.unione.io/en/support)).
     * Allowed values: `0`, `1`.
     * Example: `0`.
     *
     * @var int|null
     */
    private $bypassComplained;

    /**
     * A string of up to 64 characters containing a unique message key. This can be used to prevent occasional
     * message duplicates. If you send another API request with the same message key within the next minute, it will
     * be declined. We can generate a message key for each letter automatically; to enable this option, please
     * contact our [tech support](https://cp.unione.io/en/support).
     * Example: `SG1VsbG68sIH2dvc5mx890kIQ`.
     *
     * @var string|null
     */
    private $idempotenceKey;

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

    /**
     * Additional message options.
     *
     * @var MessageObjectOptions|null
     */
    private $options;

    /**
     * @param list<MessageObjectRecipientsItem> $recipients
     */
    public function __construct(array $recipients, BodyObject $body, string $subject)
    {
        $this->recipients = $recipients;
        $this->body = $body;
        $this->subject = $subject;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(
            Data::list($data['recipients'] ?? null, static function ($item) { return MessageObjectRecipientsItem::fromArray(Data::array($item) ?? []); }) ?? [],
            BodyObject::fromArray(Data::array($data['body'] ?? null) ?? []),
            Data::string($data['subject'] ?? null) ?? ''
        );
        $model->templateId = Data::string($data['template_id'] ?? null);
        $model->tags = Data::list($data['tags'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->skipUnsubscribe = Data::int($data['skip_unsubscribe'] ?? null);
        $model->globalLanguage = Data::string($data['global_language'] ?? null);
        $model->templateEngine = Data::string($data['template_engine'] ?? null);
        $model->globalSubstitutions = Data::map($data['global_substitutions'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->globalMetadata = Data::map($data['global_metadata'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->fromEmail = Data::string($data['from_email'] ?? null);
        $model->fromName = Data::string($data['from_name'] ?? null);
        $model->replyTo = Data::string($data['reply_to'] ?? null);
        $model->replyToName = Data::string($data['reply_to_name'] ?? null);
        $model->trackLinks = Data::int($data['track_links'] ?? null);
        $model->trackRead = Data::int($data['track_read'] ?? null);
        $model->bypassGlobal = Data::int($data['bypass_global'] ?? null);
        $model->bypassUnavailable = Data::int($data['bypass_unavailable'] ?? null);
        $model->bypassUnsubscribed = Data::int($data['bypass_unsubscribed'] ?? null);
        $model->bypassComplained = Data::int($data['bypass_complained'] ?? null);
        $model->idempotenceKey = Data::string($data['idempotence_key'] ?? null);
        $model->headers = Data::model(HeadersObject::class, $data['headers'] ?? null);
        $model->attachments = Data::list($data['attachments'] ?? null, static function ($item) { return AttachmentsArrayItem::fromArray(Data::array($item) ?? []); });
        $model->inlineAttachments = Data::list($data['inline_attachments'] ?? null, static function ($item) { return InlineAttachmentsArrayItem::fromArray(Data::array($item) ?? []); });
        $model->options = Data::model(MessageObjectOptions::class, $data['options'] ?? null);

        return $model;
    }

    /**
     * Contains recipient emails, substitutions(merge tags) and metadata.
     *
     * @return list<MessageObjectRecipientsItem>
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * Contains recipient emails, substitutions(merge tags) and metadata.
     *
     * @param list<MessageObjectRecipientsItem> $recipients
     *
     * @return $this
     */
    public function setRecipients(array $recipients): self
    {
        $this->recipients = $recipients;

        return $this;
    }

    /**
     * Optional identifier of the template that had been created by
     * [template/set](https://docs.unione.io/en/web-api-ref#template-set) method.
     */
    public function getTemplateId(): ?string
    {
        return $this->templateId;
    }

    /**
     * Optional identifier of the template that had been created by
     * [template/set](https://docs.unione.io/en/web-api-ref#template-set) method.
     *
     * @return $this
     */
    public function setTemplateId(?string $templateId): self
    {
        $this->templateId = $templateId;

        return $this;
    }

    /**
     * An array of strings.
     *
     * @return list<string>|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * An array of strings.
     *
     * @param list<string>|null $tags
     *
     * @return $this
     */
    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Whether to skip or not appending default unsubscribe footer. 1=skip, 0=append, default is 0.
     */
    public function getSkipUnsubscribe(): ?int
    {
        return $this->skipUnsubscribe;
    }

    /**
     * Whether to skip or not appending default unsubscribe footer. 1=skip, 0=append, default is 0.
     *
     * @return $this
     */
    public function setSkipUnsubscribe(?int $skipUnsubscribe): self
    {
        $this->skipUnsubscribe = $skipUnsubscribe;

        return $this;
    }

    /**
     * The language of the unsubscribe footer and unsubscribe page.
     */
    public function getGlobalLanguage(): ?string
    {
        return $this->globalLanguage;
    }

    /**
     * The language of the unsubscribe footer and unsubscribe page.
     *
     * @return $this
     */
    public function setGlobalLanguage(?string $globalLanguage): self
    {
        $this->globalLanguage = $globalLanguage;

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
    public function getBody(): BodyObject
    {
        return $this->body;
    }

    /**
     * Contains HTML/plaintext/AMP parts of the email.
     *
     * @return $this
     */
    public function setBody(BodyObject $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Email subject.
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Email subject.
     *
     * @return $this
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Sender's email.
     */
    public function getFromEmail(): ?string
    {
        return $this->fromEmail;
    }

    /**
     * Sender's email.
     *
     * @return $this
     */
    public function setFromEmail(?string $fromEmail): self
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
     * (allowed values 0 or 1, default 0) If set to 1, the global unavailability list will be ignored.
     */
    public function getBypassGlobal(): ?int
    {
        return $this->bypassGlobal;
    }

    /**
     * (allowed values 0 or 1, default 0) If set to 1, the global unavailability list will be ignored.
     *
     * @return $this
     */
    public function setBypassGlobal(?int $bypassGlobal): self
    {
        $this->bypassGlobal = $bypassGlobal;

        return $this;
    }

    /**
     * (allowed values 0 or 1, default 0) If set to 1, the current user's or project's unavailability list will be
     * ignored.
     */
    public function getBypassUnavailable(): ?int
    {
        return $this->bypassUnavailable;
    }

    /**
     * (allowed values 0 or 1, default 0) If set to 1, the current user's or project's unavailability list will be
     * ignored.
     *
     * @return $this
     */
    public function setBypassUnavailable(?int $bypassUnavailable): self
    {
        $this->bypassUnavailable = $bypassUnavailable;

        return $this;
    }

    /**
     * (allowed values 0 or 1, default 0) If set to 1, the current list of unsubscribed addresses for this account or
     * project will be ignored.
     */
    public function getBypassUnsubscribed(): ?int
    {
        return $this->bypassUnsubscribed;
    }

    /**
     * (allowed values 0 or 1, default 0) If set to 1, the current list of unsubscribed addresses for this account or
     * project will be ignored.
     *
     * @return $this
     */
    public function setBypassUnsubscribed(?int $bypassUnsubscribed): self
    {
        $this->bypassUnsubscribed = $bypassUnsubscribed;

        return $this;
    }

    /**
     * (allowed values 0 or 1, default 0) If set to 1, the user's or project's complaint list will be ignored.
     */
    public function getBypassComplained(): ?int
    {
        return $this->bypassComplained;
    }

    /**
     * (allowed values 0 or 1, default 0) If set to 1, the user's or project's complaint list will be ignored.
     *
     * @return $this
     */
    public function setBypassComplained(?int $bypassComplained): self
    {
        $this->bypassComplained = $bypassComplained;

        return $this;
    }

    /**
     * A string of up to 64 characters containing a unique message key.
     */
    public function getIdempotenceKey(): ?string
    {
        return $this->idempotenceKey;
    }

    /**
     * A string of up to 64 characters containing a unique message key.
     *
     * @return $this
     */
    public function setIdempotenceKey(?string $idempotenceKey): self
    {
        $this->idempotenceKey = $idempotenceKey;

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
     * Additional message options.
     */
    public function getOptions(): ?MessageObjectOptions
    {
        return $this->options;
    }

    /**
     * Additional message options.
     *
     * @return $this
     */
    public function setOptions(?MessageObjectOptions $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'recipients' => \array_map(static function (MessageObjectRecipientsItem $item) { return Data::object($item->toArray()); }, $this->recipients),
            'template_id' => $this->templateId,
            'tags' => $this->tags,
            'skip_unsubscribe' => $this->skipUnsubscribe,
            'global_language' => $this->globalLanguage,
            'template_engine' => $this->templateEngine,
            'global_substitutions' => Data::object($this->globalSubstitutions),
            'global_metadata' => Data::object($this->globalMetadata),
            'body' => Data::object($this->body->toArray()),
            'subject' => $this->subject,
            'from_email' => $this->fromEmail,
            'from_name' => $this->fromName,
            'reply_to' => $this->replyTo,
            'reply_to_name' => $this->replyToName,
            'track_links' => $this->trackLinks,
            'track_read' => $this->trackRead,
            'bypass_global' => $this->bypassGlobal,
            'bypass_unavailable' => $this->bypassUnavailable,
            'bypass_unsubscribed' => $this->bypassUnsubscribed,
            'bypass_complained' => $this->bypassComplained,
            'idempotence_key' => $this->idempotenceKey,
            'headers' => null === $this->headers ? null : Data::object($this->headers->toArray()),
            'attachments' => null === $this->attachments ? null : \array_map(static function (AttachmentsArrayItem $item) { return Data::object($item->toArray()); }, $this->attachments),
            'inline_attachments' => null === $this->inlineAttachments ? null : \array_map(static function (InlineAttachmentsArrayItem $item) { return Data::object($item->toArray()); }, $this->inlineAttachments),
            'options' => null === $this->options ? null : Data::object($this->options->toArray()),
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
