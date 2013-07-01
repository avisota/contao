<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2013 Tristan Lins
 *
 * PHP version 5
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    avisota
 * @license    LGPL
 * @filesource
 */

namespace Avisota\Contao;

use Avisota\Contao\Entity\MailingList;
use Avisota\Contao\Entity\Recipient;
use Avisota\Contao\Entity\RecipientBlacklist;
use Avisota\Contao\Entity\RecipientSubscription;
use Avisota\Contao\Event\ConfirmSubscriptionEvent;
use Avisota\Contao\Event\SubscribeEvent;
use Avisota\Contao\Event\UnsubscribeEvent;
use Contao\Doctrine\ORM\EntityHelper;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class SubscriptionManager
 *
 * Manager for subscriptions.
 *
 * Accessible via DI container key avisota.subscription.
 * <pre>
 * global $container;
 * $subscriptionManager = $container->get('avisota.subscription');
 * </pre>
 *
 * @package Avisota
 */
class SubscriptionManager
{
	const BLACKLIST_GLOBAL = 'global';

	const OPT_IGNORE_BLACKLIST = 1;

	const OPT_NO_BLACKLIST = 2;

	const OPT_UNSUBSCRIBE_GLOBAL = 4;

	const OPT_ACTIVATE = 8;

	const OPT_NO_CONFIRMATION = 16;

	public function resolveRecipient($recipient)
	{
		$entityManager = EntityHelper::getEntityManager();
		$repository = $entityManager->getRepository('Avisota\Contao\Entity\Recipient');

		// new recipient
		if (is_array($recipient)) {
			/** @var \Avisota\Contao\Entity\Recipient $recipient */
			$recipient = $repository->findOneBy(array('email' => $recipient['email']));

			$store = false;
			if (!$recipient) {
				$recipient = new Recipient();
				$store = true;
			}
			foreach ($recipient as $key => $value) {
				$setter = 'set' . ucfirst($key);
				$recipient->$setter($value);
			}
			if ($store) {
				$entityManager->persist($recipient);
				$entityManager->flush();
			}
		}

		// by id
		else if (is_numeric($recipient)) {
			/** @var \Avisota\Contao\Entity\Recipient $recipient */
			$recipient = $repository->find($recipient);
		}

		// by email
		else if (is_string($recipient)) {
			/** @var \Avisota\Contao\Entity\Recipient $recipient */
			$recipient = $repository->findOneBy(array('email' => $recipient));
		}

		if (!$recipient instanceof Recipient) {
			throw new \RuntimeException('Invalid argument ' . gettype($recipient));
		}

		return $recipient;
	}

	protected function resolveLists($lists, $includeGlobal = false)
	{
		$lists = (array)$lists;

		if ($includeGlobal && !in_array(static::BLACKLIST_GLOBAL, $lists)) {
			$lists[] = static::BLACKLIST_GLOBAL;
		}

		$lists = array_map(
			function($list) {
				if (is_numeric($list)) {
					return 'mailing_list:' . $list;
				}
				else if ($list instanceof MailingList) {
					return 'mailing_list:' . $list->getId();
				}
				return $list;
			},
			$lists
		);

		return array_values($lists);
	}

	/**
	 * Check if a recipient is blacklisted.
	 *
	 * @param string|array $recipient Recipient email address or array of recipient details.
	 * @param null|array   $lists     Array of mailing lists to check the blacklist status
	 *
	 * @return bool|RecipientBlacklist[]
	 * Return <em>false</em> if the recipient is not blacklisted.
	 * Return an array of blacklisted lists, if <em>$lists</em> is given.
	 * Return <em>true</em> if the recipient is globally blacklisted, even if <em>$lists</em> is provided.
	 */
	public function isBlacklisted($recipient, $lists = null)
	{
		$entityManager = EntityHelper::getEntityManager();

		$recipient = $this->resolveRecipient($recipient);
		$lists     = $this->resolveLists($lists, true);

		$queryBuilder = $entityManager->createQueryBuilder();
		$queryBuilder
			->select('b')
			->from('Avisota\Contao:RecipientBlacklist', 'b')
			->where('b.email=?1')
			->setParameter(1, md5(strtolower($recipient->getEmail())));

		$whereList = array();
		foreach ($lists as $index => $list) {
			$whereList[] = 'b.list=?' . ($index+2);
			$queryBuilder->setParameter($index+2, $list);
		}

		$queryBuilder->orWhere('(' . implode(' OR ', $whereList) . ')');

		$query = $queryBuilder->getQuery();
		$blacklistEntries = $query->getResult();

		if (count($blacklistEntries)) {
			return $blacklistEntries;
		}

		return false;
	}

