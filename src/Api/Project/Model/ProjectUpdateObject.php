<?php

declare(strict_types=1);

namespace UniOne\Api\Project\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\EmailCounterMode;

/**
 * Object with project properties.
 */
final class ProjectUpdateObject implements \JsonSerializable
{
    /**
     * Project name, unique for user account.
     * Example: `Project 1A`.
     *
     * @var string
     */
    private $name;

    /**
     * ISO-3166 alpha-2 country code. If set, UniOne treats project personal data according to country laws, e.g.
     * GDPR for european countries.
     * Example: `ES`.
     *
     * @var string|null
     */
    private $country;

    /**
     * Whether email sending is enabled for this project or not.
     * Default: `True`.
     *
     * @var bool|null
     */
    private $sendEnabled;

    /**
     * If it's false then UniOne adds default unsubscribe footer to each email sent with API key of the project. If
     * it's true then appending default unsubscribe footer for this project is avoided and sending with custom
     * unsubscribe url or even without unsubscribe url is permitted for the project. Please note that
     * custom_unsubscribe_url_enabled=true is available only if removing unsubscribe link is approved for the user
     * account by support. More on this [here](https://docs.unione.io/en/unsubscribe-link). When
     * custom_unsubscribe_url_enabled is skipped on creating a project, it's value is taken from user
     *
     * @var bool|null
     */
    private $customUnsubscribeUrlEnabled;

    /**
     * A unique domain identifier which will determine the [tracking
     * domain](https://docs.unione.io/en/tracking-domains) or [dedicated IP](/dedicated-ip) pool to be used by
     * default. If the value is not specified, a default backend domain will be assigned for your account or project
     * instead.
     * Example: `1234`.
     *
     * @var int|null
     */
    private $backendDomainId;

    /**
     * A unique identifier that defines the default unsubscribe page. If absent, the account/project will be assigned
     * the system default unsubscribe page.
     * Example: `1`.
     *
     * @var int|null
     */
    private $unsubscribePageId;

    /**
     * Project's email counter value. 0 value only is accepted (which means resetting the counter to zero), or
     * refreshes automatically depending on the counter mode set with the 'email_counter_mode' parameter. If the
     * request doesn't contain the field or contains null, the limit value doesn't change.
     *
     * @var int|null
     */
    private $emailCounter;

    /**
     * Allows you to limit the number of emails sent by the project. The sending stops when the limit is reached. Any
     * non-negative 64-bit integer is acceptable. Setting to 0 means no limit. If the request doesn't contain the
     * field or contains null, the limit value doesn't change.
     * Default: `0`.
     *
     * @var int|null
     */
    private $emailCounterLimit;

    /**
     * Sets the email counter mode. It allows you to choose whether the counter should reset automatically, or remain
     * permanent. The following values are acceptable: 'default' - the counter resets to zero automatically at the
     * beginning of each accounting period, 'permanent' - the counter never resets automatically. The reset can be
     * done only manually by the user in the request with the passes 0 value in the email_counter field. If the
     * request doesn't contain the field or contains a null value, the limit value doesn't change.
     * Default: `default`.
     * Values: `EmailCounterMode` constants.
     *
     * @var string|null
     */
    private $emailCounterMode;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(Data::string($data['name'] ?? null) ?? '');
        $model->country = Data::string($data['country'] ?? null);
        $model->sendEnabled = Data::bool($data['send_enabled'] ?? null);
        $model->customUnsubscribeUrlEnabled = Data::bool($data['custom_unsubscribe_url_enabled'] ?? null);
        $model->backendDomainId = Data::int($data['backend_domain_id'] ?? null);
        $model->unsubscribePageId = Data::int($data['unsubscribe_page_id'] ?? null);
        $model->emailCounter = Data::int($data['email_counter'] ?? null);
        $model->emailCounterLimit = Data::int($data['email_counter_limit'] ?? null);
        $model->emailCounterMode = Data::string($data['email_counter_mode'] ?? null);

