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
    /**
     * Unqiue project identifier, ASCII string up to 36 characters long.
     * Example: `6123462132634`.
     *
     * @var string|null
     */
    private $id;

    /**
     * API key of the project. You can use it instead of the user API key parameter in all methods except project/*
     * methods.
     *
     * @var string|null
     */
    private $apiKey;

    /**
     * Project name, unique for user account.
     * Example: `Project 1A`.
     *
     * @var string|null
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
     * Date and time of project creation in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
     * Example: `2020-12-28 17:15:45`.
     *
     * @var string|null
     */
    private $regTime;

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
     * Project's email counter value. It increases on every email sent.
     *
     * @var int|null
     */
    private $emailCounter;

    /**
     * Allows you to limit the number of emails sent by the project. The sending stops when the limit is reached. Any
     * non-negative 64-bit integer is acceptable. 0 means no limit.
     *
     * @var int|null
     */
    private $emailCounterLimit;

    /**
     * 'default' - the counter resets to zero automatically at the beginning of each accounting period. 'permanent' -
     * the counter never resets automatically.
     * Default: `default`.
     * Values: `EmailCounterMode` constants.
     *
     * @var string|null
     */
    private $emailCounterMode;

    /**
     * A unique identifier that defines the default unsubscribe page. If absent, the account/project will be assigned
     * the system default unsubscribe page.
     * Example: `1`.
     *
     * @var int|null
     */
    private $unsubscribePageId;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->id = Data::string($data['id'] ?? null);
        $model->apiKey = Data::string($data['api_key'] ?? null);
        $model->name = Data::string($data['name'] ?? null);
        $model->country = Data::string($data['country'] ?? null);
        $model->regTime = Data::string($data['reg_time'] ?? null);
        $model->sendEnabled = Data::bool($data['send_enabled'] ?? null);
        $model->customUnsubscribeUrlEnabled = Data::bool($data['custom_unsubscribe_url_enabled'] ?? null);
        $model->backendDomainId = Data::int($data['backend_domain_id'] ?? null);
        $model->emailCounter = Data::int($data['email_counter'] ?? null);
        $model->emailCounterLimit = Data::int($data['email_counter_limit'] ?? null);
        $model->emailCounterMode = Data::string($data['email_counter_mode'] ?? null);
        $model->unsubscribePageId = Data::int($data['unsubscribe_page_id'] ?? null);

        return $model;
    }

    /**
     * Unqiue project identifier, ASCII string up to 36 characters long.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Unqiue project identifier, ASCII string up to 36 characters long.
     *
     * @return $this
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * API key of the project.
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * API key of the project.
     *
     * @return $this
     */
    public function setApiKey(?string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Project name, unique for user account.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Project name, unique for user account.
     *
     * @return $this
     */
    public function setName(?string $name): self
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
     * Date and time of project creation in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
     */
    public function getRegTime(): ?string
    {
        return $this->regTime;
    }

    /**
     * Date and time of project creation in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
     *
     * @return $this
     */
    public function setRegTime(?string $regTime): self
    {
        $this->regTime = $regTime;

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
     * Project's email counter value.
     */
    public function getEmailCounter(): ?int
    {
        return $this->emailCounter;
    }

    /**
     * Project's email counter value.
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
     * 'default' - the counter resets to zero automatically at the beginning of each accounting period. 'permanent' -
     * the counter never resets automatically.
     *
     * @return string|null
     */
    public function getEmailCounterMode(): ?string
    {
        return $this->emailCounterMode;
    }

    /**
     * 'default' - the counter resets to zero automatically at the beginning of each accounting period. 'permanent' -
     * the counter never resets automatically.
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
            'email_counter_mode' => $this->emailCounterMode,
            'unsubscribe_page_id' => $this->unsubscribePageId,
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
