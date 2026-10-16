<?php

declare(strict_types=1);

namespace UniOne\Api\Project\Model;

use UniOne\Client\Data;

/**
 * Object with project properties.
 */
final class ProjectObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Project name, unique for user account.
         * Example: `Project 1A`.
         */
        public string $name,
        /**
         * ISO-3166 alpha-2 country code. If set, UniOne treats project personal data according to country laws, e.g.
         * GDPR for european countries.
         * Example: `ES`.
         */
        public ?string $country = null,
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
            name: Data::string($data['name'] ?? null) ?? '',
            country: Data::string($data['country'] ?? null),
            sendEnabled: Data::bool($data['send_enabled'] ?? null),
            customUnsubscribeUrlEnabled: Data::bool($data['custom_unsubscribe_url_enabled'] ?? null),
            backendDomainId: Data::int($data['backend_domain_id'] ?? null),
            unsubscribePageId: Data::int($data['unsubscribe_page_id'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'name' => $this->name,
            'country' => $this->country,
            'send_enabled' => $this->sendEnabled,
            'custom_unsubscribe_url_enabled' => $this->customUnsubscribeUrlEnabled,
            'backend_domain_id' => $this->backendDomainId,
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