        return $model;
    }

    /**
     * Project name, unique for user account.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Project name, unique for user account.
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * ISO-3166 alpha-2 country code.
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * ISO-3166 alpha-2 country code.
     *
     * @return $this
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Whether email sending is enabled for this project or not.
     */
    public function getSendEnabled(): ?bool
    {
        return $this->sendEnabled;
    }

    /**
     * Whether email sending is enabled for this project or not.
     *
     * @return $this
     */
    public function setSendEnabled(?bool $sendEnabled): self
    {
        $this->sendEnabled = $sendEnabled;

        return $this;
    }

    /**
     * If it's false then UniOne adds default unsubscribe footer to each email sent with API key of the project.
     */
    public function getCustomUnsubscribeUrlEnabled(): ?bool
    {
        return $this->customUnsubscribeUrlEnabled;
    }

    /**
     * If it's false then UniOne adds default unsubscribe footer to each email sent with API key of the project.
     *
     * @return $this
     */
    public function setCustomUnsubscribeUrlEnabled(?bool $customUnsubscribeUrlEnabled): self
    {
        $this->customUnsubscribeUrlEnabled = $customUnsubscribeUrlEnabled;

        return $this;
    }

    /**
     * A unique domain identifier which will determine the [tracking
     * domain](https://docs.unione.io/en/tracking-domains) or [dedicated IP](/dedicated-ip) pool to be used by
     * default.
     */
    public function getBackendDomainId(): ?int
    {
        return $this->backendDomainId;
    }

    /**
     * A unique domain identifier which will determine the [tracking
     * domain](https://docs.unione.io/en/tracking-domains) or [dedicated IP](/dedicated-ip) pool to be used by
     * default.
     *
     * @return $this
     */
    public function setBackendDomainId(?int $backendDomainId): self
    {
        $this->backendDomainId = $backendDomainId;

        return $this;
    }

    /**
     * A unique identifier that defines the default unsubscribe page.
     */
    public function getUnsubscribePageId(): ?int
    {
        return $this->unsubscribePageId;
    }

    /**
     * A unique identifier that defines the default unsubscribe page.
     *
     * @return $this
     */
    public function setUnsubscribePageId(?int $unsubscribePageId): self
    {
        $this->unsubscribePageId = $unsubscribePageId;

        return $this;
    }

    /**
     * Project's email counter value. 0 value only is accepted (which means resetting the counter to zero), or
     * refreshes automatically depending on the counter mode set with the 'email_counter_mode' parameter.
     */
    public function getEmailCounter(): ?int
    {
        return $this->emailCounter;
    }

    /**
     * Project's email counter value. 0 value only is accepted (which means resetting the counter to zero), or
     * refreshes automatically depending on the counter mode set with the 'email_counter_mode' parameter.
     *
     * @return $this
     */
    public function setEmailCounter(?int $emailCounter): self
    {
        $this->emailCounter = $emailCounter;

        return $this;
    }

    /**
     * Allows you to limit the number of emails sent by the project.
     */
    public function getEmailCounterLimit(): ?int
    {
        return $this->emailCounterLimit;
    }

    /**
     * Allows you to limit the number of emails sent by the project.
     *
     * @return $this
     */
    public function setEmailCounterLimit(?int $emailCounterLimit): self
    {
        $this->emailCounterLimit = $emailCounterLimit;

        return $this;
    }

    /**
     * Sets the email counter mode.
     *
     * @return string|null
     */
    public function getEmailCounterMode(): ?string
    {
        return $this->emailCounterMode;
    }

    /**
     * Sets the email counter mode.
     *
     * @param string|null $emailCounterMode Values: `EmailCounterMode` constants.
     *
     * @return $this
     */
    public function setEmailCounterMode(?string $emailCounterMode): self
    {
        $this->emailCounterMode = $emailCounterMode;

        return $this;
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
            'email_counter' => $this->emailCounter,
            'email_counter_limit' => $this->emailCounterLimit,
            'email_counter_mode' => $this->emailCounterMode,
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
