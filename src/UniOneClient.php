<?php

declare(strict_types=1);

namespace UniOne;

use UniOne\Api\ConfirmedEmail\ConfirmedEmailApi;
use UniOne\Api\Domain\DomainApi;
use UniOne\Api\EmailValidation\EmailValidationApi;
use UniOne\Api\Email\EmailApi;
use UniOne\Api\EventDump\EventDumpApi;
use UniOne\Api\Obsolete\ObsoleteApi;
use UniOne\Api\Project\ProjectApi;
use UniOne\Api\Suppression\SuppressionApi;
use UniOne\Api\System\SystemApi;
use UniOne\Api\Tag\TagApi;
use UniOne\Api\Template\TemplateApi;
use UniOne\Api\Webhook\WebhookApi;
use UniOne\Client\ApiClient;
use UniOne\Client\Configuration;
use UniOne\Client\Transport\TransportInterface;

/**
 * Entry point of the UniOne API client: one accessor per section.
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 * ```
 */
final class UniOneClient
{
    /** @var ApiClient */
    private $client;

    /** @var EmailApi|null */
    private $email;

    /** @var EmailValidationApi|null */
    private $emailValidation;

    /** @var ConfirmedEmailApi|null */
    private $confirmedEmail;

    /** @var TemplateApi|null */
    private $template;

    /** @var WebhookApi|null */
    private $webhook;

    /** @var SuppressionApi|null */
    private $suppression;

    /** @var DomainApi|null */
    private $domain;

    /** @var EventDumpApi|null */
    private $eventDump;

    /** @var TagApi|null */
    private $tag;

    /** @var ProjectApi|null */
    private $project;

    /** @var SystemApi|null */
    private $system;

    /** @var ObsoleteApi|null */
    private $obsolete;

    /**
     * @param TransportInterface|null $transport null: the default cURL transport
     */
    public function __construct(Configuration $config, ?TransportInterface $transport = null)
    {
        $this->client = new ApiClient($config, $transport);
    }

    /**
     * This group of methods is related with email sending.
     */
    public function email(): EmailApi
    {
        if (null === $this->email) {
            $this->email = new EmailApi($this->client);
        }

        return $this->email;
    }

    /**
     * Email validation methods. As a result of the check, you’ll get detailed information on email validity. It will
     * help eliminate nonexistent emails, decrease the number of complaints, clean up the subscribers list and
     * eventually enhance your sender reputation score. For example, you may add validation to a subscription form on
     * your site to let users know they’ve just entered an invalid address.
     */
    public function emailValidation(): EmailValidationApi
    {
        if (null === $this->emailValidation) {
            $this->emailValidation = new EmailValidationApi($this->client);
        }

        return $this->emailValidation;
    }

    /**
     * Manage email addresses confirmed for sandbox-domain sending. These methods are available only with a main
     * account API key.
     */
    public function confirmedEmail(): ConfirmedEmailApi
    {
        if (null === $this->confirmedEmail) {
            $this->confirmedEmail = new ConfirmedEmailApi($this->client);
        }

        return $this->confirmedEmail;
    }

    /**
     * You have the option of storing a template on the UniOne side and then using it by id, which is highly
     * recommended for sending repetitive messages or high volume traffic. UniOne supports two different [template
     * engines](https://docs.unione.io/en/template-engines).
     */
    public function template(): TemplateApi
    {
        if (null === $this->template) {
            $this->template = new TemplateApi($this->client);
        }

        return $this->template;
    }

    /**
     * UniOne lets you recieve notifications about email status changes or spam blocks. You provide an URL and every
     * time a watched event occurs we will notify you by submitting a request with JSON data to this URL.
     */
    public function webhook(): WebhookApi
    {
        if (null === $this->webhook) {
            $this->webhook = new WebhookApi($this->client);
        }

        return $this->webhook;
    }

    /**
     * Methods for managing suppression lists. An email can be added to suppression list because of unsubscription,
     * bounce or complain.
     */
    public function suppression(): SuppressionApi
    {
        if (null === $this->suppression) {
            $this->suppression = new SuppressionApi($this->client);
        }

        return $this->suppression;
    }

    /**
     * You can use these methods to setup sender domains and check their statuses. They might be useful in case you
     * want to automate adding domains for your own clients.
     */
    public function domain(): DomainApi
    {
        if (null === $this->domain) {
            $this->domain = new DomainApi($this->client);
        }

        return $this->domain;
    }

    /**
     * These methods are used to obtain a list of events for a given period of time. The data is stored for up to 45
     * days, depending on your tariff, i. e. you may fetch all event data starting from 00:00:00 31 days ago and up
     * to current time. For custom tarifs with big sending volumes event dumps are available only for the last 7
     * days.
     */
    public function eventDump(): EventDumpApi
    {
        if (null === $this->eventDump) {
            $this->eventDump = new EventDumpApi($this->client);
        }

        return $this->eventDump;
    }

    /**
     * This family of methods is used to manage user-defined tags. Tags are used to categorize letters based on your
     * own criteria, e. g. to create a distinction between marketing and transactional letters or group together all
     * notifications for a particular order type. UniOne allows you to assign tags to all outgoing emails, and the
     * tags you’ve set may then be used to filter and analyze delivery statistics.
     */
    public function tag(): TagApi
    {
        if (null === $this->tag) {
            $this->tag = new TagApi($this->client);
        }

        return $this->tag;
    }

    /**
     * Projects allow you to group several independent domains, webhooks, templates, and unsubscription lists
     * together. It's very useful if you have your own clients and manage their data from a single UniOne account.
     * Each project receives its own API key, and all API calls with that API key only deal with the data of that
     * project. This way, you can assign a separate project for each client and be sure that they won't conflict;
     * e.g. unsubscribing from one project won't affect another.
     */
    public function project(): ProjectApi
    {
        if (null === $this->project) {
            $this->project = new ProjectApi($this->client);
        }

        return $this->project;
    }

    /**
     * System operations.
     */
    public function system(): SystemApi
    {
        if (null === $this->system) {
            $this->system = new SystemApi($this->client);
        }

        return $this->system;
    }

    /**
     * Obsolete methods dealing with unsubscribes. We recommend using the more flexible [suppression](#suppression)
     * methods instead. Note that you can't resubscribe an unsubscribed recipient using WebAPI, but you can send him
     * an email with subscription link using email/subscribe method.
     */
    public function obsolete(): ObsoleteApi
    {
        if (null === $this->obsolete) {
            $this->obsolete = new ObsoleteApi($this->client);
        }

        return $this->obsolete;
    }
}
