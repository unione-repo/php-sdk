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
    public function __construct(
        /**
         * Contains recipient emails, substitutions(merge tags) and metadata.
         * @var list<MessageObjectRecipientsItem>
         */
        public array $recipients,
        /**
         * Contains HTML/plaintext/AMP parts of the email. Either html or plaintext part is required.
         */
        public BodyObject $body,
        /**
         * Email subject.
         * Example: `UniOne test email `.
         */
        public string $subject,
        /**
         * Optional identifier of the template that had been created by
         * [template/set](https://docs.unione.io/en/web-api-ref#template-set) method. If template_id is passed then
         * fields from the template are used instead of missed email/send parameters. E.g. if "body" parameter in
         * email/send is omitted, "body" from template will be used. If "subject" in email/send is omitted, "subject"
         * from template will be used.
         * Example: `00000000-0000-0000-0000-000000000000`.
         */
        public ?string $templateId = null,
        /**
         * An array of strings. The maximum string length is 100 characters. You can include up to 4 strings which must
         * be unique. No more than 10 000 tags are allowed per project; if you try to add more, email/send will return an
         * error. You may use tags to categorize emails by your own criteria, and they will be passed along by event-dump
         * methods.
         * @var list<string>|null
         */
        public ?array $tags = null,
        /**
         * Whether to skip or not appending default unsubscribe footer. 1=skip, 0=append, default is 0. You should [ask
         * support](https://cp.unione.io/en/support) to approve
         * usage of skip_unsubscribe=1. [Read more](https://docs.unione.io/en/unsubscribe-link).
         * Allowed values: `0`, `1`.
         * Example: `0`.
         */
        public ?int $skipUnsubscribe = null,
        /**
         * The language of the unsubscribe footer and unsubscribe page. Languages supported are: "be", "de", "en", "es",
         * "fr", "it", "pl", "pt", "ru", "ua", "kz".
         * Example: `en`.
         */
        public ?string $globalLanguage = null,
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
         * Sender's email. Required only if template_id parameter is empty.
         * Example: `email@example.com`.
         */
        public ?string $fromEmail = null,
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
         * (allowed values 0 or 1, default 0) If set to 1, the global unavailability list will be ignored. Even if the
         * address was found to be unreachable while sending other UniOne users' emails, or its owner has issued
         * complaints, the message will still be sent. The setting may be ignored for certain addresses.
         * Allowed values: `0`, `1`.
         * Example: `0`.
         */
        public ?int $bypassGlobal = null,
        /**
         * (allowed values 0 or 1, default 0) If set to 1, the current user's or project's unavailability list will be
         * ignored. Works only if bypass_global is set to 1.
         * Allowed values: `0`, `1`.
         * Example: `0`.
         */
        public ?int $bypassUnavailable = null,
        /**
         * (allowed values 0 or 1, default 0) If set to 1, the current list of unsubscribed addresses for this account or
         * project will be ignored. Works only if bypass_global is set to 1. The setting is available only for users that
         * have been granted the right to omit the unsubscribe link (to request, please contact
         * [support](https://cp.unione.io/en/support)).
         * Allowed values: `0`, `1`.
         * Example: `0`.
         */
        public ?int $bypassUnsubscribed = null,
        /**
         * (allowed values 0 or 1, default 0) If set to 1, the user's or project's complaint list will be ignored. Works
         * only if bypass_global is set to 1. The setting is available only for users that have been granted the right to
         * omit the unsubscribe link (to request, please contact [support](https://cp.unione.io/en/support)).
         * Allowed values: `0`, `1`.
         * Example: `0`.
         */
        public ?int $bypassComplained = null,
        /**
         * A string of up to 64 characters containing a unique message key. This can be used to prevent occasional
         * message duplicates. If you send another API request with the same message key within the next minute, it will
         * be declined. We can generate a message key for each letter automatically; to enable this option, please
         * contact our [tech support](https://cp.unione.io/en/support).
         * Example: `SG1VsbG68sIH2dvc5mx890kIQ`.
         */
        public ?string $idempotenceKey = null,
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
        /**
         * Additional message options.
         */
        public ?MessageObjectOptions $options = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            recipients: Data::list($data['recipients'] ?? null, static fn ($item) => MessageObjectRecipientsItem::fromArray(Data::array($item) ?? [])) ?? [],
            body: BodyObject::fromArray(Data::array($data['body'] ?? null) ?? []),
            subject: Data::string($data['subject'] ?? null) ?? '',
            templateId: Data::string($data['template_id'] ?? null),
            tags: Data::list($data['tags'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            skipUnsubscribe: Data::int($data['skip_unsubscribe'] ?? null),
            globalLanguage: Data::string($data['global_language'] ?? null),
            templateEngine: Data::enum(TemplateEngine::class, Data::string($data['template_engine'] ?? null)),
            globalSubstitutions: Data::map($data['global_substitutions'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            globalMetadata: Data::map($data['global_metadata'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            fromEmail: Data::string($data['from_email'] ?? null),
            fromName: Data::string($data['from_name'] ?? null),
            replyTo: Data::string($data['reply_to'] ?? null),
            replyToName: Data::string($data['reply_to_name'] ?? null),
            trackLinks: Data::int($data['track_links'] ?? null),
            trackRead: Data::int($data['track_read'] ?? null),
            bypassGlobal: Data::int($data['bypass_global'] ?? null),
            bypassUnavailable: Data::int($data['bypass_unavailable'] ?? null),
            bypassUnsubscribed: Data::int($data['bypass_unsubscribed'] ?? null),
            bypassComplained: Data::int($data['bypass_complained'] ?? null),
            idempotenceKey: Data::string($data['idempotence_key'] ?? null),
            headers: Data::model(HeadersObject::class, $data['headers'] ?? null),
            attachments: Data::list($data['attachments'] ?? null, static fn ($item) => AttachmentsArrayItem::fromArray(Data::array($item) ?? [])),
            inlineAttachments: Data::list($data['inline_attachments'] ?? null, static fn ($item) => InlineAttachmentsArrayItem::fromArray(Data::array($item) ?? [])),
            options: Data::model(MessageObjectOptions::class, $data['options'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'recipients' => \array_map(static fn (MessageObjectRecipientsItem $item) => Data::object($item->toArray()), $this->recipients),
            'template_id' => $this->templateId,
            'tags' => $this->tags,
            'skip_unsubscribe' => $this->skipUnsubscribe,
            'global_language' => $this->globalLanguage,
            'template_engine' => Data::value($this->templateEngine),
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
            'attachments' => null === $this->attachments ? null : \array_map(static fn (AttachmentsArrayItem $item) => Data::object($item->toArray()), $this->attachments),
            'inline_attachments' => null === $this->inlineAttachments ? null : \array_map(static fn (InlineAttachmentsArrayItem $item) => Data::object($item->toArray()), $this->inlineAttachments),
            'options' => null === $this->options ? null : Data::object($this->options->toArray()),
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