	/**
	 * Add a new subscription or update existing.
	 *
	 * @param array|int|string|Recipient $recipient
	 * Recipient data (array of details, useful to create a new recipient),
	 * numeric id, email adress or recipient entity..
	 * @param null|array   $lists
	 * <em>null</em> to globally subscribe, or array of mailing lists to subscribe to.
	 *
	 * @return array
	 */
	public function subscribe(
		$recipient,
		$lists = null,
		$options = 0
	) {
		$entityManager = EntityHelper::getEntityManager();
		$subscriptionRepository = $entityManager->getRepository('Avisota\Contao:RecipientSubscription');

		/** @var EventDispatcher $eventDispatcher */
		$eventDispatcher = $GLOBALS['container']['event-dispatcher'];

		$recipient = $this->resolveRecipient($recipient);
		$lists     = $this->resolveLists($lists, true);

		$blacklists = $this->isBlacklisted($recipient, $lists);
		if ($options & static::OPT_IGNORE_BLACKLIST) {
			foreach ($blacklists as $blacklist) {
				$entityManager->detach($blacklist);
			}
		}
		else {
			foreach ($blacklists as $blacklist) {
				if ($blacklist->getList() == static::BLACKLIST_GLOBAL) {
					// break on global blacklist
					return;
				}
				else {
					$pos = array_search($blacklist->getList(), $lists);
					unset($lists[$pos]);
				}
			}
		}

		$subscriptions = array();
		foreach ($lists as $list) {
			$subscription = $subscriptionRepository->findOneBy(
				array(
					 'recipient' => $recipient->getId(),
					 'list' => $list
				)
			);

			if (!$subscription) {
				$subscription = new RecipientSubscription();
				$subscription->setRecipient($recipient->getId());
				$subscription->setList($list);
				if ($options & static::OPT_ACTIVATE) {
					$subscription->setConfirmed(true);
				}
				$subscription->setToken(substr(md5($recipient->getEmail() . '|' . mt_rand() . '|' . microtime(true)), 0, 5));
				$entityManager->persist($subscription);
				$entityManager->flush();

				$eventDispatcher->dispatch('avisota-subscribe', new SubscribeEvent($recipient, $subscription));
			}

			if (!$subscription->getConfirmed()) {
				$subscriptions[] = $subscription;
			}
		}

		if ($options ^ static::OPT_NO_CONFIRMATION) {
			// TODO send confirmations
		}

		return $subscriptions;
	}

	/**
	 * Confirm subscription.
	 *
	 * @param array|int|string|Recipient $recipient
	 * Recipient data (array of details, useful to create a new recipient),
	 * numeric id, email adress or recipient entity..
	 * @param null|array   $lists
	 * <em>null</em> to globally subscribe, or array of mailing lists to subscribe to.
	 *
	 * @return array
	 */
	public function confirm(
		$recipient,
		array $token
	) {
		$entityManager = EntityHelper::getEntityManager();

		/** @var EventDispatcher $eventDispatcher */
		$eventDispatcher = $GLOBALS['container']['event-dispatcher'];

		$recipient = $this->resolveRecipient($recipient);

		$queryBuilder = $entityManager->createQueryBuilder();
		$subscriptions = $queryBuilder
			->select('s')
			->from('Avisota\Contao:RecipientSubscription', 's')
			->where('s.recipient=:recipient')
			->andWhere($queryBuilder->expr()->in('s.list', ':token'))
			->setParameter(':recipient', $recipient->getId())
			->setParameter(':token', $token)
			->getQuery()
			->getResult();

		/** @var RecipientSubscription $subscription */
		foreach ($subscriptions as $subscription) {
			$subscription->setConfirmed(true);
			$subscription->setConfirmedAt(new \DateTime());

			$eventDispatcher->dispatch('avisota-confirm-subscription', new ConfirmSubscriptionEvent($recipient, $subscription));
		}

		return $subscriptions;
	}

	/**
	 * Remove subscription.
	 *
	 * @param string|array $recipient Recipient email address or array of recipient details.
	 * @param null|array   $lists     <em>null</em> to globally unsubscribe from all mailing lists, or array of mailing lists to unsubscribe from.
	 */
	public function unsubscribe($recipient, $lists = null, $options = 0)
	{
		$entityManager = EntityHelper::getEntityManager();
		$subscriptionRepository = $entityManager->getRepository('Avisota\Contao:RecipientSubscription');

		/** @var EventDispatcher $eventDispatcher */
		$eventDispatcher = $GLOBALS['container']['event-dispatcher'];

		if ($options & static::OPT_UNSUBSCRIBE_GLOBAL) {
			$listRepository = $entityManager->getRepository('Avisota\Contao:MailingList');
			$lists = $listRepository->findAll();
		}

		$recipient = $this->resolveRecipient($recipient);
		$lists     = $this->resolveLists($lists);

		$subscriptions = array();

		foreach ($lists as $list) {
			$subscription = $subscriptionRepository->findOneBy(
				array(
					 'recipient' => $recipient->getId(),
					 'list' => $list
				)
			);

			if ($subscription) {
				if ($options ^ static::OPT_NO_BLACKLIST) {
					$blacklist = new RecipientBlacklist();
					$blacklist->setEmail(md5(strtolower($recipient->getEmail())));
					$blacklist->setList($list);
					$entityManager->persist($blacklist);
					$entityManager->flush();
				}

				$entityManager->remove($subscription);
				$entityManager->flush();

				$subscriptions[] = $subscription;

				$eventDispatcher->dispatch('avisota-unsubscribe', new UnsubscribeEvent($recipient, $subscription, $blacklist));
			}
		}

		if ($options ^ static::OPT_NO_CONFIRMATION) {
			// TODO send confirmations
		}
	}
}