<?php

declare(strict_types=1);

namespace UniOne\Api\Email\Model;

use UniOne\Client\Data;

/**
 * Additional message options.
 */
final class MessageObjectOptions implements \JsonSerializable
{
    /**
     * Date and time in "YYYY-MM-DD hh:mm:ss" format in the UTC timezone. Allows schedule sending up to 24 hours in
     * advance.
     * Example: `2021-11-19 10:00:00`.
     *
     * @var string|null
     */
    private $sendAt;

    /**
     * Custom unsubscribe link. Read more [here](https://docs.unione.io/en/unsubscribe-link).
     * Example: `https://example.org/unsubscribe/&#7b;&#7b;CustomerId&#7c;&#7c;`.
     *
     * @var string|null
     */
    private $unsubscribeUrl;

    /**
     * Backend-domain identifier to send message with. If custom_backend_id is not set, default one for your
     * account/project will be used. You can pay for one or more dedicated IPs and use this option.
     *
     * @var int|null
     */
    private $customBackendId;

    /**
     * SMTP pool identifier to send message with. Usually you don't need to pass this parameter because correct
     * smtp_pool_id is selected automatically based on the default one for your account/project or according to
     * custom_backend_id parameter.
     *
     * @var string|null
     */
    private $smtpPoolId;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->sendAt = Data::string($data['send_at'] ?? null);
        $model->unsubscribeUrl = Data::string($data['unsubscribe_url'] ?? null);
        $model->customBackendId = Data::int($data['custom_backend_id'] ?? null);
        $model->smtpPoolId = Data::string($data['smtp_pool_id'] ?? null);

        return $model;
    }

    /**
     * Date and time in "YYYY-MM-DD hh:mm:ss" format in the UTC timezone.
     */
    public function getSendAt(): ?string
    {
        return $this->sendAt;
    }

    /**
     * Date and time in "YYYY-MM-DD hh:mm:ss" format in the UTC timezone.
     *
     * @return $this
     */
    public function setSendAt(?string $sendAt): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    /**
     * Custom unsubscribe link.
     */
    public function getUnsubscribeUrl(): ?string
    {
        return $this->unsubscribeUrl;
    }

    /**
     * Custom unsubscribe link.
     *
     * @return $this
     */
    public function setUnsubscribeUrl(?string $unsubscribeUrl): self
    {
        $this->unsubscribeUrl = $unsubscribeUrl;

        return $this;
    }

    /**
     * Backend-domain identifier to send message with.
     */
    public function getCustomBackendId(): ?int
    {
        return $this->customBackendId;
    }

    /**
     * Backend-domain identifier to send message with.
     *
     * @return $this
     */
    public function setCustomBackendId(?int $customBackendId): self
    {
        $this->customBackendId = $customBackendId;

        return $this;
    }

    /**
     * SMTP pool identifier to send message with.
     */
    public function getSmtpPoolId(): ?string
    {
        return $this->smtpPoolId;
    }

    /**
     * SMTP pool identifier to send message with.
     *
     * @return $this
     */
    public function setSmtpPoolId(?string $smtpPoolId): self
    {
        $this->smtpPoolId = $smtpPoolId;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'send_at' => $this->sendAt,
            'unsubscribe_url' => $this->unsubscribeUrl,
            'custom_backend_id' => $this->customBackendId,
            'smtp_pool_id' => $this->smtpPoolId,
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
