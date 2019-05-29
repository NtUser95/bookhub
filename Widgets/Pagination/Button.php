<?php

namespace Widgets\Pagination;


class Button {
	/**
	 * @var bool
	 */
	private $isActive;
	/**
	 * @var int
	 */
	private $pageId;

	public function isActive(): bool
	{
		return $this->isActive;
	}

	/**
	 * @param bool $isActive
	 * @return bool
	 */
	public function setActive(bool $isActive): bool
	{
		$this->isActive = $isActive;
	}

	/**
	 * @return int
	 */
	public function getPageId(): int
	{
		return $this->pageId;
	}

	/**
	 * @param int $pageId
	 */
	public function setPageId(int $pageId)
	{
		$this->pageId = $pageId;
	}
}