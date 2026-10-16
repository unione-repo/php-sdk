<?php

declare(strict_types=1);

namespace UniOne\Api\Project\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\EmailCounterMode;

/**
 * ProjectListObject
 */
final class ProjectListObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Unqiue project identifier, ASCII string up to 36 characters long.
         * Example: `6123462132634`.
         */
        public ?string $id = null,
        /**
         * API key of the project. You can use it instead of the user API key parameter in all methods except project/*
         * methods.
         */
        public ?string $apiKey = null,
        /**
         * Project name, unique for user account.
         * Example: `Project 1A`.
         */
        public ?string $name = null,
        /**
         * ISO-3166 alpha-2 country code. If set, UniOne treats project personal data according to country laws, e.g.
         * GDPR for european countries.
         * Example: `ES`.
         */
        public ?string $country = null,
        /**
         * Date and time of project creation in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
         * Example: `2020-12-28 17:15:45`.
         */
        public ?string $regTime = null,
        /**
         * Whether email sending is enabled for this project or not.
         * Default: `True`.
         */
        public ?bool $sendEnabled = null,
        /**
         * If it's false then UniOne adds default unsubscribe footer to each email sent with API key of the project. If
         * it's true then appending default unsubscribe footer for this project is avoided and sending with custom
         * unsubscribe url or even without unsubscribe url is permitted for the project. Please note that
         * custom_unsubscribe_url_enabled=true is available only if removing unsubscribe link is approved for the user
         * account by support. More on this [here](https://docs.unione.io/en/unsubscribe-link). When
         * custom_unsubscribe_url_enabled is skipped on creating a project, it's value is taken from user
         */
        public ?bool $customUnsubscribeUrlEnabled = null,
        /**
         * A unique domain identifier which will determine the [tracking
         * domain](https://docs.unione.io/en/tracking-domains) or [dedicated IP](/dedicated-ip) pool to be used by
         * default. If the value is not specified, a default backend domain will be assigned for your account or project
         * instead.
         * Example: `1234`.
         */
        public ?int $backendDomainId = null,
        /**
         * Project's email counter value. It increases on every email sent.
         */
        public ?int $emailCounter = null,
        /**
         * Allows you to limit the number of emails sent by the project. The sending stops when the limit is reached. Any
         * non-negative 64-bit integer is acceptable. 0 means no limit.
         */
        public ?int $emailCounterLimit = null,
        /**
         * 'default' - the counter resets to zero automatically at the beginning of each accounting period. 'permanent' -
         * the counter never resets automatically.
         * Default: `default`.
         */
        public EmailCounterMode|string|null $emailCounterMode = null,
        /**
         * A unique identifier that defines the default unsubscribe page. If absent, the account/project will be assigned
         * the system default unsubscribe page.
         * Example: `1`.
         */
        public ?int $unsubscribePageId = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Data::string($data['id'] ?? null),
            apiKey: Data::string($data['api_key'] ?? null),
            name: Data::string($data['name'] ?? null),
            country: Data::string($data['country'] ?? null),
            regTime: Data::string($data['reg_time'] ?? null),
            sendEnabled: Data::bool($data['send_enabled'] ?? null),
            customUnsubscribeUrlEnabled: Data::bool($data['custom_unsubscribe_url_enabled'] ?? null),
            backendDomainId: Data::int($data['backend_domain_id'] ?? null),
            emailCounter: Data::int($data['email_counter'] ?? null),
            emailCounterLimit: Data::int($data['email_counter_limit'] ?? null),
            emailCounterMode: Data::enum(EmailCounterMode::class, Data::string($data['email_counter_mode'] ?? null)),
            unsubscribePageId: Data::int($data['unsubscribe_page_id'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'id' => $this->id,
            'api_key' => $this->apiKey,
            'name' => $this->name,
            'country' => $this->country,
            'reg_time' => $this->regTime,
            'send_enabled' => $this->sendEnabled,
            'custom_unsubscribe_url_enabled' => $this->customUnsubscribeUrlEnabled,
            'backend_domain_id' => $this->backendDomainId,
            'email_counter' => $this->emailCounter,
            'email_counter_limit' => $this->emailCounterLimit,
            'email_counter_mode' => Data::value($this->emailCounterMode),
            'unsubscribe_page_id' => $this->unsubscribePageId,
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
